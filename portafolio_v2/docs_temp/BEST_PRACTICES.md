# ⚡ Mejores Prácticas - Portafolio V2

## 🎯 Filosofía del Proyecto

### Principios Core

```
1. FUNCIONA PRIMERO, BONITO DESPUÉS
   ├── MVP funcionando
   ├── Luego pulir diseño
   └── Finalmente optimizar

2. CÓDIGO LIMPIO Y MANTENIBLE
   ├── TypeScript para seguridad
   ├── Componentes reutilizables
   └── Documentación clara

3. PERFORMANCE DESDE EL INICIO
   ├── Next.js Image
   ├── Code splitting
   └── No librerías innecesarias

4. ITERACIÓN CONTINUA
   ├── Commits frecuentes
   ├── Testing continuo
   └── Mejora constante
```

---

## 💻 Best Practices de Código

### Estructura de Componentes

```typescript
// ✅ BUENO - Componente bien estructurado
import { FC } from "react";
import { Project } from "@/types";

interface ProjectCardProps {
  project: Project;
  featured?: boolean;
}

export const ProjectCard: FC<ProjectCardProps> = ({
  project,
  featured = false,
}) => {
  return <article className="group relative">{/* contenido */}</article>;
};
```

```typescript
// ❌ MALO - Sin tipos, props desestructuradas
export default function ProjectCard(props) {
  return <div>{props.project.title}</div>;
}
```

---

### Naming Conventions

```typescript
// Componentes: PascalCase
export const ProjectCard = () => {};
export const HeroSection = () => {};

// Funciones: camelCase
export const fetchProjects = async () => {};
export const validateForm = (data) => {};

// Constantes: UPPER_SNAKE_CASE
export const API_URL = "https://api.example.com";
export const MAX_FILE_SIZE = 5_000_000;

// Tipos/Interfaces: PascalCase
export interface Project {}
export type UserRole = "admin" | "user";

// Archivos:
// - Componentes: PascalCase.tsx (ProjectCard.tsx)
// - Utilities: camelCase.ts (formatDate.ts)
// - Tipos: camelCase.ts (database.ts)
```

---

### Organización de Imports

```typescript
// 1. Imports externos
import { FC, useState, useEffect } from "react";
import Link from "next/link";
import Image from "next/image";
import { motion } from "framer-motion";

// 2. Imports internos (components)
import { Button } from "@/components/ui/button";
import { Card } from "@/components/ui/card";

// 3. Imports de utils/libs
import { cn } from "@/lib/utils";
import { supabase } from "@/lib/supabase/client";

// 4. Imports de tipos
import type { Project } from "@/types";

// 5. Imports de estilos (si aplica)
import styles from "./component.module.css";
```

---

## 🎨 Best Practices de Diseño

### Sistema de Espaciado Consistente

```typescript
// tailwind.config.ts
export default {
  theme: {
    extend: {
      spacing: {
        // Usa sistema de 4px o 8px
        // Base: 4px
        "18": "4.5rem", // 72px
        "128": "32rem", // 512px
      },
    },
  },
};
```

```tsx
// ✅ BUENO - Espaciado consistente
<div className="p-4 md:p-8 lg:p-12">
  <h1 className="mb-4">Título</h1>
  <p className="mb-8">Texto</p>
</div>

// ❌ MALO - Valores arbitrarios
<div style={{ padding: '17px' }}>
  <h1 style={{ marginBottom: '23px' }}>Título</h1>
</div>
```

---

### Responsive Design

```tsx
// ✅ BUENO - Mobile first
<div className="
  grid
  grid-cols-1           {/* Mobile: 1 columna */}
  md:grid-cols-2        {/* Tablet: 2 columnas */}
  lg:grid-cols-3        {/* Desktop: 3 columnas */}
  gap-4 md:gap-6 lg:gap-8
">
  {projects.map(project => (
    <ProjectCard key={project.id} project={project} />
  ))}
</div>

// ❌ MALO - Desktop first, sin considerar móvil
<div style={{ display: 'flex', gap: '50px' }}>
  {/* Se rompe en móvil */}
</div>
```

---

### Colores Semánticos

