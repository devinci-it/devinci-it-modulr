# Breadcrumb Component Plan

## Location
- Class file path: `src/Components/Navigation/Breadcrumb/Breadcrumb.php`
- View file path: `src/Components/Navigation/Breadcrumb/view.php`
- Optional assets:
  - `src/Components/Navigation/Breadcrumb/style.css`
  - `src/Components/Navigation/Breadcrumb/script.js`

## Goal
Build an accessible, flexible breadcrumb component for hierarchical navigation that supports links, disabled states, truncation, and custom rendering options.

## Core Features (v1)
- `items` array input (ordered from root to current page).
- `href` support per item.
- `disabled` support per item.
- `current` support per item (usually last item).
- `truncated` mode for long trails.
- Custom separator support (`/`, `>`, icon, SVG string).
- Optional per-item icon.
- Optional root "Home" item.

## Item Schema
Each breadcrumb item should support:

```php
[
  'label' => 'Projects',           // required
  'href' => '/projects',           // optional
  'disabled' => false,             // optional (default: false)
  'current' => false,              // optional (default: false)
  'title' => 'All projects',       // optional tooltip/title
  'icon' => null,                  // optional HTML/SVG/icon token
  'attributes' => [],              // optional extra HTML attrs
]
```

## Rendering Rules
- Render wrapper as `<nav aria-label="Breadcrumb">`.
- Render list as ordered list (`<ol>`) for semantics.
- Render item behavior:
  - If `current = true`: render non-link element with `aria-current="page"`.
  - If `disabled = true`: render non-link element with `aria-disabled="true"`.
  - If `href` exists and not disabled/current: render `<a href="...">`.
  - Otherwise render plain text node wrapper (`<span>`).
- Escape labels and attributes safely.

## Truncation Behavior
Support both automatic and explicit truncation.

### Config
```php
[
  'truncated' => false,
  'maxVisible' => 4,      // total visible breadcrumb items when truncated
  'truncateMode' => 'middle', // middle | start
  'ellipsisLabel' => '...',
]
```

### Rules
- `middle` mode: show first + last items, collapse middle into ellipsis item.
- `start` mode: collapse earliest ancestors and keep closest path to current page.
- Never truncate below 2 visible real items unless total items < 2.

## Public API (proposed)
```php
__construct(array $items = [], array $options = [])
setItems(array $items): static
addItem(array $item): static
setSeparator(string $separator): static
setTruncated(bool $state = true): static
setMaxVisible(int $maxVisible): static
setTruncateMode(string $mode): static
render(): string
```

## Accessibility Requirements
- Use `nav` landmark with `aria-label="Breadcrumb"`.
- Ensure current page item has `aria-current="page"`.
- Disabled items must not be keyboard-focusable as links.
- Maintain logical reading order and separator semantics.
- Decorative separators/icons should be `aria-hidden="true"`.

## Styling Hooks
Proposed class naming:
- `.modulr-breadcrumb`
- `.modulr-breadcrumb__list`
- `.modulr-breadcrumb__item`
- `.modulr-breadcrumb__link`
- `.modulr-breadcrumb__text`
- `.modulr-breadcrumb__separator`
- `.modulr-breadcrumb__item--current`
- `.modulr-breadcrumb__item--disabled`
- `.modulr-breadcrumb__item--ellipsis`

## Edge Cases
- Empty items array -> render empty string.
- One item -> render current item only (no separator).
- Multiple `current=true` -> keep first as current, normalize others to false.
- Disabled + href -> disabled wins (no active link behavior).
- Missing label -> skip invalid item or throw in strict mode.

## Testing Checklist
- Renders links correctly with valid `href`.
- Disabled items are not clickable and include aria-disabled.
- Current page item has aria-current and is not rendered as active link.
- Truncation produces expected output for short/long trails.
- XSS-safe output for labels and attributes.
- Works with custom separators and icons.

## Nice-to-Have (v1.1+)
- Dropdown expansion for truncated middle nodes.
- JSON-LD (`BreadcrumbList`) output helper for SEO.
- RTL-aware separator direction.
- Optional microdata attributes.
