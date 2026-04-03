#DevinciIT\Modulr

Perfect—this is now solid. Let’s **finalize it cleanly** and resolve duplication into one **cohesive, production-ready blueprint**, plus clearly list **ALL components you’ll include (v1 library scope)**.

---

# 🧱 FINAL CONSOLIDATED PLAN — `devinci-it\modulr`

Inspired by GitHub Primer but optimized for:

✅ PHP MVC
✅ OOP components
✅ Scoped CSS + JS per component
✅ Reusability across projects

---

# 📂 1. FINAL CLEAN STRUCTURE (MERGED + OPTIMIZED)

```id="final-structure"
php-ui-kit/
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
│
│   └── Config/
│       ├── theme.php
│
├── resources/
│   ├── css/
│   │   ├── tokens.css
│   │   ├── base.css
│   │   ├── utilities.css
│
├── public/
│   ├── components/   ← compiled or direct component assets
│   ├── build/        ← optional bundled assets
│
├── docs/
│   ├── components.md
│   ├── usage.md
│
└── composer.json
```

---

# 🧠 2. FINAL CORE RULES (LOCK THESE IN)

### 🔑 Rule 1: Component = Folder

```id="rule1"
Button/
  ├── Button.php
  ├── view.php
  ├── style.css
  ├── script.js
  └── config.php
```

---

### 🔑 Rule 2: Auto Asset Loading

* If component is used → CSS + JS auto-included
* No manual `<link>` per component

---

### 🔑 Rule 3: Global CSS = minimal

Only:

* tokens (colors, spacing)
* utilities (flex, grid)

Everything else → component-level

---

### 🔑 Rule 4: Naming Convention

```id="naming"
.ui-{component}
.ui-{component}--variant
```

Example:

```
.ui-button
.ui-button--primary
```

---

# ⚙️ 3. FINAL CORE ENGINE (REFINED)

---

## 🔹 Component (Final)

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

## 🔹 AssetManager (Improved)

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

## 🔹 component() helper

```php
function component($name, $props = []) {
    $class = "\\UI\\Components\\" . ucfirst($name) . "\\" . ucfirst($name);
    return (new $class($props))->render();
}
```

---

# 🧩 4. COMPLETE COMPONENT LIST (V1 LIBRARY)

This is your **official reusable library scope** 👇

---

## 📐 Layout Components

```id="layout"
Container
Grid
Flex
Stack
Section
Wrapper
SidebarLayout
```

---

## 🎛 UI Components

```id="ui"
Button
Icon
Badge
Avatar
Divider
Spinner
Tooltip
```

---

## 📝 Form Components

```id="forms"
Form
Input
Textarea
Select
Checkbox
Radio
Switch
Label
FormGroup
```

---

## ⚠️ Feedback Components

```id="feedback"
Alert
Toast
Modal
ProgressBar
Skeleton
EmptyState
```

---

## 📊 Data Display

```id="data"
Card
Table
List
ListItem
Pagination
Stat
Timeline
```

---

## 🧭 Navigation

```id="nav"
Navbar
Sidebar
Menu
Dropdown
Tabs
Breadcrumb
```

---

# 🎨 5. DESIGN SYSTEM (FINAL)

---

## 🔹 Tokens (global)

```css
:root {
  --color-primary: #2da44e;
  --color-danger: #d73a49;
  --radius-md: 6px;
  --spacing-md: 16px;
}
```

---

## 🔹 Utilities (global)

```css
.flex { display: flex; }
.grid { display: grid; }
.gap-md { gap: var(--spacing-md); }
```

---

## 🔹 Component CSS (local only)

```css
.ui-card { }
.ui-modal { }
.ui-navbar { }
```

---

# 🔁 6. FINAL FLOW

```id="flow"
Controller
   ↓
View
   ↓
component('button')
   ↓
Component class
   ↓
AssetManager registers assets
   ↓
HTML rendered
   ↓
Layout injects CSS + JS
```

---

# 🚀 7. OPTIONAL BUT RECOMMENDED (V1.5)

Add after base works:

### 🔹 Asset Build System

* Combine CSS → `app.css`
* Combine JS → `app.js`

---

### 🔹 Component CLI

```
php make:component Button
```

---

### 🔹 Theming System

```
light / dark
custom themes
```

---

### 🔹 Slots (advanced)

```php
Card::make()->slot('footer', '...');
```

---

# 🧩 FINAL RESULT (WHAT YOU BUILT)

You now have:

✅ A reusable PHP UI framework
✅ Component-based architecture
✅ Auto-managed assets
✅ Clean MVC integration
✅ Scalable design system

👉 Basically your own **mini frontend framework inside PHP**

---

👉 Build these 5 first:

* Button
* Card
* Input
* Modal
* Navbar
