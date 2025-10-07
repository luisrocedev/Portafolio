# 🛠️ Guía Completa de Setup - Portafolio V2

## Paso 1: Crear el proyecto Next.js

```bash
# Navegar a la carpeta
cd /Applications/MAMP/htdocs/GitHub/Portafolio/portafolio_v2

# Crear proyecto Next.js con TypeScript y Tailwind
npx create-next-app@latest . --typescript --tailwind --app --use-npm

# Responder a las preguntas:
# ✔ Would you like to use ESLint? ... Yes
# ✔ Would you like to use Tailwind CSS? ... Yes
# ✔ Would you like to use `src/` directory? ... Yes
# ✔ Would you like to use App Router? ... Yes
# ✔ Would you like to customize the default import alias (@/*)? ... No
```

---

## Paso 2: Instalar dependencias principales

```bash
# Dependencias de producción
npm install @supabase/supabase-js framer-motion lucide-react clsx tailwind-merge class-variance-authority

# Dependencias de desarrollo
npm install -D prettier prettier-plugin-tailwindcss
```

---

## Paso 3: Configurar Supabase

### 3.1. Crear cuenta en Supabase

1. Ir a https://supabase.com
2. Crear cuenta (gratuita)
3. Crear nuevo proyecto:
   - Project name: `portafolio-v2`
   - Database password: (guardar en un lugar seguro)
   - Region: `West EU (London)` (más cercana)

### 3.2. Obtener credenciales

1. En el dashboard de Supabase, ir a **Settings** → **API**
2. Copiar:
   - **Project URL** (anon key)
   - **API Key** (anon, public)

### 3.3. Configurar variables de entorno

```bash
# Crear archivo .env.local
touch .env.local
```

Contenido de `.env.local`:

```env
# Supabase
NEXT_PUBLIC_SUPABASE_URL=your-project-url
NEXT_PUBLIC_SUPABASE_ANON_KEY=your-anon-key

# App
NEXT_PUBLIC_SITE_URL=http://localhost:3000
```

---

## Paso 4: Crear schema de base de datos

### 4.1. En Supabase SQL Editor, ejecutar:

```sql
-- Tabla de perfil
CREATE TABLE profile (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  name VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  bio TEXT,
  email VARCHAR(255),
  github VARCHAR(255),
  linkedin VARCHAR(255),
  resume_url VARCHAR(500),
  avatar_url VARCHAR(500),
  updated_at TIMESTAMP DEFAULT NOW()
);

-- Tabla de proyectos
CREATE TABLE projects (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  long_description TEXT,
  image_url VARCHAR(500),
  technologies JSONB DEFAULT '[]',
  github_url VARCHAR(500),
  live_url VARCHAR(500),
  featured BOOLEAN DEFAULT false,
  order_index INTEGER DEFAULT 0,
  created_at TIMESTAMP DEFAULT NOW(),
  updated_at TIMESTAMP DEFAULT NOW()
);

-- Tabla de habilidades
CREATE TABLE skills (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  name VARCHAR(100) NOT NULL,
  category VARCHAR(50) NOT NULL, -- 'frontend', 'backend', 'tools', etc.
  icon VARCHAR(100),
  level INTEGER DEFAULT 3, -- 1-5
  order_index INTEGER DEFAULT 0,
  created_at TIMESTAMP DEFAULT NOW()
);

-- Tabla de experiencia
CREATE TABLE experience (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  company VARCHAR(255) NOT NULL,
  position VARCHAR(255) NOT NULL,
  description TEXT,
  start_date DATE NOT NULL,
  end_date DATE,
  technologies JSONB DEFAULT '[]',
  order_index INTEGER DEFAULT 0,
  created_at TIMESTAMP DEFAULT NOW()
);

-- Insertar perfil inicial
INSERT INTO profile (name, title, bio, email, github, linkedin) VALUES (
  'Luis Jahir Rodríguez Cedeño',
  'Full Stack Developer',
  'Desarrollador en formación con enfoque Full Stack. Actualmente estudio DAM, combinando habilidades de frontend atractivo con lógica backend estructurada.',
  'luisrocedev@gmail.com',
  'https://github.com/luisrocedev',
  'https://es.linkedin.com/in/luisrocedev'
);

-- Insertar algunos proyectos de ejemplo
INSERT INTO projects (title, description, technologies, github_url, live_url, featured, order_index) VALUES
(
  'TaronjaBoxValencia',
  'Web dinámica para centro deportivo',
  '["HTML", "CSS", "JavaScript", "PHP"]',
  'https://github.com/luisrocedev/taronjaboxvalencia',
  'https://taronjaboxvalencia.com',
  true,
  1
),
(
  'PMS Daniya',
  'Sistema de gestión hotelera con reservas, pagos y usuarios',
  '["PHP", "MySQL", "JavaScript", "Bootstrap"]',
  'https://github.com/luisrocedev/PMS-Daniya',
  null,
  true,
  2
),
(
  'TPV Voltereta',
  'Punto de venta con caja, pedidos y chat en tiempo real',
  '["Node.js", "Express", "MySQL", "WebSockets"]',
  'https://github.com/luisrocedev/TPV-Voltereta',
  null,
  true,
  3
);

-- Insertar habilidades de ejemplo
INSERT INTO skills (name, category, level, order_index) VALUES
('JavaScript', 'frontend', 4, 1),
('TypeScript', 'frontend', 3, 2),
('React', 'frontend', 4, 3),
('Next.js', 'frontend', 3, 4),
('Tailwind CSS', 'frontend', 4, 5),
('Node.js', 'backend', 4, 6),
('Express', 'backend', 4, 7),
('PHP', 'backend', 3, 8),
('MySQL', 'backend', 4, 9),
('PostgreSQL', 'backend', 3, 10),
('Git', 'tools', 4, 11),
('Docker', 'tools', 2, 12),
('Supabase', 'tools', 3, 13);
```

