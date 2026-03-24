# Grid Builder — Image & Layout Reference

How images are sized, rendered, and laid out across all grid types.

---

## Image Sizes (MediaService)

| Size Key | Max Width | Max Height | Used In |
|----------|-----------|------------|---------|
| `xs`     | 500px     | 350px      | — |
| `sm`     | 900px     | 500px      | Admin previews |
| `md`     | 1200px    | 800px      | Project grid display |
| `lg`     | 1600px    | 1100px     | Home grid display, project lightbox |
| `thumbs` | 200×200   | cover crop | Admin UI |

All output at 90% JPEG quality. Resizing is orientation-aware: landscape scales by width, portrait scales by height.

Images are served on-demand via `/media/{image}/{size}` or from pre-cached files at `/storage/media/{directory}/{image}`.

---

## Home Grid Layouts

All home grids render images at **`lg`** size (1600×1100 max). Aspect ratios are enforced via CSS `padding-top` on box classes.

### CSS Box Classes & Aspect Ratios

| Class    | Padding-top | Ratio      | Usage |
|----------|-------------|------------|-------|
| `.box__a` | 66.67%     | 3:2 landscape | Full-width single |
| `.box__b` | 66.67%     | 3:2 landscape | Equal columns |
| `.box__c` | 68.44%     | ~3:2 variant  | Stacked (small) items |
| `.box__d` | 68.44%     | ~3:2 variant  | Large item in asymmetric layouts |
| `.box__e` | 136.89%    | ~1:1.37 portrait | Tall portrait items |

### Layout Table

| Template | Elements | Grid CSS | Box Classes | Stacked |
|----------|----------|----------|-------------|---------|
| `1fr` | 1 | `1fr` | `box__a` | No |
| `2fr` | 2 | `repeat(2, 1fr)` | `box__b` × 2 | No |
| `3fr` | 3 | `repeat(3, 1fr)` | `box__e` × 3 | No |
| `3fr_landscape` | 3 | `repeat(3, 1fr)` | `box__b` × 3 | No |
| `2fr1fr` | 2 | `2fr 1fr` | `box__d` + `box__e` | No |
| `1fr2fr` | 2 | `1fr 2fr` | `box__e` + `box__d` | No |
| `2fr1fr_stacked` | 3 | `2fr 1fr` | `box__d` + `box__c` × 2 | Yes (right col) |
| `1fr_stacked2fr` | 3 | `1fr 2fr` | `box__c` × 2 + `box__d` | Yes (left col) |
| `1fr1fr1fr_stacked` | 4 | `repeat(3, 1fr)` | `box__e` × 2 + `box__c` × 2 | Yes (right col) |
| `1fr1fr_stacked1fr` | 4 | `repeat(3, 1fr)` | `box__e` + `box__c` × 2 + `box__e` | Yes (center col) |
| `1fr_stacked1fr1fr` | 4 | `repeat(3, 1fr)` | `box__c` × 2 + `box__e` × 2 | Yes (left col) |

### How Stacking Works

In stacked layouts, one column contains two vertically stacked items using `box__c` (68.44% ratio), while the adjacent column uses a tall `box__d` (68.44%) or `box__e` (136.89%) that spans the full height. The two stacked `box__c` items together approximate the height of the tall item, creating a balanced row.

### Media Rendering (Home)

Each home grid position renders via `grids/home/media.blade.php`:

1. **Video** (priority) — if `project_video_id` is set: `<video autoplay muted loop playsinline>` served from `/storage/media/{filename}`
2. **Image** (fallback) — if `project_image_id` is set: `<img>` at `lg` size, linked to project detail page
3. **News** — optional overlay via `news_id`, rendered below media in supported layouts

---

## Project Grid Layouts

Project grids use **two image sizes**: `md` (1200×800) for display, `lg` (1600×1100) for Fancybox lightbox. All layouts use a base `.grid-2x1fr` (two equal columns) CSS grid.

### Layout Table

In the naming convention, `sm` = `md` size image (landscape), `lg` = `lg` size image (portrait/tall).

| Template | Elements | Left Column | Right Column |
|----------|----------|-------------|--------------|
| `2fr` | 2 | 1× `md` (687×458) | 1× `md` (687×458) |
| `1fr_stacked1fr` | 3 | 2× stacked `md` | 1× `lg` (687×940) |
| `1fr1fr_stacked` | 3 | 1× `lg` (687×940) | 2× stacked `md` |
| `1fr_sm_lg-1fr_lg_sm` | 4 | `md` + `lg` stacked | `lg` + `md` stacked |
| `1fr_lg_sm-1fr_sm_lg` | 4 | `lg` + `md` stacked | `md` + `lg` stacked |
| `1fr_sm_lg-1fr_lg` | 3 | `md` + `lg` stacked | 1× `lg` + empty |
| `1fr_lg-1fr_sm_lg` | 3 | 1× `lg` + empty | `md` + `lg` stacked |

### Image Rendering (Projects)

```blade
<a href="{!! ImageHelper::get($element->image->name, 'lg') !!}"
   data-fancybox="gallery"
   data-caption="{{$element->image->caption}}">
  <img src="{!! ImageHelper::get($element->image->name, 'md') !!}"
       width="687" height="458" />
</a>
```

Display image = `md`, lightbox opens `lg`.

---

## Grid Gap

All grids use a **24px gap** between items (`$grid-gap: 24px` in `_grid.scss`).

---

## Admin UI

- **Layout selector**: SVG thumbnails at `/assets/admin/img/icons/grid-layout-{key}.svg`
- **Content picker**: Modal overlay to assign news or project media to each position
- **Row ordering**: Drag-and-drop via vuedraggable
- **Preview images**: Rendered at `sm` size via `/media/{file}/sm`

### Home grid admin

- Vue component: `resources/js/admin/components/home/GridComponent.vue`
- Grid mixin: `resources/js/admin/mixins/grid.js`
- Each position can hold an image, video, or news item

### Project grid admin

- Vue component: `resources/js/admin/components/project/grid/Row.vue`
- Selector: `resources/js/admin/components/project/grid/Selector.vue`
- Each position holds an image only (video field exists but unused)

---

## Key File Paths

| Area | Path |
|------|------|
| Home grid templates | `resources/views/web/partials/grids/home/*.blade.php` |
| Project grid templates | `resources/views/web/partials/grids/projects/*.blade.php` |
| Grid CSS | `resources/sass/web/layout/_grid.scss` |
| Aspect ratios CSS | `resources/sass/web/components/boxes/_ratio.scss` |
| MediaService | `app/Services/MediaService.php` |
| GridService | `app/Services/GridService.php` |
| ImageHelper | `app/Helpers/ImageHelper.php` |
| Home grid model | `app/Models/HomeGridElement.php` |
| Project grid model | `app/Models/ProjectGridElement.php` |
| Admin home grid | `resources/js/admin/components/home/GridComponent.vue` |
| Admin project grid | `resources/js/admin/components/project/grid/Row.vue` |
