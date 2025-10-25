# GitHub Copilot Instructions for This Project

This file serves as the entry point for GitHub Copilot to discover project-specific development instructions and guidelines.

## 📂 Instruction Files Location

All detailed Copilot instructions are located in the **`.github/copilot/`** directory:

- **[.github/copilot/README.md](.github/copilot/README.md)** - Overview and file descriptions
- **[.github/copilot/instructions.md](.github/copilot/instructions.md)** - Core coding standards and development guidelines
- **[.github/copilot/overview.md](.github/copilot/overview.md)** - Project context and architecture overview

## 🚀 Quick Reference

### Core Development Guidelines
- **[Drupal Module Development](.github/copilot/drupal-modules.md)** - Custom module patterns and Square360 standards
- **[Theme & Frontend](.github/copilot/themes-frontend.md)** - Theming guidelines and frontend development
- **[Accessibility Standards](.github/copilot/accessibility.md)** - WCAG 2.1 AA compliance requirements
- **[Security & Performance](.github/copilot/security-performance.md)** - Security practices and optimization guidelines

### Development Workflow
- **[Session Checklist](.github/copilot/session-checklist.md)** - Pre-development setup and quality assurance
- **[Project Changelog](../CHANGELOG-COPILOT.md)** - Track development activities and decisions

## 🔧 Environment Context

This is a **Drupal 10/11 project** hosted on **Pantheon** following **Square360** development standards.

### Key Technologies
- **PHP 8.2+**
- **Drupal 10/11**
- **Composer** dependency management
- **Pantheon** hosting platform
- **Git** version control

### Development Standards
- Follow **Drupal coding standards**
- Implement **WCAG 2.1 AA accessibility**
- Use **Square360 development patterns**
- Maintain **security best practices**

## 📝 Personal Instructions

Developers can create personal instruction files that won't be committed:
- **`.github/copilot/copilot.local.md`** - Personal development preferences (git-ignored)
- **`copilot.local.md`** - Alternative location at project root (git-ignored)

Copy from the example: `cp .github/copilot/copilot.local.md.example .github/copilot/copilot.local.md`

## 🔄 Instruction Management

These instructions are managed by the `square360/copilot-drupal-instructions` Composer package:
- **Instruction files** are automatically updated to latest standards
- **Project-specific files** are protected from overwrites
- **Personal files** remain private and untracked

---

**💡 Tip for Copilot:** Always reference the detailed instruction files in `.github/copilot/` for comprehensive development guidance specific to this Drupal project.