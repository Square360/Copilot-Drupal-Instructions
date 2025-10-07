# Understanding Package File Protection

## How export-ignore Works

This package uses git's `export-ignore` attribute to protect your project-specific files from being overwritten during composer updates.

## Files Protected from Updates

The following files will **NEVER** be overwritten by package updates:

1. **`CHANGELOG-COPILOT.md`** - Your project-specific development history
2. **`PROJECT-README.md`** - Template for project-specific README

These files are excluded from the composer package distribution, so they only exist in the git repository, not in the installed package.

## How It Works

### Step 1: Package Installation

```bash
composer require square360/copilot-drupal-instructions
```

This installs the package files to `.github/copilot/` including template files like `CHANGELOG-COPILOT.md` and `PROJECT-README.md`.

### Step 2: Customize Your Project

You edit `.github/copilot/CHANGELOG-COPILOT.md` to add your project's development history and customize other files for your project.

### Step 3: Package Updates

```bash
composer update square360/copilot-drupal-instructions
```

When the package updates:
- ✅ **Updated instruction files are pulled in** (drupal-modules.md, themes-frontend.md, accessibility.md, etc.)
- ✅ **Your changelog is preserved** - It's not included in the distributed package
- ✅ **Your PROJECT-README.md is preserved** - Also excluded from distribution
- ✅ **No merge conflicts** - Protected files aren't part of the update

## The .gitattributes File

In the package repository (`.gitattributes`):

```gitattributes
# Exclude files from composer package (via export-ignore)
/CHANGELOG-COPILOT.md export-ignore
/PROJECT-README.md export-ignore
/docs export-ignore
/.gitattributes export-ignore
/.gitignore export-ignore
/CHANGELOG.md export-ignore
/COPILOT-PROMPT.md export-ignore
```

This tells composer: "When creating the package distribution, don't include these files."

**Result:** These files remain in the git repository for reference, but when you install/update the package via composer, they're not included in what gets installed, so they can't overwrite your files.

## What Gets Updated vs Preserved

### ✅ Always Updated (Package Files)
- `README.md` - Generic package documentation
- `INSTALL.md` - Installation instructions
- `drupal-modules.md` - Module standards
- `themes-frontend.md` - Frontend guidelines
- `accessibility.md` - Accessibility standards
- `security-performance.md` - Security/performance
- `instructions.md` - Copilot interaction patterns
- `overview.md` - How Copilot uses files
- `session-checklist.md` - QA checklist

### 🔒 Always Preserved (Your Project)
- `CHANGELOG-COPILOT.md` - Your development history
- Any customizations you make to the package files

## Testing the Strategy

### Test 1: Initial Setup
```bash
# Install package
composer require square360/copilot-drupal-instructions

# Add content to changelog
echo "## [2025-10-05] - My first entry" >> .github/copilot/CHANGELOG-COPILOT.md

# Configure merge strategy
git config merge.ours.driver true
echo ".github/copilot/CHANGELOG-COPILOT.md merge=ours" >> .gitattributes

# Commit
git add .
git commit -m "Add copilot instructions with custom changelog"
```

### Test 2: Update Package
```bash
# Simulate package update (after new version is released)
composer update square360/copilot-drupal-instructions

# Check your changelog
cat .github/copilot/CHANGELOG-COPILOT.md
# Should still contain "My first entry"!
```

## Troubleshooting

### Problem: Changelog Gets Overwritten

**This should NOT happen** with version 1.1.0+ of the package.

**Check your version:**
```bash
composer show square360/copilot-drupal-instructions
```

If you're on an older version (<1.1.0), update to get the export-ignore protection:
```bash
composer update square360/copilot-drupal-instructions
```

**Recover lost entries:**
If you lost changelog entries, check git history:
```bash
git log .github/copilot/CHANGELOG-COPILOT.md
git show <commit-hash>:.github/copilot/CHANGELOG-COPILOT.md
```

### Problem: Template Files Missing on First Install

If `CHANGELOG-COPILOT.md` or `PROJECT-README.md` are missing after initial install, they may have been excluded. These files are in the git repository but not in the composer distribution.

**Solution:**
Copy them from the repository manually:
```bash
cd .github/copilot/
curl -O https://raw.githubusercontent.com/Square360/Copilot-Drupal-Instructions/master/CHANGELOG-COPILOT.md
curl -O https://raw.githubusercontent.com/Square360/Copilot-Drupal-Instructions/master/PROJECT-README.md
```

### Problem: Files Not in Expected Location

**Solution:**
Check composer.json installer-paths configuration. Ensure you have:
```json
"extra": {
  "installer-paths": {
    ".github/{$name}/": ["square360/copilot-drupal-instructions"],
    "web/libraries/{$name}/": ["type:drupal-library"]
  }
}
```

The specific path for this package must come **before** the generic drupal-library path.

## Best Practices

### For Project Maintainers

1. **Document Customizations**
   - Keep notes of any changes made to package files
   - Consider creating a `CUSTOMIZATIONS.md` file in your project

2. **Regular Updates**
   - Check for package updates monthly: `composer outdated square360/copilot-drupal-instructions`
   - Update to get latest standards: `composer update square360/copilot-drupal-instructions`

3. **Review Changes**
   - Check the package's CHANGELOG.md before updating
   - Review what changed: `composer show square360/copilot-drupal-instructions --all`

4. **Maintain Changelog**
   - Update your project's `CHANGELOG-COPILOT.md` after significant development sessions
   - Include technical details for future reference

### For Package Maintainers

1. **Never Break the Template**
   - Keep `CHANGELOG-COPILOT.md` as a generic template
   - Don't add project-specific content to the package version

2. **Document Changes**
   - Update package CHANGELOG.md with each release
   - Use semantic versioning
   - Communicate breaking changes clearly

3. **Test Before Release**
   - Test installation in a fresh project
   - Test updates in existing projects
   - Verify protected files remain intact

## Summary

The merge strategy ensures:
- 📦 **You get updates** to coding standards and best practices
- 🔒 **You keep your history** and project-specific content
- ⚡ **No conflicts** during updates
- 🎯 **Simple workflow** - Just run `composer update`

This approach gives you the best of both worlds: centralized, maintained standards that can be updated, while preserving your project's unique documentation and history.