```typescript
// tailwind.config.ts
export default {
  theme: {
    extend: {
      colors: {
        // Semánticos, no literales
        primary: "#3b82f6", // Azul principal
        secondary: "#1e293b", // Gris oscuro
        accent: "#f59e0b", // Naranja acento
        danger: "#ef4444", // Rojo error
        success: "#10b981", // Verde éxito

        // ❌ Evita:
        // 'blue': '#3b82f6',
        // 'gray': '#1e293b',
      },
    },
  },
};
```

---

## 🗄️ Best Practices de Base de Datos

### Queries Eficientes

```typescript
// ✅ BUENO - Select solo lo necesario
const { data: projects } = await supabase
  .from("projects")
  .select("id, title, description, image_url")
  .eq("featured", true)
  .order("order_index")
  .limit(6);

// ❌ MALO - Select * todo
const { data: projects } = await supabase.from("projects").select("*");
```

---

### Manejo de Errores

```typescript
// ✅ BUENO - Manejo completo
async function getProjects() {
  try {
    const { data, error } = await supabase.from("projects").select("*");

    if (error) {
      console.error("Database error:", error);
      throw new Error("Failed to fetch projects");
    }

    return data || [];
  } catch (err) {
    console.error("Unexpected error:", err);
    return [];
  }
}

// ❌ MALO - Sin manejo de errores
async function getProjects() {
  const { data } = await supabase.from("projects").select("*");
  return data;
}
```

---

## 🚀 Best Practices de Performance

### Imágenes Optimizadas

```tsx
// ✅ BUENO - Next.js Image
import Image from 'next/image'

<Image
  src={project.image_url}
  alt={project.title}
  width={600}
  height={400}
  loading="lazy"
  placeholder="blur"
  blurDataURL="/placeholder.jpg"
  sizes="(max-width: 768px) 100vw, 600px"
/>

// ❌ MALO - <img> normal
<img src={project.image_url} alt={project.title} />
```

---

### Code Splitting

```typescript
// ✅ BUENO - Lazy loading de componentes pesados
import dynamic from "next/dynamic";

const HeavyChart = dynamic(() => import("@/components/HeavyChart"), {
  loading: () => <div>Loading chart...</div>,
  ssr: false, // Solo en cliente si es necesario
});

// ❌ MALO - Importar todo al inicio
import { HeavyChart } from "@/components/HeavyChart";
```

---

### Memoización Inteligente

```typescript
// ✅ BUENO - Memoizar cálculos costosos
import { useMemo } from "react";

function ProjectsList({ projects }) {
  const sortedProjects = useMemo(() => {
    return projects.sort((a, b) => b.order_index - a.order_index);
  }, [projects]);

  return <div>{/* render */}</div>;
}

// ❌ MALO - Recalcular en cada render
function ProjectsList({ projects }) {
  const sortedProjects = projects.sort((a, b) => b.order_index - a.order_index);
  return <div>{/* render */}</div>;
}
```

---

## 🔐 Best Practices de Seguridad

### Variables de Entorno

```typescript
// ✅ BUENO - Variables separadas
// .env.local
NEXT_PUBLIC_SUPABASE_URL=https://xxx.supabase.co
NEXT_PUBLIC_SUPABASE_ANON_KEY=public-key
SUPABASE_SERVICE_KEY=secret-key // No exponer al cliente

// En código:
const supabaseUrl = process.env.NEXT_PUBLIC_SUPABASE_URL!
const supabaseKey = process.env.NEXT_PUBLIC_SUPABASE_ANON_KEY!

// ❌ MALO - Hardcodear keys
const supabase = createClient(
  'https://myproject.supabase.co',
  'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...'
)
```

---

### Validación de Inputs

```typescript
// ✅ BUENO - Validar con Zod
import { z } from "zod";

const projectSchema = z.object({
  title: z.string().min(3).max(100),
  description: z.string().min(10).max(500),
  technologies: z.array(z.string()),
  github_url: z.string().url().optional(),
});

function validateProject(data: unknown) {
  return projectSchema.parse(data);
}

// ❌ MALO - Sin validación
function createProject(data: any) {
  await supabase.from("projects").insert(data);
}
```

---

### Autenticación en API Routes

