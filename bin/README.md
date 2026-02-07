# Alxarafe Scripts Documentation

This directory contains shell scripts to automate testing, code styling, and static analysis tasks. These scripts are designed to run commands inside the Docker container `alxarafe_php`, ensuring consistency with the development and CI environments.

## Main Script

### `ci_local.sh`
**Usage:** `./bin/ci_local.sh`
**Description:** This is the master script that runs the entire Quality Assurance pipeline locally. It executes the following steps in order:
1.  **Fix Standards**: Automatically fixes code style violations.
2.  **Check Standards**: Reports remaining style issues and potential code smells.
3.  **Static Analysis**: Runs deep code analysis to find bugs.
4.  **Tests**: Executes the test suite.

If any step fails (returns a non-zero exit code), the script stops immediately.

---

## Individual Scripts

You can run these scripts individually to perform specific tasks.

### `fix_standards.sh`
*   **Tool:** `phpcbf` (PHP Code Beautifier and Fixer)
*   **Purpose:** Automatically corrects coding standard violations (PSR-12) in `src/Core` and `Tests`.
*   **Note:** Always run this before committing your code.

### `check_standards.sh`
*   **Tools:**
    *   `phpcs` (PHP Code Sniffer): Checks for violations of coding standards that `phpcbf` could not fix automatically.
    *   `phpmd` (PHP Mess Detector): Scans for "code smells" like unused variables, overly complex methods, and bad naming conventions.
*   **Purpose:** Ensures code quality and adherence to project standards.

### `static_analysis.sh`
*   **Tools:**
    *   `phpstan` (PHP Static Analysis Tool): Finds bugs by analyzing code structure and types without running it. It runs at the highest memory limit to handle large codebases.
    *   `psalm`: Another static analysis tool that complements PHPStan, checking for type safety and potential runtime errors.
*   **Purpose:** Detects bugs early in the development cycle.

### `run_tests.sh`
*   **Tool:** `phpunit`
*   **Purpose:** Executes the application's Unit and Feature tests.
*   **Command:** `docker exec alxarafe_php ./vendor/bin/phpunit`
*   **Note:** This ensures that your changes haven't broken existing functionality.

### `run_migrations.sh`
*   **Purpose:** Helper script to run database migrations manually inside the container if needed.

---

## Workflow Recommendation

1.  **During Development:** Run `run_tests.sh` frequently to verify your changes.
2.  **Before Commit:** Run `ci_local.sh` to ensure your code is clean, formatted, and bug-free.
