# 🚀 Inicio Rápido - Portafolio V2

## ⚡ Empezar en 10 minutos

### 1️⃣ Crear el proyecto (2 min)

```bash
cd /Applications/MAMP/htdocs/GitHub/Portafolio/portafolio_v2

npx create-next-app@latest . --typescript --tailwind --app --use-npm
# Responde 'Yes' a todo excepto "customize import alias"
```

### 2️⃣ Instalar dependencias (1 min)

```bash
npm install @supabase/supabase-js framer-motion lucide-react clsx tailwind-merge
```

### 3️⃣ Configurar Supabase (5 min)

1. Ve a https://supabase.com y crea cuenta
2. Crea nuevo proyecto → espera 2 minutos
3. Ve a Settings → API → copia las credenciales
4. Crea `.env.local` y pega:

```env
NEXT_PUBLIC_SUPABASE_URL=tu-url-aqui
NEXT_PUBLIC_SUPABASE_ANON_KEY=tu-key-aqui
NEXT_PUBLIC_SITE_URL=http://localhost:3000
```

### 4️⃣ Crear base de datos (2 min)

En Supabase → SQL Editor → pega esto:

```sql
CREATE TABLE profile (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  name VARCHAR(255) NOT NULL,
  title VARCHAR(255) NOT NULL,
  bio TEXT,
  email VARCHAR(255),
  github VARCHAR(255),
  linkedin VARCHAR(255),
  avatar_url VARCHAR(500),
  updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE projects (
  id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  image_url VARCHAR(500),
  technologies JSONB DEFAULT '[]',
  github_url VARCHAR(500),
  live_url VARCHAR(500),
  featured BOOLEAN DEFAULT false,
  order_index INTEGER DEFAULT 0,
  created_at TIMESTAMP DEFAULT NOW()
);

INSERT INTO profile (name, title, bio, email, github, linkedin) VALUES (
  'Luis Rodriguez',
  'Full Stack Developer',
  'Desarrollador apasionado por crear experiencias web increíbles.',
  'luisrocedev@gmail.com',
  'https://github.com/luisrocedev',
  'https://linkedin.com/in/luisrocedev'
);

INSERT INTO projects (title, description, technologies, github_url, featured, order_index) VALUES
('TaronjaBoxValencia', 'Web dinámica para centro deportivo', '["HTML", "CSS", "JavaScript"]', 'https://github.com/luisrocedev/taronjaboxvalencia', true, 1),
('PMS Daniya', 'Sistema de gestión hotelera', '["PHP", "MySQL"]', 'https://github.com/luisrocedev/PMS-Daniya', true, 2);
```

Click "Run" →

### 5️⃣ Iniciar proyecto

```bash
npm run dev
```

Abre http://localhost:3000 🎉

---

## 📁 Próximos pasos

### Paso 1: Configurar estructura

```bash
mkdir -p src/lib/supabase src/types src/components/{ui,layout,sections}
```

### Paso 2: Crear cliente Supabase

`src/lib/supabase/client.ts`:

```typescript
import { createClient } from "@supabase/supabase-js";

export const supabase = createClient(
  process.env.NEXT_PUBLIC_SUPABASE_URL!,
  process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY!
);
```

### Paso 3: Crear tipos

`src/types/index.ts`:

```typescript
export interface Project {
  id: string;
  title: string;
  description: string;
  image_url: string | null;
  technologies: string[];
  github_url: string | null;
  live_url: string | null;
  featured: boolean;
}
```

### Paso 4: Crear página home

`src/app/page.tsx`:

```typescript
import { supabase } from "@/lib/supabase/client";
import type { Project } from "@/types";

export default async function Home() {
  const { data: projects } = await supabase
    .from("projects")
    .select("*")
    .eq("featured", true)
    .order("order_index");

  return (
    <main className="min-h-screen p-24">
      <h1 className="text-4xl font-bold mb-8">Mis Proyectos</h1>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {projects?.map((project: Project) => (
          <div key={project.id} className="border p-6 rounded-lg">
            <h2 className="text-2xl font-semibold mb-2">{project.title}</h2>
            <p className="text-gray-600 mb-4">{project.description}</p>
            <div className="flex gap-2 flex-wrap">
              {project.technologies.map((tech) => (
                <span
                  key={tech}
                  className="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm"
                >
                  {tech}
                </span>
              ))}
            </div>
          </div>
        ))}
      </div>
    </main>
  );
}
```

¡Ya tienes un portafolio funcionando con datos dinámicos! 🎊

---

## 🎨 Personalización rápida

### Cambiar colores

`tailwind.config.ts`:

```typescript
theme: {
  extend: {
    colors: {
      primary: '#3b82f6',
      secondary: '#1e293b',
    }
  }
}
```

### Agregar fuente custom

`src/app/layout.tsx`:

```typescript
import { Inter } from "next/font/google";

const inter = Inter({ subsets: ["latin"] });

export default function RootLayout({
  children,
}: {
  children: React.ReactNode;
}) {
  return (
    <html lang="es" className={inter.className}>
      <body>{children}</body>
    </html>
  );
}
```

---

## 🐛 Solución de problemas comunes

### Error: "Module not found @supabase/supabase-js"

```bash
npm install @supabase/supabase-js
```

### Error: Variables de entorno undefined

- Verifica que `.env.local` existe
- Reinicia el servidor (`Ctrl+C` y `npm run dev`)
- Las variables deben empezar con `NEXT_PUBLIC_`

### Base de datos no conecta

- Verifica las credenciales en Supabase dashboard
- Asegúrate que el proyecto está activo (no pausado)

### Página en blanco

- Revisa la consola del navegador (F12)
- Revisa la terminal de Node.js
- Verifica que la query a Supabase no tiene errores

---

## 📚 Recursos útiles

- **Next.js**: https://nextjs.org/docs
- **Supabase**: https://supabase.com/docs
- **Tailwind**: https://tailwindcss.com/docs
- **TypeScript**: https://www.typescriptlang.org/docs

---

## 🎯 Siguientes features a agregar

1. **Dark mode** (1h)
2. **Navegación** con Header y Footer (2h)
3. **Página de detalle** de proyecto (2h)
4. **Formulario de contacto** (3h)
5. **Animaciones** con Framer Motion (4h)
6. **Panel admin** (15h)

---

## 💬 ¿Necesitas ayuda?

Revisa:

- `README.md` - Overview del proyecto
- `SETUP_GUIDE.md` - Guía completa paso a paso
- `TECH_DECISIONS.md` - Por qué elegimos cada tecnología
- `ARCHITECTURE.md` - Cómo está estructurado todo
- `ROADMAP.md` - Plan completo de desarrollo

---

¡Happy coding! 🚀
