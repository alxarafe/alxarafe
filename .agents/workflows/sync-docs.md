---
description: Synchronize documentation from Spanish (doc/es) to English (doc/en)
---

# Workflow: Documentation Sync (es -> en)

This workflow ensures that the English documentation stays updated based on the Spanish source files.

1. **Scan `doc/es/`**: Look for new or modified markdown files.
2. **Identify Corresponding File**: For each file in `doc/es/`, identify its counterpart in `doc/en/`.
3. **Translate Content**:
    - If the English file is missing or has an older modification date than the Spanish one, translate the content.
    - Maintain the same frontmatter (titles, links) but translated where appropriate.
    - Ensure technical terms and code examples are preserved exactly.
4. **Documentation Comments**: Update any code docblocks or inline comments in the source files if the documentation update reveals inconsistencies (must be in English).
5. **Verify VitePress**: Run `npm run docs:build` to ensure no broken links were introduced.