### 4.2. Configurar Storage para imágenes

En Supabase Dashboard:

1. Ir a **Storage**
2. Crear bucket: `project-images`
3. Configurar como **Public**
4. Policies → New policy → Select "Allow public access"

---

## Paso 5: Configurar Shadcn/ui

```bash
# Inicializar shadcn/ui
npx shadcn-ui@latest init

# Responder:
# ✔ Would you like to use TypeScript? ... yes
# ✔ Which style would you like to use? › Default
# ✔ Which color would you like to use as base color? › Slate
# ✔ Where is your global CSS file? ... src/app/globals.css
# ✔ Would you like to use CSS variables for colors? ... yes
# ✔ Where is your tailwind.config.js located? ... tailwind.config.ts
# ✔ Configure the import alias for components? ... @/components
# ✔ Configure the import alias for utils? ... @/lib/utils

# Instalar componentes que necesitarás
npx shadcn-ui@latest add button
npx shadcn-ui@latest add card
npx shadcn-ui@latest add input
npx shadcn-ui@latest add label
npx shadcn-ui@latest add textarea
npx shadcn-ui@latest add dialog
npx shadcn-ui@latest add dropdown-menu
npx shadcn-ui@latest add toast
npx shadcn-ui@latest add tabs
```

---

## Paso 6: Estructura de carpetas

```bash
# Crear estructura
mkdir -p src/lib/supabase
mkdir -p src/types
mkdir -p src/hooks
mkdir -p src/components/layout
mkdir -p src/components/sections
mkdir -p src/components/admin
mkdir -p src/app/admin
mkdir -p src/app/api
```

---

## Paso 7: Configurar Supabase Client

Crear `src/lib/supabase/client.ts`:

```typescript
import { createClientComponentClient } from "@supabase/supabase-js";

export const supabase = createClientComponentClient({
  supabaseUrl: process.env.NEXT_PUBLIC_SUPABASE_URL!,
  supabaseKey: process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY!,
});
```

Crear `src/lib/supabase/server.ts`:

```typescript
import { createServerComponentClient } from "@supabase/supabase-js";
import { cookies } from "next/headers";

export const createServerSupabaseClient = () => {
  return createServerComponentClient({ cookies });
};
```

---

## Paso 8: Definir tipos TypeScript

Crear `src/types/database.ts`:

