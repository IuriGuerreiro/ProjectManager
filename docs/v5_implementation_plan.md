# v5 Design Implementation Plan (Clean Minimalist Dark)

## Epic 1: Infrastructure & Layout (The Foundation)
**Goal:** Setup the styling engine and the master layout template used by all views.

*   **Story 1.1: Configure Tailwind CSS**
    *   **Task:** Add `@tailwind` directives to `resources/css/app.css`.
    *   **Task:** Create/Update `tailwind.config.js` with the v5 color palette (Dark Gray #0f111a, Surface #1f2937, Accent #3b82f6).
    *   **Task:** Ensure `npm run dev` compiles correctly.
*   **Story 1.2: Implement Master Layout (`layouts/app.blade.php`)**
    *   **Task:** Create the collapsible Sidebar with navigation links (Dashboard, Projects, Tasks, etc.).
    *   **Task:** Create the Top Header with Search bar and User Profile dropdown.
    *   **Task:** Define the `@yield('content')` area with proper padding and background color.
*   **Story 1.3: Component Library**
    *   **Task:** Create reusable Blade components for:
        *   `x-card` (Standard content container)
        *   `x-table` (Standard styled table)
        *   `x-badge` (Status indicators like "Active", "Pending")
        *   `x-button` (Primary and Secondary buttons)

## Epic 2: Authentication Views
**Goal:** Apply the v5 design to the login and register screens.

*   **Story 2.1: Refactor Login Page**
    *   **Task:** Center the login card on the dark background.
    *   **Task:** Style input fields with dark borders and focus states.
*   **Story 2.2: Refactor Register Page**
    *   **Task:** Match the login style.

## Epic 3: Dashboard Module
**Goal:** Implement the "Command Center" view.

*   **Story 3.1: Dashboard KPIs**
    *   **Task:** Create the 4 top cards (Active Projects, Pending Tasks, etc.) with hardcoded or real data.
*   **Story 3.2: Recent Activity Table**
    *   **Task:** Implement the "Recent Projects" table using the `x-table` component.

## Epic 4: Projects Module (The Core)
**Goal:** Full CRUD re-design for Projects.

*   **Story 4.1: Projects List (`projects/index.blade.php`)**
    *   **Task:** Convert the Bootstrap table to the v5 Tailwind table.
    *   **Task:** Add "Create Project" button in the top right.
*   **Story 4.2: Project Details View (`projects/view.blade.php`)**
    *   **Task:** Implement the "Details Grid" (Code, Status, Description) at the top.
    *   **Task:** Create the "Teams" section with a table of assigned teams.
    *   **Task:** Create the "Tasks" section with a table of related tasks.
    *   **Task:** Add "Edit" and "Delete" action buttons.
*   **Story 4.3: Create/Edit Project Form**
    *   **Task:** Style the form inputs (text, select, textarea).
    *   **Task:** Style the "Team Selection" checkboxes to be more user-friendly (e.g., a grid of toggleable cards).

## Epic 5: Teams & Users Module
**Goal:** Management of resources.

*   **Story 5.1: Users List & Create**
    *   **Task:** Update table styles and form styles.
*   **Story 5.2: Teams List & Details**
    *   **Task:** Show "Members" and "Assigned Projects" in the Team detail view.

## Epic 6: Tasks, Trainings, & Formers
**Goal:** Remaining modules.

*   **Story 6.1: Tasks List & View**
    *   **Task:** Standardize layout.
*   **Story 6.2: Trainings & Formers**
    *   **Task:** Apply master layout and table styles.

---
**Priority:**
1. Epic 1 (Infra) -> 2. Epic 3 (Dashboard) -> 3. Epic 4 (Projects).
