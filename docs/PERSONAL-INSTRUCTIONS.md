# Personal Developer Instructions Feature

## Overview

This package now supports personal, developer-specific Copilot instructions through `.copilot.local.md` files.

## How It Works

1. **Template Provided**: `.copilot.local.md.example` is included in the package
2. **Developer Creates Local File**: Each developer copies the template to `.copilot.local.md`
3. **Git Ignores Local File**: The `.copilot.local.md` file is never committed
4. **Copilot Reads Both**: GitHub Copilot automatically references both team instructions and personal instructions

## Setup

After installing the package in a project:

```bash
cd .github/copilot/
cp .copilot.local.md.example .copilot.local.md
# Edit .copilot.local.md with personal preferences
```

## Use Cases

### 1. Testing New Instructions
Try new instruction patterns before proposing them to the team:

```markdown
## Experimental Pattern

When creating a view, always:
1. Export configuration
2. Add a README in config/install explaining the view
3. Create integration tests
```

### 2. Personal Style Preferences
Add your coding style preferences:

```markdown
## My Coding Style

- Use explicit type hints everywhere
- Prefer early returns
- Add inline "why" comments
```

### 3. Local Environment Details
Document your specific setup:

```markdown
## My Environment

- Lando on macOS
- PHP 8.2
- Local URL: https://myproject.lndo.site
```

### 4. Personal Shortcuts
Define project-specific aliases:

```markdown
## My Aliases

- "the theme" = web/themes/custom/mytheme
- "helper module" = web/modules/custom/mysite_helpers
```

### 5. Temporary Overrides
Add temporary focus areas:

```markdown
## Current Focus

Working on: Migration module
- Use mysite_migrate patterns
- Test with `lando drush migrate:import`
```

## Benefits

✅ **Private**: Your preferences don't clutter the team repository  
✅ **Flexible**: Change instructions anytime without commits  
✅ **Safe Testing**: Try experimental patterns risk-free  
✅ **No Conflicts**: Never worry about merge conflicts on personal preferences  
✅ **Portable**: Template makes it easy to set up in any project  

## File Locations

### In This Package (Copilot-Drupal-Instructions repo)
- `.copilot.local.md.example` - Template file (included)
- `.gitignore` - Excludes `.copilot.local.md`

### In Installed Projects
- `.github/copilot/.copilot.local.md.example` - Installed template
- `.github/copilot/.copilot.local.md` - Your personal file (git-ignored)

## Technical Details

- The `.copilot.local.md` file is added to the root `.gitignore` in this package
- The example template is distributed with the package
- Each project needs to add `.github/copilot/.copilot.local.md` to their `.gitignore`
- GitHub Copilot automatically reads all `.md` files in `.github/copilot/`

## Documentation

- Main README includes section on Personal Developer Instructions
- `overview.md` mentions the capability
- `.copilot.local.md.example` has extensive inline documentation and examples
