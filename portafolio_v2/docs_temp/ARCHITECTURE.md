# 🏗️ Arquitectura del Proyecto - Portafolio V2

## 📐 Diagrama de Arquitectura

```
┌─────────────────────────────────────────────────────────────┐
│                        FRONTEND                              │
│                   Next.js 14 App Router                      │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐      │
│  │   Public     │  │    Admin     │  │   API Routes │      │
│  │   Routes     │  │    Panel     │  │              │      │
│  └──────────────┘  └──────────────┘  └──────────────┘      │
│         │                  │                  │              │
│         └──────────────────┴──────────────────┘              │
│                           │                                   │
│                           ▼                                   │
│              ┌────────────────────────┐                      │
│              │  Supabase Client       │                      │
│              │  - Auth                │                      │
│              │  - Database queries    │                      │
│              │  - Storage             │                      │
│              └────────────────────────┘                      │
│                           │                                   │
└───────────────────────────┼───────────────────────────────────┘
                            │
                            ▼
         ┌──────────────────────────────────────┐
         │           SUPABASE                    │
         ├──────────────────────────────────────┤
         │  ┌────────────┐  ┌─────────────┐    │
         │  │ PostgreSQL │  │   Storage   │    │
         │  │ Database   │  │   Bucket    │    │
         │  └────────────┘  └─────────────┘    │
         │  ┌────────────┐  ┌─────────────┐    │
         │  │    Auth    │  │   Realtime  │    │
         │  │  Service   │  │   Engine    │    │
         │  └────────────┘  └─────────────┘    │
         └──────────────────────────────────────┘
```

---

## 🗂️ Estructura de Archivos Detallada

```
portafolio_v2/
│
├── src/
│   │
│   ├── app/                          # App Router de Next.js
│   │   │
│   │   ├── (public)/                 # Grupo de rutas públicas
│   │   │   ├── layout.tsx            # Layout público (header, footer)
│   │   │   ├── page.tsx              # Home page
│   │   │   ├── about/
│   │   │   │   └── page.tsx          # Página sobre mí
│   │   │   ├── projects/
│   │   │   │   ├── page.tsx          # Lista de proyectos
│   │   │   │   └── [id]/
│   │   │   │       └── page.tsx      # Detalle de proyecto
│   │   │   └── contact/
│   │   │       └── page.tsx          # Página de contacto
│   │   │
│   │   ├── admin/                    # Panel administrativo
│   │   │   ├── layout.tsx            # Layout admin (sidebar)
│   │   │   ├── page.tsx              # Dashboard
│   │   │   ├── login/
│   │   │   │   └── page.tsx          # Login page
│   │   │   ├── projects/
│   │   │   │   ├── page.tsx          # Lista (CRUD)
│   │   │   │   ├── new/
│   │   │   │   │   └── page.tsx      # Crear proyecto
│   │   │   │   └── [id]/
│   │   │   │       └── page.tsx      # Editar proyecto
│   │   │   ├── skills/
│   │   │   │   └── page.tsx          # Gestión de skills
│   │   │   ├── experience/
│   │   │   │   └── page.tsx          # Gestión de experiencia
│   │   │   └── settings/
│   │   │       └── page.tsx          # Configuración del perfil
│   │   │
│   │   ├── api/                      # API Routes
│   │   │   ├── projects/
│   │   │   │   ├── route.ts          # GET, POST
│   │   │   │   └── [id]/
│   │   │   │       └── route.ts      # GET, PUT, DELETE
│   │   │   ├── skills/
│   │   │   │   └── route.ts
│   │   │   ├── upload/
│   │   │   │   └── route.ts          # Upload de imágenes
│   │   │   └── contact/
│   │   │       └── route.ts          # Form de contacto
│   │   │
│   │   ├── layout.tsx                # Root layout
│   │   ├── globals.css               # Estilos globales
│   │   ├── not-found.tsx             # Página 404
│   │   └── error.tsx                 # Página de error
│   │
│   ├── components/                   # Componentes reutilizables
│   │   │
│   │   ├── ui/                       # Componentes base (shadcn)
│   │   │   ├── button.tsx
│   │   │   ├── card.tsx
│   │   │   ├── input.tsx
│   │   │   ├── dialog.tsx
│   │   │   └── ...
│   │   │
│   │   ├── layout/                   # Componentes de layout
│   │   │   ├── Header.tsx
│   │   │   ├── Footer.tsx
│   │   │   ├── Sidebar.tsx
│   │   │   └── MobileMenu.tsx
│   │   │
│   │   ├── sections/                 # Secciones de la página
│   │   │   ├── Hero.tsx              # Hero section
│   │   │   ├── About.tsx             # Sobre mí
│   │   │   ├── ProjectsGrid.tsx      # Grid de proyectos
│   │   │   ├── ProjectCard.tsx       # Tarjeta individual
│   │   │   ├── SkillsSection.tsx     # Sección de skills
│   │   │   ├── ExperienceTimeline.tsx
│   │   │   └── ContactForm.tsx       # Formulario de contacto
│   │   │
│   │   └── admin/                    # Componentes del admin
│   │       ├── AdminSidebar.tsx
│   │       ├── ProjectForm.tsx
│   │       ├── SkillForm.tsx
│   │       ├── ImageUpload.tsx
│   │       └── DataTable.tsx
│   │
│   ├── lib/                          # Utilidades y configuraciones
│   │   ├── supabase/
│   │   │   ├── client.ts             # Cliente para client components
│   │   │   ├── server.ts             # Cliente para server components
│   │   │   └── middleware.ts         # Middleware de auth
│   │   ├── utils.ts                  # Funciones utilitarias
│   │   ├── constants.ts              # Constantes
│   │   └── validations.ts            # Schemas de validación (Zod)
│   │
│   ├── types/                        # TypeScript types
│   │   ├── database.ts               # Tipos de la DB
│   │   ├── api.ts                    # Tipos de las APIs
│   │   └── index.ts                  # Export central
│   │
│   └── hooks/                        # Custom React hooks
│       ├── useProjects.ts            # Hook para proyectos
│       ├── useSkills.ts              # Hook para skills
│       ├── useAuth.ts                # Hook de autenticación
│       └── useMediaQuery.ts          # Hook responsive
│
├── public/                           # Archivos estáticos
│   ├── images/
│   │   ├── avatar.jpg
│   │   └── og-image.jpg              # Open Graph image
│   ├── fonts/                        # Fuentes custom (opcional)
│   └── icons/
│       └── favicon.ico
│
├── .env.local                        # Variables de entorno (NO subir a git)
├── .env.example                      # Ejemplo de .env
├── .gitignore
├── .prettierrc
├── .prettierignore
├── .eslintrc.json
├── next.config.js
├── tailwind.config.ts
├── tsconfig.json
├── package.json
├── README.md
├── SETUP_GUIDE.md
└── TECH_DECISIONS.md
```