```typescript
export interface Profile {
  id: string;
  name: string;
  title: string;
  bio: string | null;
  email: string | null;
  github: string | null;
  linkedin: string | null;
  resume_url: string | null;
  avatar_url: string | null;
  updated_at: string;
}

export interface Project {
  id: string;
  title: string;
  description: string;
  long_description: string | null;
  image_url: string | null;
  technologies: string[];
  github_url: string | null;
  live_url: string | null;
  featured: boolean;
  order_index: number;
  created_at: string;
  updated_at: string;
}

export interface Skill {
  id: string;
  name: string;
  category: "frontend" | "backend" | "tools" | "other";
  icon: string | null;
  level: number;
  order_index: number;
  created_at: string;
}

export interface Experience {
  id: string;
  company: string;
  position: string;
  description: string | null;
  start_date: string;
  end_date: string | null;
  technologies: string[];
  order_index: number;
  created_at: string;
}
```

---

## Paso 9: Configurar Prettier

Crear `.prettierrc`:

```json
{
  "semi": false,
  "singleQuote": true,
  "tabWidth": 2,
  "trailingComma": "es5",
  "printWidth": 80,
  "plugins": ["prettier-plugin-tailwindcss"]
}
```

Crear `.prettierignore`:

```
node_modules
.next
out
public
*.lock
```

---

## Paso 10: Actualizar tailwind.config.ts

```typescript
import type { Config } from "tailwindcss";

const config: Config = {
  darkMode: ["class"],
  content: [
    "./src/pages/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/components/**/*.{js,ts,jsx,tsx,mdx}",
    "./src/app/**/*.{js,ts,jsx,tsx,mdx}",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["var(--font-inter)"],
        mono: ["var(--font-space-mono)"],
      },
      animation: {
        "fade-in": "fadeIn 0.5s ease-in-out",
        "slide-up": "slideUp 0.5s ease-out",
      },
      keyframes: {
        fadeIn: {
          "0%": { opacity: "0" },
          "100%": { opacity: "1" },
        },
        slideUp: {
          "0%": { transform: "translateY(20px)", opacity: "0" },
          "100%": { transform: "translateY(0)", opacity: "1" },
        },
      },
    },
  },
  plugins: [require("tailwindcss-animate")],
};
export default config;
```

---

## Paso 11: Iniciar el proyecto

```bash
# Iniciar servidor de desarrollo
npm run dev

# Abrir navegador en
# http://localhost:3000
```

---

## Paso 12: Deploy en Vercel (cuando esté listo)

```bash
# Instalar Vercel CLI
npm i -g vercel

# Login
vercel login

# Deploy
vercel

# Configurar variables de entorno en Vercel dashboard:
# - NEXT_PUBLIC_SUPABASE_URL
# - NEXT_PUBLIC_SUPABASE_ANON_KEY
# - NEXT_PUBLIC_SITE_URL
```

---

## 📝 Checklist de Setup

- [ ] Proyecto Next.js creado
- [ ] Dependencias instaladas
- [ ] Cuenta Supabase creada
- [ ] Base de datos configurada
- [ ] Variables de entorno configuradas
- [ ] Shadcn/ui instalado
- [ ] Estructura de carpetas creada
- [ ] Tipos TypeScript definidos
- [ ] Prettier configurado
- [ ] Proyecto corriendo en localhost:3000

---

## 🆘 Troubleshooting

### Error: "Cannot find module '@supabase/supabase-js'"

```bash
npm install @supabase/supabase-js
```

### Error: "Module not found: Can't resolve '@/components/ui/button'"

```bash
npx shadcn-ui@latest add button
```

### Error de tipos TypeScript

```bash
# Reinstalar tipos
npm install -D @types/node @types/react @types/react-dom
```

### Base de datos no conecta

- Verificar que las variables de entorno están en `.env.local`
- Verificar que el proyecto de Supabase está activo
- Revisar que las credenciales son correctas

---

## 📚 Recursos útiles

- [Next.js Docs](https://nextjs.org/docs)
- [Supabase Docs](https://supabase.com/docs)
- [Shadcn/ui Docs](https://ui.shadcn.com)
- [Framer Motion Docs](https://www.framer.com/motion/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)

---

¡Listo para empezar a desarrollar! 🚀