```typescript
// ✅ BUENO - Verificar auth en cada request
import { createServerSupabaseClient } from "@/lib/supabase/server";

export async function POST(request: Request) {
  const supabase = createServerSupabaseClient();

  const {
    data: { user },
    error,
  } = await supabase.auth.getUser();

  if (error || !user) {
    return new Response("Unauthorized", { status: 401 });
  }

  // Proceder con la lógica
}

// ❌ MALO - Sin verificar auth
export async function POST(request: Request) {
  const body = await request.json();
  await supabase.from("projects").insert(body);
}
```

---

## 📝 Best Practices de Git

### Commits Descriptivos

```bash
# ✅ BUENO - Conventional Commits
git commit -m "feat: add project card component"
git commit -m "fix: responsive layout on mobile"
git commit -m "style: improve hero section spacing"
git commit -m "refactor: extract form validation logic"
git commit -m "docs: update README with setup instructions"

# Tipos:
# feat: Nueva feature
# fix: Bug fix
# style: Cambios visuales (no lógica)
# refactor: Refactorización (no cambia funcionalidad)
# docs: Documentación
# test: Tests
# chore: Tareas de mantenimiento

# ❌ MALO - Commits vagos
git commit -m "update"
git commit -m "fix stuff"
git commit -m "changes"
```

---

### Branching Strategy

```bash
# Estructura de branches
main              # Producción (siempre estable)
├── develop       # Desarrollo (integración)
│   ├── feature/hero-section
│   ├── feature/admin-panel
│   └── feature/animations

# Workflow:
# 1. Crear feature branch desde develop
git checkout -b feature/project-card

# 2. Desarrollar y commitear
git add .
git commit -m "feat: add project card component"

# 3. Push y crear PR
git push origin feature/project-card

# 4. Merge a develop después de review
# 5. Merge a main cuando esté listo para producción
```

---

## 🧪 Best Practices de Testing

### Testing Piramid

```
       /\
      /E2E\      ← Pocos (flujos críticos)
     /─────\
    /Integr.\   ← Algunos (componentes + API)
   /─────────\
  /   Unit    \ ← Muchos (funciones puras)
 /─────────────\
```

```typescript
// Unit Test - Función pura
import { formatDate } from "@/lib/utils";

describe("formatDate", () => {
  it("should format date correctly", () => {
    const date = new Date("2025-10-03");
    expect(formatDate(date)).toBe("3 Oct 2025");
  });
});

// Component Test
import { render, screen } from "@testing-library/react";
import { ProjectCard } from "@/components/ProjectCard";

describe("ProjectCard", () => {
  it("should render project title", () => {
    const project = { id: "1", title: "Test Project" };
    render(<ProjectCard project={project} />);
    expect(screen.getByText("Test Project")).toBeInTheDocument();
  });
});

// E2E Test (Playwright)
import { test, expect } from "@playwright/test";

test("user can create a project", async ({ page }) => {
  await page.goto("/admin/projects/new");
  await page.fill('input[name="title"]', "New Project");
  await page.click('button[type="submit"]');
  await expect(page.locator(".toast")).toContainText("Project created");
});
```

---

## 📊 Best Practices de Monitoreo

### Console Logs Estratégicos

```typescript
// ✅ BUENO - Logs informativos en desarrollo
if (process.env.NODE_ENV === "development") {
  console.log("[ProjectCard] Rendering with:", { project });
}

// En producción, usar error tracking
try {
  await fetchProjects();
} catch (error) {
  console.error("[API] Failed to fetch projects:", error);
  // Enviar a Sentry, LogRocket, etc.
}

// ❌ MALO - Console.logs en producción
console.log("hola");
console.log(data);
```

---

### Performance Monitoring

```typescript
// Medir tiempos de carga
export async function getServerSideProps() {
  const start = performance.now();

  const projects = await fetchProjects();

  const end = performance.now();
  console.log(`[SSR] Projects fetched in ${end - start}ms`);

  return { props: { projects } };
}
```

---

## 🎯 Best Practices de UX

### Loading States

```typescript
// ✅ BUENO - Feedback visual
function ProjectsList() {
  const [loading, setLoading] = useState(true);
  const [projects, setProjects] = useState([]);

  useEffect(() => {
    fetchProjects().then((data) => {
      setProjects(data);
      setLoading(false);
    });
  }, []);

  if (loading) {
    return <ProjectsSkeleton />;
  }

  return <ProjectsGrid projects={projects} />;
}

// ❌ MALO - Sin feedback
function ProjectsList() {
  const [projects, setProjects] = useState([]);

  useEffect(() => {
    fetchProjects().then(setProjects);
  }, []);

  return <ProjectsGrid projects={projects} />; // Puede estar vacío
}
```

