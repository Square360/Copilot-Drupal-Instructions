# Installation Guide for Projects

## Quick Start

### 1. Verify Square360 Package Server

Ensure your Drupal project's `composer.json` includes the Square360 package server in the repositories section:

```json
{
  "repositories": [
    {
      "type": "composer",
      "url": "https://packages.square360.com"
    }
  ]
}
```

If it's not already configured, add it before proceeding.

### 2. Configure Installer Path

Add this specific installer path to your project's `composer.json` in the `extra.installer-paths` section. This path must be added **before** the generic `drupal-library` path to take precedence:

```json
{
  "extra": {
    "installer-paths": {
      ".github/{$name}/": ["square360/copilot-drupal-instructions"],
      "web/libraries/{$name}/": ["type:drupal-library"]
    }
  }
}
```

**Note:** Your project likely already has the `web/libraries/{$name}/` entry. Just add the `.github/{$name}/` line **above** it in the installer-paths section. The order matters - more specific paths should come first.

### 3. Install the Package

```bash
composer require square360/copilot-drupal-instructions
```

The files will be installed to `.github/copilot/`.

### 4. Configure Git Merge Strategy

This ensures your project-specific `copilot-changelog.md` won't be overwritten during updates.

**Option A: Project-level (recommended)**

Add to your project's `.gitattributes`:

```
.github/copilot/copilot-changelog.md merge=ours
```

Configure the merge driver:

```bash
git config merge.ours.driver true
```

**Option B: Global configuration**

```bash
git config --global merge.ours.driver true
```

### 4. Customize for Your Project

**Option A: Use Copilot to Auto-Customize (Recommended)**

Copy this prompt into GitHub Copilot Chat to automatically update the files for your project:

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

After running this prompt, review the changes and commit them.

**Option B: Manual Customization**

1. Create a project-specific README from the template:

```bash
cd .github/copilot/
cp PROJECT-README.md README.md
```

2. Edit `.github/copilot/README.md` and customize:

- Project name
- Site URL
- Repository URL
- Module prefix (e.g., `yoursite_`)
- List of custom modules
- Development environment details
- Team contacts

3. Update examples in `drupal-modules.md` and `themes-frontend.md` to match your project.

### 5. (Optional) Create Personal Developer Instructions

Create a `.copilot.local.md` file for personal, developer-specific instructions that won't be committed:

```bash
cd .github/copilot/
cp .copilot.local.md.example .copilot.local.md
# Edit with your personal preferences
```

Add to your project's `.gitignore`:
```
.github/copilot/.copilot.local.md
```

Use this for personal coding preferences, testing new patterns, or local environment details.

### 6. Start Using

GitHub Copilot will automatically reference these files when you're working on your Drupal project.

## Updating

To get the latest version:

```bash
composer update square360/copilot-drupal-instructions
```

Your `copilot-changelog.md` and any customizations will be preserved.

## Troubleshooting

### Changelog Gets Overwritten

If the changelog is still being overwritten:

1. Ensure `.gitattributes` is in place
2. Run: `git config merge.ours.driver true`
3. Try the update again

### Files Not Installing

Check that `composer/installers` is installed:

```bash
composer require composer/installers
```

### Wrong Installation Path

If files install to the wrong location (like `web/libraries/copilot/` or `vendor/`):

1. Ensure the specific installer path is configured in your project's `composer.json` **before** the generic `drupal-library` path:

   ```json
   "extra": {
     "installer-paths": {
       ".github/{$name}/": ["square360/copilot-drupal-instructions"],
       "web/libraries/{$name}/": ["type:drupal-library"]
     }
   }
   ```

   **Important:** The `.github/{$name}/` line must come **before** the `web/libraries/{$name}/` line.

2. Remove the incorrectly installed files:

   ```bash
   rm -rf web/libraries/copilot .github/copilot vendor/square360/copilot-drupal-instructions
   ```

3. Reinstall the package:

   ```bash
   composer require square360/copilot-drupal-instructions
   ```
