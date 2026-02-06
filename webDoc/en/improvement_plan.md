# Weakness Analysis and Improvement Plan

This document summarizes the technical analysis of the current state of **Alxarafe Microframework**. Its goal is to identify barriers to adoption and propose a roadmap for its modernization.

## 1. Weaknesses (Diagnosed)

### 🔴 "Magic" and Opaque Routes
*   **Problem:** The framework uses recursive directory scanning (`glob()`) to generate routes based on file existence.
*   **Impact:**
    *   **Performance:** Disk I/O to scan folders on every request is expensive.
    *   **Rigidity:** URLs are tied to the file structure. They cannot be customized (e.g. `/login` must be `/Admin/Auth/login`).
    *   **Debugging:** It is difficult to trace which controller handles a specific URL.

### 🔴 Implicit Rendering (Destructor)
*   **Problem:** `ViewTrait` uses the magic method `__destruct()` to render the view at the end of script execution.
*   **Impact:**
    *   **Unpredictable Flow:** If an exception occurs or `die()` is called, the view may break or not render.
    *   **Testing:** It is extremely difficult to unit test controllers that output (echo) upon object destruction.

### 🔴 Strong Coupling and Lack of DI
*   **Problem:** Extensive use of static classes (`Config::getConfig()`, `Auth::user`) and direct instantiation (`new Class`).
*   **Impact:**
    *   **Testability:** Prevents the use of Mocks/Stubs for testing.
    *   **Extensibility:** Makes it difficult to replace core components (e.g. changing the Auth system) without rewriting the framework.

### 🔴 Monolithic Admin Module
*   **Problem:** The administration module (`src/Modules/Admin`) is included in the base package.
*   **Impact:**
    *   **Bloat:** Projects that only require an API or a simple web app must carry all the logic and views of the admin panel.

---

## 2. Modernization Proposal (Roadmap)

### Phase 1: Routing Modernization (High Priority)
Abandon folder scanning in favor of **PHP 8 Attributes**.

*   **Action:** Implement a `Router` that reads attributes in controllers.
*   **Example:**
    ```php
    #[Route('/blog/post/{id}', method: 'GET')]
    public function show(int $id) { ... }
    ```
*   **Benefit:** Clean, explicit URLs and better performance (can be cached).

### Phase 2: Explicit Lifecycle (Request -> Response)
Change the "Echo in Destructor" pattern for a response return.

*   **Action:** Controllers must return a `Response` (or `View`) object.
*   **Example:**
    ```php
    public function index() {
        return view('blog.index', ['data' => $data]);
    }
    ```
*   **Benefit:** Total control over the flow, ease for middlewares and testing.

### Phase 3: Modular Decoupling
Extract the administration module to a separate package.

*   **Action:** Move `src/Modules/Admin` to its own repository (`alxarafe/admin-panel`).
*   **Benefit:** Alxarafe becomes a pure, lightweight, and multipurpose microframework.

### Phase 4: Application Kernel
Unify the entry point.

*   **Action:** Create an `App` or `Kernel` class that initializes the framework, instead of relying on configuration scattered in `index.php`.
*   **Benefit:** Standardized startup and ease of installation.
