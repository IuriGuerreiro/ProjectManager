# Design Specification: Clean Minimalist Dark (v5)

## 1. Overview
This design adapts the "Clean Minimalist" SaaS aesthetic into a refined Dark Mode. It prioritizes reduced eye strain, high contrast for data, and a professional "developer-first" look using Slate/Gray tones instead of pure black.

## 2. Color Palette (Tailwind CSS)
### Backgrounds
- **Main Background:** `bg-gray-900` (#171923) - The canvas.
- **Surface/Cards:** `bg-gray-800` (#1f2937) - For panels, sidebars, and cards.
- **Border:** `border-gray-700` (#374151) - Subtle dividers.

### Typography
- **Primary Text:** `text-gray-100` (#f3f4f6) - Headings and main content.
- **Secondary Text:** `text-gray-400` (#9ca3af) - Meta data, subtitles, and icons.

### Accents (Primary Brand)
- **Primary:** `text-blue-500` (#3b82f6) - Links, active states, key metrics.
- **Primary Dim:** `bg-blue-500/10` - Backgrounds for active items or badges.

## 3. Layout Structure
### Sidebar (Fixed Left)
- **Width:** `w-64` (Desktop), `w-20` (Collapsed/Tablet).
- **Content:** Logo, Navigation Links (Home, Projects, Tasks), User Profile (Bottom).
- **Behavior:** Fixed position, clear distinction from main content.

### Header (Fixed Top)
- **Height:** `h-16`.
- **Content:** Breadcrumbs (Left), Search Bar (Right), Notifications (Right).
- **Style:** `backdrop-blur` effect or solid surface color.

## 4. Components
### Cards (KPIs)
- Rounded corners (`rounded-2xl`).
- Subtle border (`border border-gray-700`).
- Slight shadow for depth (`shadow-lg`).

### Data Tables
- **Headers:** Uppercase, smaller font, text-gray-500.
- **Rows:** Hover effects (`hover:bg-gray-700/50`).
- **Status Badges:** Pill-shaped, colored text with low-opacity background (e.g., Green text on Green/10 background).

## 5. Implementation Plan
1.  **Install Tailwind:** Setup Tailwind CSS with Laravel Vite.
2.  **Layout File:** Create `resources/views/layouts/app.blade.php` implementing the Sidebar + Header structure.
3.  **Refactor Views:** Update `dashboard.blade.php`, `projects.index`, etc., to extend this new layout and use the new card/table components.
