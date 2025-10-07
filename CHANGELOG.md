# Changelog

All notable changes to the Copilot Drupal Instructions package will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-10-05

### Added
- Initial release of standardized GitHub Copilot instruction files
- Core documentation files:
  - README.md - Project overview and quick reference
  - instructions.md - Copilot interaction patterns
  - drupal-modules.md - Module development standards
  - themes-frontend.md - Frontend development guidelines
  - accessibility.md - WCAG 2.1 AA compliance
  - security-performance.md - Security and performance best practices
  - overview.md - Context-aware assistance documentation
  - session-checklist.md - Development session quality checklist
  - COPILOT-CHANGELOG.md - Empty template for project-specific changelog
- Composer package configuration for easy installation
- Git merge strategy documentation for preserving project-specific files
- MIT License

### Features
- Auto-installation to `.github/copilot/` directory
- Preservation of project-specific changelog during updates
- Customizable project information sections
- Comprehensive Drupal 10/11 coding standards
- PHPCS integration guidelines
- Dependency injection best practices
- Frontend asset management with Vite/Webpack
- Accessibility compliance guidelines
- Security and performance optimization patterns

## [1.0.13] - 2025-10-16

### Changed

- Updated auto-customization prompt to reference COPILOT-CHANGELOG.md (uppercase) for consistency with other important files like README.md and CHANGELOG.md
- Clarified package structure: COPILOT-CHANGELOG.md is created by projects during auto-customization, not distributed with the package
- Updated all documentation references to use uppercase COPILOT-CHANGELOG.md filename
- Improved composer.json archive exclusions to ensure project-specific files aren't distributed

### Fixed

- Removed COPILOT-CHANGELOG.md from package repository to maintain clean separation between package template and project-specific files
- Updated .gitignore to reflect proper file exclusions

### Planned

- Additional examples for common Drupal patterns
- Integration with automated testing workflows
- Extended documentation for contrib module development
- Performance profiling guidelines
- Advanced security scanning patterns
