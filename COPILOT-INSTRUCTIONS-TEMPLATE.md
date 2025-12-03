# GitHub Copilot Instructions for [Project Name]

> **🎯 Primary Instructions**: All detailed Copilot instructions are in **[.github/copilot/README.md](./.github/copilot/README.md)** - start there!

This project uses the Square360 Drupal development standards with GitHub Copilot integration.

## 📋 Project Context

**Technology Stack:**

- Drupal [Version] with [key modules]
- Hosting: [Pantheon/Other]
- Frontend: [Theme info]
- Custom modules: [List key custom modules]

**Quick Links:**

- **[📖 Main Instructions](./.github/copilot/README.md)** - Complete file guide and overview
- **[🏗️ Project Architecture](./.github/copilot/overview.md)** - Detailed project context
- **[⚙️ Development Workflow](./.github/copilot/session-checklist.md)** - Session workflow and quality checks

### Development Workflow

- **[Session Checklist](./.github/copilot/session-checklist.md)** - Pre-development setup and quality assurance
- **[Project Changelog](./CHANGELOG-COPILOT.md)** - Track development activities and decisions

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
