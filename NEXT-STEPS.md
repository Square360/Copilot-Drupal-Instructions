# Next Steps for Publishing the Copilot Instructions Package

## Package is Ready! 

The files in `/temp-copilot-package/` are now configured as a reusable Composer package.

## Steps to Publish

### 1. Create the GitHub Repository

```bash
# Navigate to the package directory
cd /Volumes/Work/repos/yalehealth-yale-edu/temp-copilot-package

# Initialize git (if not already done)
git init
git add .
git commit -m "Initial commit: Copilot Drupal Instructions package v1.0.0"

# Create a new repo on GitHub at: https://github.com/Square360/copilot-drupal-instructions
# Then add the remote and push:
git remote add origin git@github.com:Square360/copilot-drupal-instructions.git
git branch -M main
git push -u origin main
```

### 2. Create a Release/Tag

```bash
git tag -a v1.0.0 -m "Release version 1.0.0"
git push origin v1.0.0
```

### 3. Install in the Yale Health Project

From the Yale Health project root:

```bash
# Add the repository to composer.json
composer config repositories.copilot-instructions vcs https://github.com/Square360/copilot-drupal-instructions

# Install the package
composer require square360/copilot-drupal-instructions:^1.0

# Configure git merge strategy
git config merge.ours.driver true

# Add to project's .gitattributes
echo ".github/copilot/copilot-changelog.md merge=ours" >> .gitattributes
```

### 4. Customize for Yale Health

Edit `.github/copilot/README.md` and update:
- Site name: Yale Health
- Site URL: https://yalehealth.yale.edu
- Repo URL: https://github.com/Square360/Yale-Health-Drupal
- Module prefix: `yh_`
- List of custom modules

### 5. Move Your Existing Changelog

```bash
# Backup current YaleHealth changelog
cp .github/copilot/copilot-changelog.md /tmp/yh-changelog-backup.md

# After composer install, replace with your version
cp /tmp/yh-changelog-backup.md .github/copilot/copilot-changelog.md
```

## Testing the Setup

### Test in Yale Health

1. Make a change to one of the copilot instruction files in the temp-copilot-package
2. Commit and tag a new version (e.g., v1.0.1)
3. Run `composer update square360/copilot-drupal-instructions`
4. Verify:
   - Updated files are pulled in
   - Your project's `copilot-changelog.md` is NOT overwritten
   - Copilot can access the updated instructions

### Test in Another Project

1. Add the package to another Square360 Drupal project
2. Customize the README for that project
3. Verify Copilot uses the instructions correctly

## Package Structure

```
temp-copilot-package/
├── .gitattributes           # Preserves project-specific files
├── .gitignore              # Git ignore rules
├── CHANGELOG.md            # Package version history
├── CONTRIBUTING.md         # Contribution guidelines
├── INSTALL.md              # Installation instructions
├── LICENSE                 # MIT License
├── README.md               # Package overview
├── composer.json           # Composer configuration
├── copilot-changelog.md    # Empty template (project-specific)
├── accessibility.md        # WCAG guidelines
├── drupal-modules.md       # Module development standards
├── instructions.md         # Copilot interaction patterns
├── overview.md             # How Copilot uses files
├── security-performance.md # Security and performance
├── session-checklist.md    # Quality assurance checklist
└── themes-frontend.md      # Frontend development guidelines
```

## Future Updates

### Publishing Updates

1. Make changes to the copilot-drupal-instructions repo
2. Update CHANGELOG.md with changes
3. Commit changes
4. Create a new tag: `git tag -a v1.x.x -m "Description"`
5. Push: `git push origin main --tags`

### Projects Update

Projects get updates by running:
```bash
composer update square360/copilot-drupal-instructions
```

Their project-specific files (changelog, customizations) will be preserved!

## Benefits

✅ **Centralized Standards** - One source of truth for all Square360 Drupal projects
✅ **Easy Updates** - Push improvements to all projects via Composer
✅ **Project Customization** - Each project can maintain its own changelog and customizations
✅ **Version Control** - Use semantic versioning for controlled updates
✅ **Consistent Quality** - All projects benefit from improved guidelines

## Support

For issues or questions:
- Create an issue in the copilot-drupal-instructions repo
- Contact the Square360 development team
- Check CONTRIBUTING.md for guidelines
