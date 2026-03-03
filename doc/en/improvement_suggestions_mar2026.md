# Improvement Suggestions (March 2026)

This document outlines the suggested improvements for the Alxarafe framework after the v0.4.8 update.

## 🛠️ Recently Implemented Improvements

### `#[ExtraFieldsModel]` Attribute
- **Description**: Allows explicit linking of a data model with its extra fields class (*extrafields*).
- **Usage**: 
  ```php
  #[ExtraFieldsModel(modelClass: MyExtraFields::class, prefix: 'cf_', label: 'pers_fields')]
  class MyModel extends Model { ... }
  ```
- **Benefit**: Removes reliance on rigid class naming (before it was constrained to `Extrafields` or `ExtraFields`) and allows configuring form field prefixes and section labels per model.

---

## 🚀 Future Proposed Improvements

### 1. Webpack to Vite Migration
- **Current State**: Webpack is used for TS/SCSS asset compilation, while VitePress is used for documentation.
- **Proposal**: Unify the entire asset stack on Vite.
- **Benefits**: 
    - **Speed**: Vite is significantly faster in developers (HMR).
    - **Simplicity**: One single viewer and compiler engine for the entire framework.
    - **Modernity**: Better support for ES modules and on-demand loading.

### 2. `ResourceTrait` Modularization
- **Current State**: `ResourceTrait.php` is a monolithic trait with over 1800 lines that handles listings, editing, metadata, buttons, etc.
- **Proposal**: Break the trait into reusable components:
    - `HasListLogic`: Table and filter management.
    - `HasEditLogic`: Form logic and persistence.
    - `HasMetadataScanner`: Auto-detection of types and validations.
- **Benefits**: Easier maintenance, allows controllers to use only what they need, and improves readability.

### 3. Strict PHP 8.2+ Typing
- **Proposal**: Adopt the latest language features in the Core.
- **Actions**:
    - Use of `readonly` properties in configuration classes.
    - Mandatory return typing for all lifecycle hooks (`setup`, `beforeEdit`, `afterSaveRecord`).
    - Strictly typed parameters (`mixed` -> real types).
- **Benefits**: More robust code, design-time error detection, and superior developer experience in the IDE.
