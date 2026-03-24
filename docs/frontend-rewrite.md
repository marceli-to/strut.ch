# Frontend Rewrite Plan: Tailwind CSS + Modern JS

## What stays the same
- Blade templates (structure)
- PHP backend / controllers
- Swiper (carousel, already modern)
- Fancybox (or swap for PhotoSwipe)
- Google Maps API

## Stack changes

| Layer | Current | Target |
|---|---|---|
| Build tool | Laravel Mix (Webpack) | Vite |
| CSS | ~60 SCSS files | Tailwind CSS 4 |
| JavaScript | jQuery + 9 vanilla modules | Modern JS (no jQuery) |
| Grid layout | Packery/Masonry | CSS Grid native |

---

## Phase 1 — Vite setup (~1–2h)

- Replace `webpack.mix.js` with `vite.config.js`
- Install `laravel-vite-plugin`
- Update asset helpers in Blade layout from `asset()` to `@vite()`

---

## Phase 2 — Tailwind config (~1–2h)

Map existing SCSS config values to `tailwind.config.js` / `@theme`:

**Colors** (`config/_colors.scss`):
```scss
$color--black: #000000;
$color--green: #275d5b;
$color--white: #ffffff;
$color--grey:  #808080;
```

**Breakpoints** (`config/_global.scss`):
```scss
$bp-xs:  400px;
$bp-sm:  600px;
$bp-md:  900px;
$bp-lg: 1200px;
```

**Spacing / dimensions:**
```scss
$page-max-width-lg: 1400px;
$header-height-md:  170px;
$grid-gap: 24px;
```

Webfonts: move `@font-face` declarations from SCSS to a small `fonts.css` or Blade `<link>`.

---

## Phase 3 — Layout + header + nav (~3–4h)

- `layout/app.blade.php` — master layout wrapper, max-width container
- `layout/_header.scss` → Tailwind classes on `<header class="site-header">`
- `layout/_navigation.scss` → Tailwind classes on `<nav class="site-nav">`
- Sticky header hide/show behaviour stays in `header.js` (vanilla JS, no change needed)
- Mobile breakpoint: 900px (`md` in custom Tailwind config)

---

## Phase 4 — Home page + grid templates (~4–6h)

### Ratio box system
Current approach uses padding-top percentage hack:
```scss
.box__a, .box__b { padding-top: 66.666%; }  // 3:2
.box__e          { padding-top: 136.888%; } // stacked
```
Replace with `aspect-ratio` CSS + Tailwind `aspect-[3/2]` etc.

### 10 home grid layout templates (`partials/grids/home/`)
Each becomes Tailwind CSS Grid classes directly in the Blade partial:
- `1fr` → `grid grid-cols-1`
- `2fr` → `grid grid-cols-2`
- `3fr` → `grid grid-cols-3`
- `3fr_landscape` → `grid grid-cols-3`
- `1fr2fr` → `grid grid-cols-3` with `col-span-2`
- `2fr1fr` → `grid grid-cols-3` with `col-span-2`
- `1fr1fr1fr_stacked` → `grid grid-cols-3` with responsive stacking
- `1fr1fr_stacked1fr` → mixed responsive columns
- `1fr_stacked1fr1fr` → mixed responsive columns
- `1fr_stacked2fr` → `grid grid-cols-3` with `col-span-2`
- `2fr1fr_stacked` → `grid grid-cols-3` with `col-span-2`

Shared `media.blade.php` partial (video vs image rendering) stays as-is logically, just updated CSS classes.

---

## Phase 5 — Project detail + project grids (~3–4h)

### 7 project grid layout templates (`partials/grids/projects/`)
Same approach as home grids — replace SCSS classes with Tailwind grid utilities:
- `2fr`
- `1fr_stacked1fr`
- `1fr1fr_stacked`
- `1fr_sm_lg-1fr_lg_sm`
- `1fr_lg_sm-1fr_sm_lg`
- `1fr_sm_lg-1fr_lg`
- `1fr_lg-1fr_sm_lg`

Project detail page (`pages/projects/project.blade.php`):
- Header, browse nav, toggle button, description panel, next project preview
- Drop Packery — replace masonry with CSS Grid

---

## Phase 6 — Remaining pages (~4–6h)

- `pages/works/` — project listing filtered by type/year/state
- `pages/about/` — about, awards, lectures, jobs
- `pages/publications/` — books, press, downloads
- `pages/contact/` — contact form
- `pages/projects/index.blade.php` — project index
- `partials/news.blade.php`
- Error pages (404, 500)
- PDF templates can stay as-is (separate print styles)

---

## Phase 7 — JS rewrite (~3–4h)

Drop jQuery entirely. Rewrite 9 modules in vanilla JS.

| Module | Current | Rewrite notes |
|---|---|---|
| `menu.js` | jQuery toggles, resize debounce | `querySelector`, `classList`, `addEventListener` |
| `header.js` | jQuery scroll hide/show | `addEventListener('scroll')`, `classList` |
| `project.js` | jQuery toggle, click-outside | `classList.toggle`, `closest()` |
| `contact.js` | jQuery toggle | `classList` |
| `team.js` | jQuery expand/collapse | `classList` |
| `maps.js` | Google Maps API | stays as-is |
| `swiper.js` | Swiper (already modern) | stays as-is |
| `packery.js` | Packery/Masonry | **drop entirely** — use CSS Grid |
| `fancybox.js` | Fancybox | stays, or swap for PhotoSwipe 5 |

---

## Phase 8 — Polish + QA (~2–4h)

- Cross-browser: Safari, Firefox, Chrome
- Responsive QA at 400px, 600px, 900px, 1200px, 1400px
- Vendor CSS overrides (Swiper, Fancybox) in a small `vendor.css`
- Check all grid layouts render correctly
- Validate video autoplay behaviour in highlight slideshow

---

## Estimated effort

| Phase | Effort |
|---|---|
| Vite setup | 1–2h |
| Tailwind config | 1–2h |
| Layout + header + nav | 3–4h |
| Home page + grid templates | 4–6h |
| Project detail + project grids | 3–4h |
| Remaining pages | 4–6h |
| JS rewrite (drop jQuery) | 3–4h |
| Polish + QA | 2–4h |
| **Total** | **~21–34h (~1.5–2 days with AI assist)** |

---

## Key decisions before starting

1. **Tailwind 4 or 3?** — v4 uses `@theme` in CSS instead of `tailwind.config.js`. Simpler but newer.
2. **Keep Fancybox or swap?** — PhotoSwipe 5 is lighter and more modern, but Fancybox works fine.
3. **Per-client customization?** — If this frontend pattern will be reused for other clients (see migration-to-cms.md), establish the Tailwind config as a shared base theme.
