# Domain: Team

Team member profiles with contact information and CVs.

---

## Model

### Team
**Table:** `team`
**Traits:** HasTranslations (Spatie)

| Field | Type | Translatable | Notes |
|-------|------|:---:|-------|
| name | string | — | Last name |
| firstname | string | — | First name |
| role | string | DE/EN | Job function/title |
| position | string | DE/EN | Position in company |
| phone | string | — | Phone number |
| email | string | — | Email address |
| cv | text | DE/EN | Rich text biography/CV |
| media | string | — | Portrait image filename |
| order | integer | — | Sort order |
| publish | boolean | — | Publishing flag |

**Scopes:**
- `published()` — where publish = 1

---

## Backend Controller

### TeamController
**Namespace:** `App\Http\Controllers\Backend\Team`

| Endpoint | Method | Description |
|----------|--------|-------------|
| GET `/api/team` | `get` | All members ordered by order ASC |
| POST `/api/team/create` | `store` | Create team member |
| GET `/api/team/edit/{id}` | `edit` | Load for editing |
| POST `/api/team/update/{id}` | `update` | Update member |
| POST `/api/team/clone/{id}` | `clone` | Duplicate with "(Kopie)" |
| DELETE `/api/team/{id}` | `destroy` | Delete member + media |
| POST `/api/team/status/{id}` | `status` | Toggle publish |
| POST `/api/team/order` | `order` | Bulk update sort order |
| DELETE `/api/team/delete/file/{filename}` | `unlink` | Remove portrait image |

---

## Admin Form

**Component:** `resources/js/admin/components/team/Form.vue`

### Tabs

#### 1. Data (2-column layout)

| Label | Field Type | Binding | Required |
|-------|-----------|---------|:---:|
| Vorname | text input | `team.firstname` | Yes |
| Name | text input | `team.name` | Yes |
| Funktion | text input | `team.role.de` | — |
| Position | text input | `team.position.de` | — |
| Telefon | masked input | `team.phone` | — |
| E-Mail | text input | `team.email` | Yes |
| Lebenslauf | TinyMCE editor | `team.cv.de` | — |

**Phone mask:** `052 111 11 11` (Swiss format, via vue-the-mask)

#### 2. Media
- Single image upload (jpg/png, max 8MB)
- Binds to: `team.media`
