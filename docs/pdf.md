# PDF Generation & Download

Two distinct PDF features: **Werkliste** (work list) PDFs generated from Blade templates, and **Projektdokumentation** (project documentation) PDFs merged from uploaded files.

---

## Controller

**File:** `app/Http/Controllers/Frontend/PdfController.php`

**Dependencies:**
- `barryvdh/laravel-dompdf` — generates PDFs from Blade views (Werkliste)
- `iio/libmergepdf` with `TcpdiDriver` — merges uploaded PDF files (Projektdokumentation)

**Note:** The TcpdiDriver must be used explicitly. The default Fpdi2Driver cannot handle PDF 1.5+ files with compressed cross-reference streams.

---

## Routes

All routes are defined in `routes/web.php`.

### Projektdokumentation (PDF merge)

| Route | Method | Description |
|-------|--------|-------------|
| `/download/pdf/{id}/{slug?}` | `byCategory` | Merges all download PDFs from published projects in a category |

Collects all `ProjectFile` records (via `downloads` relationship) for published projects in the given category, merges them into a single PDF, and streams it inline to the browser.

**Filename pattern:** `strut.ch-Projektdokumentation-{Slug}-{date}.pdf`
**Source files:** `public/storage/media/downloads/{filename}`

### Werkliste (generated PDFs)

| Route | Method | View | Grouping |
|-------|--------|------|----------|
| `/werkliste/pdf/gesamt` | `worksAll` | `web.pdf.all` | By category name + competitions |
| `/werkliste/pdf/wohnen` | `worksLiving` | `web.pdf.living` | Category ID 1 by name |
| `/werkliste/pdf/gewerbe` | `worksBusiness` | `web.pdf.business` | Category ID 2 by name |
| `/werkliste/pdf/oeffentlich` | `worksPublic` | `web.pdf.public` | Category ID 3 by name |
| `/werkliste/pdf/wettbewerb` | `worksCompetition` | `web.pdf.competition` | By competition type |
| `/werkliste/pdf/status` | `worksState` | `web.pdf.state` | By status + competitions |
| `/werkliste/pdf/jahr` | `worksYear` | `web.pdf.year` | By year |
| `/werkliste/pdf/typ` | `worksType` | `web.pdf.type` | By category name |

All Werkliste PDFs use `barryvdh/laravel-dompdf` to render a Blade view and stream the result.

**Filename pattern:** `strut.ch-werkliste-{type}-{date}.pdf`

---

## Blade Templates

Located in `resources/views/web/pdf/`:

| Template | Used by |
|----------|---------|
| `all.blade.php` | `worksAll` |
| `living.blade.php` | `worksLiving` |
| `business.blade.php` | `worksBusiness` |
| `public.blade.php` | `worksPublic` |
| `competition.blade.php` | `worksCompetition` |
| `state.blade.php` | `worksState` |
| `year.blade.php` | `worksYear` |
| `type.blade.php` | `worksType` |
| `partials/header.blade.php` | Shared header |
| `partials/footer.blade.php` | Shared footer |

---

## Data Sources

### Werkliste PDFs

Each Werkliste method passes a `$data` array to its Blade view containing:
- `title` — PDF title string
- `date` — formatted current date
- `projects` — collection grouped by the relevant field (name, status, year, competition)
- `competition` — (optional) separate competition projects collection

Queries use `Category` and `Project` models with `published()` scope and eager-loaded relationships (`activeTypes.activeProjects`, `categoryType`).

### Projektdokumentation (merge)

Merges physical PDF files uploaded via the project admin form (Files/Dateien tab). Files are stored as `ProjectFile` records and physically at `public/storage/media/downloads/`.