---

## 🔄 Flujo de Datos

### 1. Ruta Pública (Ejemplo: Ver proyectos)

```
Usuario visita /projects
         ↓
Next.js Server Component (page.tsx)
         ↓
Fetch data desde Supabase (Server-side)
         ↓
Renderiza HTML con datos (SSG/ISR)
         ↓
Envía al navegador (HTML + mínimo JS)
         ↓
Framer Motion anima la entrada
```

**Ventajas**:

- SEO perfecto (HTML completo)
- Carga inicial rápida
- Menos JavaScript al cliente

---

### 2. Panel Admin (Ejemplo: Crear proyecto)

```
Admin crea proyecto en formulario
         ↓
Client Component valida con Zod
         ↓
Envía POST a /api/projects
         ↓
API Route verifica auth (middleware)
         ↓
Inserta en Supabase
         ↓
Retorna respuesta
         ↓
Actualiza UI (Optimistic Update)
         ↓
Muestra toast de éxito
```

**Ventajas**:

- Validación en cliente y servidor
- Feedback inmediato (optimistic UI)
- Seguro (auth en backend)

---

## 🔐 Sistema de Autenticación

### Flujo de Login

```
1. Usuario ingresa email/password
   ↓
2. Supabase Auth valida credenciales
   ↓
3. Retorna JWT token
   ↓
4. Token se guarda en cookie (httpOnly)
   ↓
5. Middleware verifica token en cada request
   ↓
6. Si válido → acceso permitido
   Si inválido → redirect a /admin/login
```

### Protección de rutas

```typescript
// middleware.ts
export function middleware(request: NextRequest) {
  const token = request.cookies.get("sb-access-token");

  if (!token && request.nextUrl.pathname.startsWith("/admin")) {
    return NextResponse.redirect(new URL("/admin/login", request.url));
  }

  return NextResponse.next();
}

export const config = {
  matcher: "/admin/:path*",
};
```

---

## 📊 Modelo de Datos (Relaciones)

```
┌─────────────┐
│   Profile   │
│  (1 record) │
└─────────────┘
      │
      │ Has many
      ▼
┌─────────────┐      ┌──────────────┐
│  Projects   │◄────►│ Technologies │
│  (N records)│      │   (Array)    │
└─────────────┘      └──────────────┘
      │
      │ Can be filtered by
      ▼
┌─────────────┐
│   Skills    │
│  (N records)│
└─────────────┘
      │
      │ Grouped by
      ▼
┌─────────────┐
│  Category   │
│  (frontend, │
│  backend...)│
└─────────────┘

┌──────────────┐
│  Experience  │
│  (N records) │
└──────────────┘
```

**Nota**: No hay relaciones FK en este diseño simple, pero se pueden agregar en el futuro.

---

## 🎨 Sistema de Componentes

### Jerarquía de componentes (Atomic Design)

