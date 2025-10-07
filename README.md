# GitHub Copilot Instructions for Drupal Projects

## About This Package

This package provides standardized GitHub Copilot instruction files for Drupal 10/11 projects. These files help Copilot provide context-aware assistance based on Square360's development standards and best practices.

## Installation

See [Installation Guide](https://github.com/Square360/Copilot-Drupal-Instructions/blob/master/docs/INSTALL.md) for detailed installation instructions.

**Quick install:**
```bash
composer require square360/copilot-drupal-instructions
```

## Auto-Customization with Copilot

After installation, use GitHub Copilot to automatically customize the files for your project!

**Copy this prompt** into Copilot Chat:
```
I just installed the square360/copilot-drupal-instructions package into my Drupal project.
Please update the files in .github/copilot/ to reflect this project instead of
the generic examples. Specifically:

1. Update README.md with:
   - Actual project name and description
   - Live site URL from the project
   - Set the GitHub repository URL by checking the actual git remote URLs
   - Correct module prefix (check web/modules/custom/ for the pattern)
   - List all custom modules in web/modules/custom/
   - Note the actual development environment (Lando/DDEV/other)
   - Note the hosting platform (Pantheon/Aquia/other)

2. Copy the "Changelog Template" section from README.md to a new file CHANGELOG-COPILOT.md,
   replacing [Project Name] with the actual project name.

3. When done remove the ## Installation, ## Auto-Customization with Copilot,
   ## Manual Configuration, and ## Changelog Template sections from README.md.
```


## Manual Configuration

Alternatively, customize the following in your `.github/copilot/README.md`:

## Site Information

- Site name: [Your Site Name]
- LIVE site URL: [Your production URL]
- REPO URL: [Your GitHub repository]
- Site machine name prefix: `[yoursite]_`

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

## Changelog Template

**Note:** This section will be removed after auto-customization. Copy this template to `CHANGELOG-COPILOT.md` to track your project's development history.

```markdown
# GitHub Copilot Development Changelog

## [Project Name] Drupal Site

This changelog tracks significant development activities, technical decisions, and improvements made to your Drupal site with assistance from GitHub Copilot.

**Instructions:** Update this file after each significant development session to maintain a record of changes and decisions.

---

## Template for Entries

```markdown
## [YYYY-MM-DD] - Brief Description

### Added
- New features or files added

### Changed
- Modifications to existing functionality

### Fixed
- Bug fixes and corrections

### Technical Details
- Implementation notes
- Code patterns used
- Decisions made and reasoning

### Testing
- How changes were verified
- Manual testing performed
- Issues encountered and resolved
```

---

## Notes

- Always update this file at the end of significant development sessions
- Include enough technical detail for future developers to understand decisions
- Reference related files, functions, or modules when applicable
- Document any deviations from standard patterns and why they were necessary
- This file is project-specific and will not be overwritten by package updates
```

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