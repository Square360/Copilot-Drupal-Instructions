# Understanding the Git Merge Strategy

## How the "merge=ours" Strategy Works

When you update the copilot-drupal-instructions package via Composer, git may need to merge changes from the package repository into your project. The `.gitattributes` file tells git how to handle conflicts for specific files.

## Files Protected from Updates

The following files in your project will **NEVER** be overwritten by package updates:

1. **`copilot-changelog.md`** - Your project-specific development history
2. **`.gitattributes`** - Your merge strategy configuration

## How It Works

### Step 1: Package Installation
```bash
composer require square360/copilot-drupal-instructions
```

This installs the package files to `.github/copilot/` including an empty template `copilot-changelog.md`.

### Step 2: Customize Your Project
You edit `.github/copilot/copilot-changelog.md` to add your project's development history.

### Step 3: Configure Merge Strategy
```bash
# Tell git to use the "ours" merge driver
git config merge.ours.driver true

# Add to your project's .gitattributes
echo ".github/copilot/copilot-changelog.md merge=ours" >> .gitattributes
```

### Step 4: Package Updates
```bash
composer update square360/copilot-drupal-instructions
```

When the package updates:
- ✅ **Updated instruction files are pulled in** (drupal-modules.md, themes-frontend.md, etc.)
- ✅ **Your changelog is preserved** - The "merge=ours" strategy keeps YOUR version
- ✅ **No merge conflicts** - Git automatically prefers your version for protected files

## The .gitattributes File

In the package repository (`temp-copilot-package/.gitattributes`):
```
# Preserve project-specific changelog during composer updates
copilot-changelog.md merge=ours

# Keep .gitattributes itself during updates
.gitattributes merge=ours
```

This tells git: "When merging these files, always keep the version in the current repository (ours), ignore changes from the update (theirs)."

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
- `copilot-changelog.md` - Your development history
- Any customizations you make to the package files

## Testing the Strategy

### Test 1: Initial Setup
```bash
# Install package
composer require square360/copilot-drupal-instructions

# Add content to changelog
echo "## [2025-10-05] - My first entry" >> .github/copilot/copilot-changelog.md

# Configure merge strategy
git config merge.ours.driver true
echo ".github/copilot/copilot-changelog.md merge=ours" >> .gitattributes

# Commit
git add .
git commit -m "Add copilot instructions with custom changelog"
```

### Test 2: Update Package
```bash
# Simulate package update (after new version is released)
composer update square360/copilot-drupal-instructions

# Check your changelog
cat .github/copilot/copilot-changelog.md
# Should still contain "My first entry"!
```

## Troubleshooting

### Problem: Changelog Gets Overwritten

**Solution:**
```bash
# 1. Ensure .gitattributes exists in your project root
cat .gitattributes

# 2. Ensure it contains the merge rule
grep "copilot-changelog.md" .gitattributes

# 3. Configure the merge driver
git config merge.ours.driver true

# 4. Verify configuration
git config --get merge.ours.driver
# Should output: true
```

### Problem: Merge Conflicts on Update

**Solution:**
```bash
# Accept your version (ours)
git checkout --ours .github/copilot/copilot-changelog.md
git add .github/copilot/copilot-changelog.md
git commit -m "Keep our changelog during update"
```

### Problem: Files Not in Expected Location

**Solution:**
Check composer.json installer-paths configuration. The package specifies:
```json
"extra": {
  "installer-paths": {
    ".github/copilot/": ["type:drupal-library"]
  }
}
```

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
   - Update your project's `copilot-changelog.md` after significant development sessions
   - Include technical details for future reference

### For Package Maintainers

1. **Never Break the Template**
   - Keep `copilot-changelog.md` as a generic template
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
