# Weak Points Analysis and Improvement Plan

This document summarizes the technical analysis of the current state of **Alxarafe Microframework**. Its goal is to identify adoption barriers and propose a roadmap for modernization.

## 1. Weak Points (Diagnosed)

### 🔴 Magic and Opaque Routing
*   **Problem:** The framework uses recursive directory scanning (`glob()`) to generate routes based on file existence.
*   **Impact:**
    *   **Performance:** Disk I/O to scan folders on every request is costly.
    *   **Rigidity:** URLs are tied to the file structure. They cannot be customized (e.g., `/login` must be `/Admin/Auth/login`).
    *   **Debugging:** It is difficult to track which controller serves a specific URL.

### 🔴 Implicit Rendering (Destructor)
*   **Problem:** `ViewTrait` uses the magic `__destruct()` method to render the view at the end of script execution.
*   **Impact:**
    *   **Unpredictable Flow:** If an exception occurs or `die()` is called, the view may break or not render.
    *   **Testing:** It is extremely difficult to unit test controllers that output (echo) content when the object is destroyed.

### 🔴 Strong Coupling and Lack of DI
*   **Problem:** Extensive use of static classes (`Config::getConfig()`, `Auth::user`) and direct instantiation (`new Class`).
*   **Impact:**
    *   **Testability:** Prevents the use of Mocks/Stubs for testing.
    *   **Extensibility:** Makes it difficult to replace core components (e.g., changing the Auth system) without rewriting the framework.

### 🔴 Monolithic Admin Module
*   **Problem:** The administration module (`src/Modules/Admin`) is included in the base package.
*   **Impact:**
    *   **Bloat:** Projects that only require an API or a simple web interface must carry all the logic and views of the admin panel.

---

## 2. Modernization Roadmap

### Phase 1: Routing Modernization (High Priority)
Abandon folder scanning in favor of **PHP 8 Attributes**.

*   **Action:** Implement a `Router` that reads attributes on controllers.
*   **Example:**
    ```php
    #[Route('/blog/post/{id}', method: 'GET')]
    public function show(int $id) { ... }
    ```
*   **Benefit:** Clean, explicit URLs and better performance (cacheable).

### Phase 2: Explicit Lifecycle (Request -> Response)
Change the "Echo in Destructor" pattern for a response return.

*   **Action:** Controllers should return a `Response` (or `View`) object.
*   **Example:**
    ```php
    public function index() {
        return view('blog.index', ['data' => $data]);
    }
    ```
*   **Benefit:** Full control over flow, ease of middlewares and testing.

### Phase 3: Modular Decoupling
Extract the administration module into a separate package.

*   **Action:** Move `src/Modules/Admin` to its own repository (`alxarafe/admin-panel`).
*   **Benefit:** Alxarafe becomes a pure, lightweight, multi-purpose microframework.

### Phase 4: Application Kernel
Unify the entry point.

*   **Action:** Create an `App` or `Kernel` class that initializes the framework, instead of relying on scattered configuration in `index.php`.
*   **Benefit:** Standardized boot and ease of installation.
