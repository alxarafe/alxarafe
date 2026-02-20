#!/bin/bash
# Description: Adds or updates the Copyright header in all PHP files.

COPYRIGHT_TEXT="/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */"

# Function to add copyright to a file
add_copyright() {
    local file=$1
    if [[ ! -f "$file" ]]; then return; fi

    # Check if file already has copyright
    if grep -q "Copyright (C) 2024-2026 Rafael San José" "$file"; then
        echo "Skipping (Already has copyright): $file"
        return
    fi

    echo "Adding copyright to: $file"
    
    # Temporary file
    tmp=$(mktemp)
    
    # Read first line
    first_line=$(head -n 1 "$file")
    
    if [[ "$first_line" == "<?php" ]]; then
        echo "$first_line" > "$tmp"
        echo "" >> "$tmp"
        echo "$COPYRIGHT_TEXT" >> "$tmp"
        tail -n +2 "$file" >> "$tmp"
    else
        # If it doesn't start with <?php (rare for source files)
        echo "$COPYRIGHT_TEXT" > "$tmp"
        echo "" >> "$tmp"
        cat "$file" >> "$tmp"
    fi
    
    mv "$tmp" "$file"
}

# Find all PHP files in src and skeleton and apply
echo "Updating Copyright headers..."
find src -name "*.php" | while read -r f; do add_copyright "$f"; done
find skeleton/Modules -name "*.php" | while read -r f; do add_copyright "$f"; done

echo "Done."
