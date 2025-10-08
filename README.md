# GitHub Copilot Instructions for Drupal Projects

## About This Package

This package provides standardized GitHub Copilot instruction files for **Drupal 10/11 projects hosted on Pantheon**. These files help Copilot provide context-aware assistance based on Square360's development standards and best practices.

**Target Environment:**
- Drupal 10/11
- PHP 8.2+
- Pantheon hosting exclusively

**For Package Developers:** See `copilot-configuration/DEVELOPMENT.md` for architecture details, development workflow, and contribution guidelines.

## Installation

The package installs as a Composer plugin and automatically sets up instruction files when you require it.

**Install the package:**
```bash
composer require square360/copilot-drupal-instructions
```

**What happens during installation:**
- Package installs to `vendor/square360/copilot-drupal-instructions/`
- Composer loads the plugin automatically
- Plugin subscribes to post-install and post-update events
- Instruction files are automatically copied to `.github/copilot/`
- `CHANGELOG-COPILOT.md` is created at project root (if it doesn't exist)
- Existing files are never overwritten (your customizations are protected)
- Updates only copy new or missing files

**Architecture:** This package uses a Composer plugin approach to ensure scripts run automatically when the package is installed. Inspired by [Pantheon's upstream-configuration pattern](https://github.com/pantheon-upstreams/drupal-composer-managed), but implemented as a plugin for reliable automation. See `copilot-configuration/README.md` for technical details.

See [Installation Guide](https://github.com/Square360/Copilot-Drupal-Instructions/blob/master/docs/INSTALL.md) for detailed documentation.

## Auto-Customization with Copilot

After installation, use GitHub Copilot to automatically customize the files for your project!

**Copy this prompt** into Copilot Chat:
```
I just installed the square360/copilot-drupal-instructions package into my Drupal project.
Please update the files in .github/copilot/ to reflect this project instead of
the generic examples. Specifically:

1. Update .github/copilot/README.md with:
   - Actual project name and description
   - Live site URL from the project
   - Set the GitHub repository URL by checking the actual git remote URLs
   - Correct module prefix (check web/modules/custom/ for the pattern)
   - List all custom modules in web/modules/custom/
   - Note the actual development environment (Lando/DDEV/other)
   - Note the hosting platform (Pantheon/Aquia/other)

2. Update CHANGELOG-COPILOT.md at the project root (./CHANGELOG-COPILOT.md),
   replacing [Project Name] with the actual project name.

3. Update examples in .github/copilot/drupal-modules.md and themes-frontend.md
   to use the correct project-specific naming patterns.
```


## Instruction Files Organization

The coding standards and guidelines are organized by domain to provide focused, context-aware assistance:

### Core Development
- **[accessibility.md](./accessibility.md)** - WCAG 2.1 AA compliance and Drupal accessibility standards
- **[drupal-modules.md](./drupal-modules.md)** - Module development, PHPCS standards, dependency injection, and Drupal best practices
- **[instructions.md](./instructions.md)** - General guidelines for effective Copilot interaction and asking questions
- **[security-performance.md](./security-performance.md)** - Security practices, performance optimization, and caching strategies
- **[themes-frontend.md](./themes-frontend.md)** - Theming, CSS/SCSS, JavaScript, Vite, and Webpack configuration

### Customization Areas

After installation, update these sections in your copy:

- **Module Naming Convention**: Define your site's module prefix (e.g., `mysite_`)
- **Custom Modules**: List your project-specific custom modules
- **Development Environment**: Document your local dev setup (Lando, DDEV, etc.)
- **Code Quality**: Add project-specific quality standards
- **Additional Guidelines**: Any project-specific patterns or requirements

## Personal Developer Instructions (Optional)

Create a `.copilot.local.md` file in your project's `.github/copilot/` directory for personal, developer-specific instructions that won't be committed to the repository.

**Setup:**
```bash
cd .github/copilot/
cp .copilot.local.md.example .copilot.local.md
# Edit .copilot.local.md with your personal preferences
```

**Use cases:**
- Test new instruction patterns before proposing to the team
- Add personal coding style preferences
- Document your local development environment specifics
- Create personal shortcuts and aliases
- Override or supplement team instructions temporarily

The `.copilot.local.md` file is git-ignored by default and provides a safe space for experimentation and personal customization without affecting the team.

## Project Changelog

The installation script creates `CHANGELOG-COPILOT.md` at your project root (if it doesn't exist). This file is automatically protected and will never be overwritten during package updates. Use it to track your project's development sessions with GitHub Copilot.

## Quick Reference Commands

**Development:**
```bash
lando composer code-sniff    # Run PHPCS
lando composer code-fix      # Auto-fix PHPCS issues (if available)
lando drush cr               # Clear cache
lando drush updb             # Run database updates
lando drush cim              # Import configuration
lando drush cex              # Export configuration
```

## Resources

- [Drupal Coding Standards](https://www.drupal.org/docs/develop/standards)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
- [Drupal Accessibility](https://www.drupal.org/about/features/accessibility)
- [Drupal Best Practices](https://www.drupal.org/docs/develop/coding-standards)