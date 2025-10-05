# Copilot Auto-Customization Prompt

Copy and paste this prompt into GitHub Copilot Chat after installing the package to automatically customize all the instruction files for your specific project:

---

## Full Detailed Prompt (Recommended)

```
I just installed the square360/copilot-drupal-instructions package into my Drupal project.
Please update the files in .github/copilot/ to reflect this project instead of
the generic examples. Specifically:

1. Update README.md with:
   - Actual project name and description
   - Live site URL from the project
   - GitHub repository URL
   - Correct module prefix (check web/modules/custom/ for the pattern)
   - List all custom modules in web/modules/custom/
   - Document the actual development environment (Lando/DDEV/other)
   - Note the hosting platform (Pantheon/Acquia/other)

2. Update drupal-modules.md:
   - Replace example function names with the actual module prefix
   - Update the "Module Naming" section with actual custom modules
   - Update the "Common Helper Functions" section if applicable

3. Update themes-frontend.md:
   - Replace example Drupal.behaviors with actual theme name
   - Update theme info example with actual theme name from web/themes/custom/

4. Keep copilot-changelog.md as-is (it's project-specific)

Please examine the project structure, composer.json, and existing modules/themes
to gather the correct information, then update these files accordingly.
```

---

## Quick Short Prompt (For Experienced Users)

```
I just installed square360/copilot-drupal-instructions. Update .github/copilot/
files (README.md, drupal-modules.md, themes-frontend.md) to reflect this project by
analyzing project structure, composer.json, and custom modules/themes. Replace generic
examples with actual project details. Keep copilot-changelog.md unchanged.
```

---

## What Copilot Will Do

When you run this prompt, Copilot will:

1. ✅ Examine your project structure
2. ✅ Read composer.json for project info
3. ✅ List custom modules from web/modules/custom/
4. ✅ Find custom themes from web/themes/custom/
5. ✅ Determine the module naming prefix
6. ✅ Update README.md with actual project details
7. ✅ Update code examples to use your naming conventions
8. ✅ Preserve your copilot-changelog.md

---

## After Running the Prompt

1. **Review the changes** - Copilot will show what it updated
2. **Verify accuracy** - Check that URLs, names, and module lists are correct
3. **Make adjustments** - Fix anything Copilot missed or got wrong
4. **Commit the changes** - Save your customized configuration

```bash
git add .github/copilot/
git commit -m "Customize copilot instructions for this project"
```

---

## Tips for Best Results

- **Run from project root** - Copilot needs access to full project structure
- **Have Copilot workspace open** - Make sure Copilot can see your files
- **Review before committing** - Always verify the changes make sense
- **Update as needed** - Re-run if you add new modules or change structure

---

## Troubleshooting

**Copilot didn't find my modules?**
- Make sure you're in the project root directory
- Check that web/modules/custom/ exists
- Manually specify the modules in a follow-up prompt

**Wrong module prefix detected?**
- Copilot looks at existing module names
- If ambiguous, manually correct in README.md

**Need to update later?**
- Just run the prompt again after adding new modules
- Or manually edit the affected files

---

## Manual Alternative

If you prefer to customize manually:

1. Edit `.github/copilot/README.md`
2. Update project details in the header section
3. Update module lists and naming conventions
4. Update examples in drupal-modules.md with your module prefix
5. Update examples in themes-frontend.md with your theme name

---

## Next Steps

After customization:
1. Your Copilot instructions are ready to use
2. Copilot will reference these when helping with code
3. Update copilot-changelog.md as you work
4. Run `composer update square360/copilot-drupal-instructions` periodically for updates

Your project-specific customizations (including changelog) will be preserved during updates!