```
Atoms (ui/)
├── Button
├── Input
├── Card
└── Badge

Molecules (sections/)
├── ProjectCard (Button + Badge + Image)
├── SkillBadge (Badge + Icon)
└── FormField (Label + Input + Error)

Organisms (sections/)
├── ProjectsGrid (ProjectCard[])
├── SkillsSection (SkillBadge[])
└── ContactForm (FormField[])

Templates (layout/)
├── Header (Logo + Nav)
├── Footer (Links + Social)
└── AdminLayout (Sidebar + Content)

Pages (app/)
├── Home (Hero + Projects + Skills)
├── Projects (ProjectsGrid + Filters)
└── Admin (AdminLayout + CRUD)
```

---

## 🚀 Estrategias de Rendering

### Static Generation (SSG)

**Usado en**: Home, About

```typescript
// app/page.tsx
export default async function HomePage() {
  const profile = await getProfile(); // Fetch en build time
  return <Hero profile={profile} />;
}

// Se genera HTML estático en build
```

### Incremental Static Regeneration (ISR)

**Usado en**: Projects list

```typescript
// app/projects/page.tsx
export const revalidate = 60; // Revalida cada 60 segundos

export default async function ProjectsPage() {
  const projects = await getProjects();
  return <ProjectsGrid projects={projects} />;
}
```

### Client-Side Rendering (CSR)

**Usado en**: Admin panel, formularios

```typescript
"use client";

export function ProjectForm() {
  const [loading, setLoading] = useState(false);

  async function handleSubmit(data) {
    setLoading(true);
    await fetch("/api/projects", {
      method: "POST",
      body: JSON.stringify(data),
    });
    setLoading(false);
  }

  return <form onSubmit={handleSubmit}>...</form>;
}
```

---

## 📱 Diseño Responsive

### Breakpoints Strategy

```
Mobile First Approach:

1. Base (< 640px)
   - Stack vertical
   - Menú hamburguesa
   - Proyectos: 1 columna

2. Tablet (≥ 768px)
   - Menú horizontal
   - Proyectos: 2 columnas
   - Sidebar visible

3. Desktop (≥ 1024px)
   - Layout completo
   - Proyectos: 3 columnas
   - Animaciones completas

4. Large (≥ 1280px)
   - Max-width contenedor
   - Tipografía más grande
   - Espaciado aumentado
```

---

## ⚡ Optimizaciones de Performance

### 1. Imágenes

```typescript
import Image from "next/image";

<Image
  src="/project.jpg"
  alt="Project"
  width={600}
  height={400}
  loading="lazy"
  placeholder="blur"
  sizes="(max-width: 768px) 100vw, 600px"
/>;
```

### 2. Code Splitting

```typescript
import dynamic from "next/dynamic";

const HeavyComponent = dynamic(() => import("./Heavy"), {
  loading: () => <Spinner />,
  ssr: false, // Solo en cliente si es necesario
});
```

### 3. Fonts

```typescript
import { Inter, Space_Grotesk } from "next/font/google";

const inter = Inter({
  subsets: ["latin"],
  display: "swap",
  variable: "--font-inter",
});
```

### 4. Caching

```typescript
// API Routes con cache
export async function GET() {
  const data = await getProjects();

  return NextResponse.json(data, {
    headers: {
      "Cache-Control": "public, s-maxage=60, stale-while-revalidate=120",
    },
  });
}
```

---

## 🧪 Testing Strategy (Futuro)

```
Unit Tests (Vitest)
├── lib/utils.test.ts
├── lib/validations.test.ts
└── hooks/useProjects.test.ts

Component Tests (RTL)
├── components/ui/Button.test.tsx
├── components/sections/ProjectCard.test.tsx
└── components/sections/ContactForm.test.tsx

E2E Tests (Playwright)
├── e2e/public-pages.spec.ts
├── e2e/admin-crud.spec.ts
└── e2e/contact-form.spec.ts
```

---

## 🔄 CI/CD Pipeline (Vercel)

```
1. Push a GitHub
   ↓
2. Vercel detecta cambios
   ↓
3. Instala dependencias
   ↓
4. Run linting
   ↓
5. Build Next.js
   ↓
6. Deploy a preview URL
   ↓
7. Si es main → Deploy a producción
   ↓
8. Notificación en Discord/Slack
```

---

## 📈 Métricas a Monitorear

### Performance

- **FCP**: < 1.5s
- **LCP**: < 2.5s
- **CLS**: < 0.1
- **TTI**: < 3.5s

### SEO

- Lighthouse SEO: 100/100
- Core Web Vitals: All Green

### Usabilidad

- Bounce rate: < 40%
- Avg. session duration: > 2min
- Proyectos más visitados

---

## 🎯 Futuras Expansiones

1. **Blog con MDX**

   - `app/blog/[slug]/page.tsx`
   - Tabla `posts` en Supabase

2. **Búsqueda**

   - Algolia o búsqueda full-text en PostgreSQL

3. **Analytics Dashboard**

   - Gráficas de visitas por proyecto
   - Mapa de visitantes

4. **API Pública**

   - `GET /api/v1/projects`
   - Rate limiting con Upstash

5. **Modo Presentación**
   - Vista optimizada para pantallas grandes
   - Control por teclado

---

¡Arquitectura completa y lista para escalar! 🚀
