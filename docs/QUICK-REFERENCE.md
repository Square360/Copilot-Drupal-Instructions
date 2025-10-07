# Quick Reference Card

## For Project Installation

### Install Package
```bash
composer require square360/copilot-drupal-instructions
git config merge.ours.driver true
echo "CHANGELOG-COPILOT.md merge=ours" >> .gitattributes
```

### Auto-Customize with Copilot
Paste this into Copilot Chat:
```
I just installed the square360/copilot-drupal-instructions package. Please update
.github/copilot/ files to reflect this project by examining the project
structure, composer.json, and existing modules/themes. Update README.md with actual
project details (name, URLs, module prefix, custom modules list), and update
examples in drupal-modules.md and themes-frontend.md to use the correct naming.
Keep CHANGELOG-COPILOT.md as-is.
```

### Update Package
```bash
composer update square360/copilot-drupal-instructions
```
*Your changelog stays protected!*

---

## For Package Maintenance

### Publish New Version
```bash
cd copilot-drupal-instructions-repo
# Make changes
git add .
git commit -m "Update: description"
git tag -a v1.x.x -m "Release v1.x.x"
git push origin main --tags
```

### Projects Get Update
```bash
composer update square360/copilot-drupal-instructions
```

---

## Files Overview

### ✅ Will Update
- README.md
- drupal-modules.md
- themes-frontend.md
- accessibility.md
- security-performance.md
- instructions.md
- overview.md
- session-checklist.md

### 🔒 Protected
- CHANGELOG-COPILOT.md (yours)

---

## Troubleshooting

**Changelog overwrites?**
```bash
git config merge.ours.driver true
echo "CHANGELOG-COPILOT.md merge=ours" >> .gitattributes
```

**Files in wrong place?**
Check for conflicting installer-paths in composer.json

**Want to test?**
1. Make a change to your changelog
2. Run `composer update square360/copilot-drupal-instructions`
3. Verify your change is still there ✅

---

## Repository Structure

```
Square360/copilot-drupal-instructions
└── Generic instruction files
    ├── Gets installed to your project
    └── Updates via composer

Your Project
├── CHANGELOG-COPILOT.md (protected)
└── .github/copilot/
    └── Installed files (updated)
```

---

## Benefits

🎯 **One source** for all Square360 standards
🔄 **Easy updates** via Composer
🔒 **Protected** project-specific files
✨ **Better Copilot** assistance
📚 **Consistent** across all projects

---

## Links

- **Installation**: See INSTALL.md
- **How It Works**: See MERGE-STRATEGY.md
- **Publishing**: See NEXT-STEPS.md
- **Overview**: See PACKAGE-SUMMARY.md
- **Repository**: https://github.com/Square360/Copilot-Drupal-Instructions
