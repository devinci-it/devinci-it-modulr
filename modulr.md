# Modulr Component Conventions

## Directory Structure

- **Source:**
  - `src/Components/DataDisplay/Table/`
  - `src/Components/UI/Button/`
- **Public (Published):**
  - `public/vendor/modulr/components/DataDisplay/Table/style.css`
  - `public/vendor/modulr/components/DataDisplay/Table/script.js`

## CSS/JS Naming

- **CSS Classes:**
  - Use flat, namespaced classes: `.mdlr-table`, `.mdlr-button`, `.mdlr-navbar`, etc.
- **JS Hooks:**
  - Use `data-component="{component}"` on the root element, e.g., `data-component="table"`.

## Example Table Markup

```html
<table class="mdlr-table" id="mdlr-table" data-component="table">
  <thead>...</thead>
  <tbody>
    <tr class="mdlr-table-row">
      <td class="mdlr-table-cell">...</td>
    </tr>
  </tbody>
</table>
```

## Asset Publishing

- Use the build-assets.php script to mirror the source structure in `public/vendor/modulr/components/`.
- AssetManager can be configured to point to this directory for dynamic asset loading.

## Overriding Assets

- Developers can override CSS/JS by replacing files in the published directory or by registering their own with AssetManager.
Here’s a **cleaned, fixed, and properly structured version** of your `plan.md`. I removed duplication, improved consistency, fixed grammar, and unified terminology while keeping your vision intact.

---

# 🧱 DevinciIT\Modulr — FINAL PLAN

A **PHP component system** inspired by modern UI frameworks, designed for:

* PHP MVC applications
* OOP component architecture
* Scoped CSS & JS per component
* Maximum reusability across projects

---

# 📂 1. FINAL PROJECT STRUCTURE

```text id="final-structure"
modulr/
│
├── src/
│   ├── Core/
│   │   ├── Component.php
│   │   ├── Renderer.php
│   │   ├── AssetManager.php
│   │   ├── ComponentRegistry.php
│   │
│   ├── Components/
│   │   ├── Layout/
│   │   ├── UI/
│   │   ├── Forms/
│   │   ├── Feedback/
│   │   ├── DataDisplay/
│   │   ├── Navigation/
│   │
│   ├── Traits/
│   │   ├── HasClasses.php
│   │   ├── HasAttributes.php
│   │
│   ├── Helpers/
│   │   ├── component.php
│   │   ├── classnames.php
│   │
│   ├── Contracts/
│   │   ├── Renderable.php
│   │
│   └── Config/
│       └── theme.php
│
├── resources/
│   ├── css/
│   │   ├── tokens.css
│   │   ├── base.css
│   │   ├── utilities.css
│
├── public/
│   ├── components/
│   ├── build/
│
├── docs/
│   ├── components.md
│   ├── usage.md
│
└── composer.json
```

---

# 🧠 2. CORE PRINCIPLES

### 🔑 Rule 1 — Component = Folder

```text id="rule1"
Button/
  ├── Button.php
  ├── view.php
  ├── style.css
  ├── script.js
  └── config.php
```

---

### 🔑 Rule 2 — Auto Asset Loading

* CSS & JS load automatically when a component is used
* No manual `<link>` or `<script>` required

---

### 🔑 Rule 3 — Minimal Global CSS

Only:

* Design tokens (colors, spacing, etc.)
* Utility classes

Everything else is component-scoped.

---

### 🔑 Rule 4 — Naming Convention

```text id="naming"
.mdlr-{category}-{component}
.mdlr-{category}-{component}--{variant}
```

---

# ⚙️ 3. CORE ENGINE

## 🔹 Base Component

```php
abstract class Component {
    protected array $props = [];
    protected string $name;

    public function __construct(array $props = []) {
        $this->props = $props;
        AssetManager::register($this->name);
    }

    abstract public function render(): string;
}
```

---

## 🔹 Asset Manager

```php
class AssetManager {
    protected static array $loaded = [];

    public static function register($name) {
        self::$loaded[$name] = true;
    }

    public static function styles() {
        foreach (self::$loaded as $name => $_) {
            echo "<link rel='stylesheet' href='/components/$name/style.css'>";
        }
    }

    public static function scripts() {
        foreach (self::$loaded as $name => $_) {
            echo "<script src='/components/$name/script.js'></script>";
        }
    }
}
```

---

## 🔹 Component Helper

```php
function component($name, $props = []) {
    $class = "\\DevinciIT\\Modulr\\Components\\" . ucfirst($name) . "\\" . ucfirst($name);
    return (new $class($props))->render();
}
```

---

# 🧩 4. COMPONENT LIBRARY (V1)

## Layout

* Container
* Grid
* Flex
* Stack
* Section
* Wrapper
* SidebarLayout

## UI

* Button
* Icon
* Badge
* Avatar
* Divider
* Spinner
* Tooltip

## Forms

* Form
* Input
* Textarea
* Select
* Checkbox
* Radio
* Switch
* Label
* FormGroup

## Feedback

* Alert
* Toast
* Modal
* ProgressBar
* Skeleton
* EmptyState

## Data Display

* Card
* Table
* List
* ListItem
* Pagination
* Stat
* Timeline

## Navigation

* Navbar
* Sidebar
* Menu
* Dropdown
* Tabs
* Breadcrumb

---

# 🎨 5. DESIGN SYSTEM

## Tokens

```css
:root {
  --color-primary: #2da44e;
  --color-danger: #d73a49;
  --radius-md: 6px;
  --spacing-md: 16px;
}
```

---

## Utilities

```css
.flex { display: flex; }
.grid { display: grid; }
.gap-md { gap: var(--spacing-md); }
```

---

## Component CSS

```css
.mdlr-ui-button { }
.mdlr-data-card { }
.mdlr-navigation-navbar { }
```

---

# 🔁 6. RENDER FLOW

```text id="flow"
Controller
  ↓
View
  ↓
component()
  ↓
Component class
  ↓
AssetManager registers assets
  ↓
HTML rendered
  ↓
Assets injected (CSS + JS)
```

---

# 🚀 7. BRAND SYSTEM — MODULR

## Prefix

```text id="brand"
.mdlr
```

---

## Class Naming

```text id="format"
.mdlr-{category}-{component}
.mdlr-{category}-{component}--{variant}
```

---

## Examples

```text id="examples"
.mdlr-ui-button
.mdlr-ui-button--primary
.mdlr-feedback-modal
.mdlr-data-display-table
```

---

# 🧠 8. DESIGN RULES

* Every component is **isolated**
* No global CSS conflicts
* Predictable naming across all components
* Fully override-friendly
* Scales from small → large applications

---

# 🧩 9. REQUIRED COMPONENT STRUCTURE

```text id="structure"
src/Components/DataDisplay/Table/
  Table.php
  view.php
  style.css
  script.js
```

---

# 🔌 10. VIEW STANDARD

```php
<div 
  class="mdlr-data-display-table <?= $_class ?? '' ?>"
  data-component="table"
  data-variant="<?= $_variant ?? '' ?>">

  <!-- content -->

</div>
```

---

# 🧬 11. NAMESPACING

```php
namespace DevinciIT\Modulr\Components\DataDisplay\Table;
```

---

# 🧠 12. WHY MODULR WORKS

* Predictable architecture
* Clean separation of concerns
* Scalable component system
* Auto asset management
* Strong branding consistency

---

# 🔥 FINAL SUMMARY

**Modulr =**

```text id="summary"
PHP Component System + Scoped Assets + Strict Naming + MVC Integration
```

