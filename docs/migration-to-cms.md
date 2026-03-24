# Migration Plan: strut.ch → cms.marceli.to

## Overview

Port strut.ch functionality into the new CMS prototype at cms.marceli.to. The CMS already has auth, media library (polymorphic), posts module, upload pipeline (Uppy), and a Vue 3 + Pinia + Tailwind frontend.

## Architecture Differences

| | strut.ch | cms.marceli.to |
|---|---|---|
| Laravel | 11 | 12 |
| Frontend | Vue 2 + Vuex + Mix | Vue 3 + Pinia + Vite |
| CSS | SASS/SCSS | Tailwind CSS 4 |
| Images | Intervention Image (custom sizes) | League Glide (on-demand) |
| Uploads | vue2-dropzone | Uppy |
| Editor | TinyMCE 5 | TipTap |
| Auth | JWT | Laravel session |
| Business logic | Controller-heavy | Action classes |
| Media | Separate models per type | Polymorphic Media model |

## What the CMS already has
- User auth (session-based)
- Post CRUD with rich text editing
- Polymorphic media system (attach to any model)
- Drag-drop upload (Uppy) with reordering
- Teaser image selection
- Media library with search, alt/caption editing
- Dashboard with stats
- Toast notifications, confirmation dialogs
- Reusable form/media/layout components

## Modules to build

### 1. Project Module
**Effort: ~2-3 hours with AI assist**

- Create `Project` model with fields: title, name, location, year, description, info, status, competition, has_detail, publish, order
- Add `category_id`, `category_type_id` with Category/CategoryType models
- Create migration
- Create ProjectController (CRUD) + Action classes following CMS patterns
- Create Vue views: project list + form with tabs
- Media already handled by existing polymorphic system — just add `media()` relation
- Add routes to router and API

**Decision:** Use spatie/laravel-translatable for multilingual, or skip if single-language?

### 2. Grid System
**Effort: ~3-5 hours with AI assist**

- Create models: `Grid`, `GridLayout`, `GridElement`
- Make GridElement polymorphic (can belong to homepage or project)
- Create migrations
- Create GridController + Action classes
- Port layout templates (12 variants) to Blade or Vue components
- Build grid management UI:
  - Layout selector
  - Element position assignment
  - Media picker (select from project images/videos)
  - Drag-drop grid ordering

**Decision:** Keep staging/production workflow, or simplify to direct publish?

### 3. Video Support
**Effort: ~1 hour with AI assist**

- Extend existing Media model with video support
- Update UploadMediaRequest validation to accept mp4/webm/mov
- Update UploadAction to skip image processing for videos
- Update MediaUploader component to accept video files
- Add video preview in media grid (poster frame or video tag)

**Decision:** Extend polymorphic Media model (recommended) vs separate ProjectVideo model?

### 4. Multilingual Support
**Effort: ~2-3 hours with AI assist**

- Install spatie/laravel-translatable
- Add translatable trait to Project, Media (caption), and other content models
- Build language switcher component for admin
- Update form components to show fields per locale

**Decision:** Needed for all 5 clients, or only some?

### 5. Public Frontend
**Effort: ~3-4 hours with AI assist**

- Create public routes and controllers
- Homepage: highlight slideshow + grid layouts
- Project detail pages
- Responsive images via Glide
- Port SCSS grid styles to Tailwind (or keep SCSS for public site)

**Decision:** Blade templates (server-rendered) or headless API + separate frontend?

### 6. Additional Features
**Effort: ~1-2 hours with AI assist**

- Project cloning
- Document/file downloads
- News module (if needed)
- Category management UI

## Recommended Build Order

1. **Video support** — smallest change, extends existing system
2. **Project module** — core content type, follows Post patterns
3. **Grid system** — depends on projects existing
4. **Public frontend** — depends on grids and projects
5. **Multilingual** — can be added at any point
6. **Additional features** — as needed per client

## Estimated Timeline

| Phase | With AI | Solo |
|---|---|---|
| Video support | 1 hour | 0.5 day |
| Project module | 2-3 hours | 2-3 days |
| Grid system | 3-5 hours | 3-5 days |
| Public frontend | 3-4 hours | 2-3 days |
| Multilingual | 2-3 hours | 1-2 days |
| Extras | 1-2 hours | 1-2 days |
| **Total** | **~1-2 days** | **~10-16 days** |

## Key Decisions Before Starting

1. **Media model:** Extend polymorphic Media (recommended) or separate models per type?
2. **Grid staging:** Keep dev/production workflow or simplify?
3. **Translations:** Which clients need multilingual?
4. **Public frontend:** Blade or headless?
5. **Per-client customization:** What varies between the 5 clients (layouts, fields, categories)?