---

### Error States

```typescript
// ✅ BUENO - Manejo de errores UX-friendly
function ProjectsList() {
  const [error, setError] = useState<string | null>(null);

  if (error) {
    return (
      <div className="text-center p-8">
        <p className="text-red-600 mb-4">{error}</p>
        <Button onClick={refetch}>Reintentar</Button>
      </div>
    );
  }

  return <ProjectsGrid projects={projects} />;
}
```

---

### Empty States

```typescript
// ✅ BUENO - Estado vacío con acción
function ProjectsList({ projects }) {
  if (projects.length === 0) {
    return (
      <div className="text-center p-12">
        <p className="text-gray-500 mb-4">No hay proyectos todavía</p>
        <Button asChild>
          <Link href="/admin/projects/new">Crear primer proyecto</Link>
        </Button>
      </div>
    );
  }

  return <ProjectsGrid projects={projects} />;
}
```

---

## 🚀 Checklist Pre-Deploy

### Antes de hacer deploy:

```bash
# ✅ Performance
□ Lighthouse score 90+ en todas las categorías
□ Imágenes optimizadas (WebP, tamaños correctos)
□ Bundle size < 200KB (inicial)
□ No console.logs en producción

# ✅ SEO
□ Meta tags en todas las páginas
□ OpenGraph images
□ Sitemap.xml
□ Robots.txt
□ Structured data (JSON-LD)

# ✅ Seguridad
□ Variables de entorno configuradas
□ No API keys en código
□ Autenticación funcionando
□ CORS configurado

# ✅ Funcionalidad
□ Todos los links funcionan
□ Formularios validan correctamente
□ Upload de imágenes funciona
□ Mobile responsive
□ Dark mode funciona

# ✅ Testing
□ Flujos críticos testeados
□ No errores en consola
□ Testeado en diferentes navegadores
□ Testeado en diferentes dispositivos
```

---

## 📚 Recursos de Referencia

### Documentación Oficial

- [Next.js Best Practices](https://nextjs.org/docs/app/building-your-application/optimizing)
- [React Best Practices](https://react.dev/learn/thinking-in-react)
- [Tailwind Best Practices](https://tailwindcss.com/docs/reusing-styles)
- [TypeScript Do's and Don'ts](https://www.typescriptlang.org/docs/handbook/declaration-files/do-s-and-don-ts.html)

### Style Guides

- [Airbnb JavaScript Style Guide](https://github.com/airbnb/javascript)
- [Google TypeScript Style Guide](https://google.github.io/styleguide/tsguide.html)

---

## 🎓 Aprende Más

### Blogs Recomendados

- [Kent C. Dodds](https://kentcdodds.com/blog)
- [Josh Comeau](https://www.joshwcomeau.com/)
- [Dan Abramov](https://overreacted.io/)
- [Lee Robinson (Vercel)](https://leerob.io/)

### Canales de YouTube

- [Theo - t3.gg](https://www.youtube.com/@t3dotgg)
- [Web Dev Simplified](https://www.youtube.com/@WebDevSimplified)
- [Fireship](https://www.youtube.com/@Fireship)

---

## ✅ Resumen de Mejores Prácticas

```
CÓDIGO
├── TypeScript siempre
├── Componentes pequeños y reutilizables
├── Props bien tipadas
└── Nombres descriptivos

DISEÑO
├── Mobile first
├── Sistema de espaciado consistente
├── Colores semánticos
└── Accesibilidad (a11y)

PERFORMANCE
├── Next.js Image para todas las imágenes
├── Code splitting para componentes pesados
├── Memoización inteligente
└── Bundle size bajo

SEGURIDAD
├── Variables de entorno
├── Validación de inputs
├── Auth en todas las rutas protegidas
└── Nunca confiar en el cliente

GIT
├── Commits descriptivos (Conventional Commits)
├── Branches por feature
├── PRs con descripción
└── Code review

UX
├── Loading states
├── Error states
├── Empty states
└── Feedback inmediato
```

---

**¡Sigue estas prácticas y tendrás un código profesional y mantenible! 🚀**
