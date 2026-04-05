# Dynamic CMS Architecture

This project now includes a dynamic CMS layer that allows admins to edit content inline from the frontend.

## Core Components

- `page_sections` table stores per-page, per-section editable content/style JSON.
- `App\Support\DynamicContent` service resolves dynamic values with fallback to config defaults and caches outputs.
- `dynamic_content('page.section.field')` helper allows Blade templates to resolve DB-backed content.
- Admin-only frontend editor (`public/js/cms-editor.js`) supports:
  - Preview mode (toggle outlines)
  - Inline text editing (ar/en + style options)
  - Inline image upload via Laravel Storage (+ browser crop preview & ratio lock)
  - Button customization (text/link/bg/text/border/hover)
  - Icon picker by class + color + size
  - Section drag & drop reorder + show/hide
  - Light/Dark style values (`light_value` / `dark_value`)
  - Save/discard draft workflow

## Routes (Admin + Auth + is_admin)

- `GET /admin/cms/page`
- `POST /admin/cms/save`
- `POST /admin/cms/upload-image`

## How to make any element editable

1. Wrap logical blocks with `data-cms-section="section-key"`.
2. Every editable node must have `data-cms-key="your.key"` (single source of truth).
3. Legacy `data-i18n` is auto-promoted to `data-cms-key` at runtime for backward compatibility.

## Notes

- Storage uses Laravel disk (`public` disk via `Storage::url`), not direct `/public` writes.
- Cache is flushed automatically on section save.
- Non-admin users never see editing toolbar or tools.

## Recommended `content_json` shape

```json
{
  "title": { "type": "text", "ar": "مرحبا", "en": "Welcome" },
  "image_1": { "type": "image", "src": "/storage/cms/hero.jpg" },
  "nav.home_icon": { "type": "icon", "value": "fa-solid fa-house" }
}
```
