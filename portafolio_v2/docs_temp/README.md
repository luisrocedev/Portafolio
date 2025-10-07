# 🚀 Portafolio V2 - Luis Rodriguez

## Portafolio profesional dinámico con Next.js 14 y base de datos

> **Estado del proyecto**: 🚧 En planificación - Listo para empezar desarrollo  
> **Última actualización**: 3 de octubre de 2025

[![Next.js](https://img.shields.io/badge/Next.js-14-black?style=flat-square&logo=next.js)](https://nextjs.org/)
[![TypeScript](https://img.shields.io/badge/TypeScript-5-blue?style=flat-square&logo=typescript)](https://www.typescriptlang.org/)
[![Supabase](https://img.shields.io/badge/Supabase-PostgreSQL-green?style=flat-square&logo=supabase)](https://supabase.com/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38bdf8?style=flat-square&logo=tailwind-css)](https://tailwindcss.com/)
[![License](https://img.shields.io/badge/License-MIT-yellow?style=flat-square)](LICENSE)

---

## 📚 Documentación Completa

Este proyecto incluye **10 documentos de guía completa**. Empieza por aquí:

### 🚀 Para Empezar Rápido

- **[INDEX.md](./INDEX.md)** - 📍 **EMPIEZA AQUÍ** - Guía de navegación de toda la documentación
- **[QUICKSTART.md](./QUICKSTART.md)** - ⚡ Inicio rápido en 10 minutos
- **[EXECUTIVE_SUMMARY.md](./EXECUTIVE_SUMMARY.md)** - 📋 Resumen ejecutivo del proyecto

### 📖 Para Entender el Proyecto

- **[README.md](./README.md)** - 📝 Este archivo - Overview general
- **[ARCHITECTURE.md](./ARCHITECTURE.md)** - 🏗️ Arquitectura técnica detallada
- **[TECH_DECISIONS.md](./TECH_DECISIONS.md)** - 🎯 Por qué cada tecnología

### 🔧 Para Implementar

- **[SETUP_GUIDE.md](./SETUP_GUIDE.md)** - 🛠️ Guía paso a paso completa (12 pasos)
- **[ROADMAP.md](./ROADMAP.md)** - 📅 Plan de desarrollo (11 fases)
- **[BEST_PRACTICES.md](./BEST_PRACTICES.md)** - ⚡ Mejores prácticas de código

### 🤔 Para Comparar Opciones

- **[TECH_COMPARISON.md](./TECH_COMPARISON.md)** - 📊 Comparativas profundas de tecnologías

---

### 📋 Stack Tecnológico

#### Frontend

- **Next.js 14** (App Router) - Framework React con SSR/SSG
- **TypeScript** - Tipado estático para código robusto
- **Tailwind CSS** - Framework CSS utility-first
- **Framer Motion** - Librería de animaciones
- **Shadcn/ui** - Componentes UI accesibles

#### Backend & Database

- **Supabase** - Base de datos PostgreSQL + Auth + Storage
- **Prisma** - ORM para manejo de datos
- **API Routes** - Endpoints de Next.js

#### Herramientas

- **ESLint** - Linting de código
- **Prettier** - Formateo de código
- **Vercel** - Deployment

---

## 🎯 Características Principales

### Usuario Final (Portafolio Público)

- ✅ Diseño moderno inspirado en zunedaalim.com
- ✅ Animaciones suaves y profesionales
- ✅ Secciones: Home, About, Projects, Skills, Contact
- ✅ Sistema de filtros de proyectos por tecnología
- ✅ Modo oscuro/claro
- ✅ 100% Responsive
- ✅ SEO optimizado
- ✅ Performance optimizado (Next.js SSG)

### Panel de Administración

- ✅ CRUD de proyectos (título, descripción, imágenes, tecnologías, links)
- ✅ CRUD de skills/tecnologías
- ✅ CRUD de experiencia laboral
- ✅ Gestión de información personal
- ✅ Upload de imágenes
- ✅ Preview en tiempo real
- ✅ Autenticación segura

---

## 📁 Estructura del Proyecto

```
portafolio_v2/
├── src/
│   ├── app/                    # App Router de Next.js
│   │   ├── (public)/          # Rutas públicas
│   │   │   ├── page.tsx       # Home
│   │   │   ├── about/         # Sobre mí
│   │   │   ├── projects/      # Proyectos
│   │   │   └── contact/       # Contacto
│   │   ├── admin/             # Panel administrativo
│   │   │   ├── dashboard/
│   │   │   ├── projects/
│   │   │   ├── skills/
│   │   │   └── settings/
│   │   ├── api/               # API Routes
│   │   ├── layout.tsx
│   │   └── globals.css
│   ├── components/            # Componentes reutilizables
│   │   ├── ui/               # Componentes base (shadcn/ui)
│   │   ├── layout/           # Header, Footer, Sidebar
│   │   ├── sections/         # Hero, Projects, Skills, etc.
│   │   └── admin/            # Componentes del panel admin
│   ├── lib/                  # Utilidades y configuraciones
│   │   ├── supabase/        # Cliente de Supabase
│   │   ├── prisma/          # Schema y cliente Prisma
│   │   └── utils.ts
│   ├── types/               # TypeScript types
│   └── hooks/               # Custom React hooks
├── public/                  # Archivos estáticos
│   ├── images/
│   └── fonts/
├── prisma/
│   └── schema.prisma       # Schema de base de datos
├── .env.local              # Variables de entorno
├── next.config.js
├── tailwind.config.ts
├── tsconfig.json
└── package.json
```

---

## 🗄️ Modelo de Base de Datos

### Tablas principales:

**Projects**

- id, title, description, longDescription
- image, technologies[], githubUrl, liveUrl
- featured, order, createdAt

**Skills**

- id, name, category (frontend/backend/tools)
- icon, level, order

**Experience**

- id, company, position, description
- startDate, endDate, technologies[]

**Profile**

- id, name, title, bio, email
- github, linkedin, resume, avatar

---

## 🚀 Instalación y Uso

### Requisitos previos

- Node.js 18+
- npm/yarn/pnpm
- Cuenta de Supabase (gratuita)

### Pasos de instalación

```bash
# 1. Instalar dependencias
npm install

# 2. Configurar variables de entorno
cp .env.example .env.local
# Editar .env.local con tus credenciales de Supabase

# 3. Configurar base de datos
npx prisma generate
npx prisma db push

# 4. Iniciar servidor de desarrollo
npm run dev

# 5. Abrir en navegador
# http://localhost:3000
```

### Panel de administración

- URL: `/admin`
- Credenciales por defecto se crean en el primer setup

---

## 📦 Scripts disponibles

```bash
npm run dev          # Desarrollo
npm run build        # Build para producción
npm run start        # Servidor de producción
npm run lint         # Linting
npm run format       # Formatear código
npm run db:push      # Sincronizar schema con DB
npm run db:studio    # Abrir Prisma Studio
```

---

## 🎨 Inspiración de Diseño

Inspirado en: https://zunedaalim.com/

### Elementos clave:

- Tipografía grande y bold
- Espacios en blanco generosos
- Animaciones sutiles al scroll
- Grid asimétrico para proyectos
- Microinteracciones
- Transiciones suaves

---

## 🔐 Seguridad

- Autenticación con Supabase Auth
- Row Level Security (RLS) en Supabase
- Variables de entorno para datos sensibles
- Validación de formularios con Zod
- Rate limiting en API routes

---

## 📈 Próximas Mejoras

- [ ] Blog integrado con MDX
- [ ] Sistema de analytics
- [ ] Modo de presentación
- [ ] PWA support
- [ ] i18n (inglés/español)
- [ ] Newsletter integration
- [ ] Tests con Vitest/Playwright

---

## 📝 Notas de Desarrollo

Este proyecto está diseñado para ser:

- ✅ **Mantenible**: Código limpio y organizado
- ✅ **Escalable**: Arquitectura modular
- ✅ **Rápido**: Optimizado con Next.js 14
- ✅ **Accesible**: Siguiendo estándares WCAG
- ✅ **SEO-friendly**: Meta tags y sitemap automático

---

## 📧 Contacto

Luis Rodriguez - [@luisrocedev](https://github.com/luisrocedev)

---

## 📄 Licencia

MIT © 2025 Luis Rodriguez
