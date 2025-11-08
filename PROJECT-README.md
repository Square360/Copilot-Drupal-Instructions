# GitHub Copilot Instructions

This directory contains GitHub Copilot instruction files for this Drupal project.

> **💡 Entry Point**: The main entry point for Copilot is at `../.github/copilot-instructions.md` which provides an overview and links to all files in this directory.

## Quick Start

These instruction files provide context-aware assistance for:

- **Drupal 10/11 development** with Square360 standards
- **Pantheon hosting** specific patterns and workflows
- **Accessibility, security, and performance** best practices
- **Module development** and theming guidelines

## Files in This Directory

| File | Purpose |
|------|---------|
| `instructions.md` | Core Copilot instructions and coding standards |
| `overview.md` | Project overview template and development context |
| `drupal-modules.md` | Module development patterns and examples |
| `themes-frontend.md` | Theme development and frontend guidelines |
| `accessibility.md` | WCAG compliance and accessibility standards |
| `security-performance.md` | Security practices and performance optimization |
| `session-checklist.md` | Development session workflow and quality checks |
| `copilot.local.md.example` | Template for personal developer instructions |

## Customization

### Team Instructions (Shared)

**Important**: The main instruction files are automatically updated when the package is updated to ensure you get the latest Square360 standards and Drupal best practices. For project-specific customizations:

- Make changes after package updates
- Consider proposing improvements back to the package repository
- Document project-specific deviations in your project README

**Files that get updated automatically:**
- `instructions.md`, `overview.md`, `drupal-modules.md`, `themes-frontend.md`
- `accessibility.md`, `security-performance.md`, `session-checklist.md`

**Files that are protected from updates:**
- `README.md` (this file - project-specific documentation)
- `copilot.local.md` (personal instructions)
- `CHANGELOG-COPILOT.md` (at project root)

### Personal Instructions (Private)
Create personal instructions that won't be committed:

```bash
cp copilot.local.md.example copilot.local.md
# Edit copilot.local.md with your personal preferences
```

Your `copilot.local.md` file is automatically git-ignored and will contain your personal development preferences.

## Auto-Customization

The package includes an auto-customization feature. Run this prompt with Copilot to automatically customize the instructions for your project:

\`\`\`
Please help me customize these GitHub Copilot instructions for my Drupal project:

1. **Project Analysis**: Examine the codebase to understand:
   - Project name and purpose
   - Existing custom modules and themes
   - Development patterns and architecture
   - Dependencies and integration points

2. **Customize PROTECTED Files Only**: Update only the files that won't be overwritten by package updates:
   - **`.github/copilot/README.md`** - Update project-specific documentation and file descriptions
   - **`copilot.local.md`** (if it exists) - Add project-specific patterns and preferences
   - **Project documentation** - Update README.md and other project files with Copilot context

   **⚠️ DO NOT modify these files** (they get overwritten by package updates):
   - `instructions.md`, `overview.md`, `drupal-modules.md`, `themes-frontend.md`
   - `accessibility.md`, `security-performance.md`, `session-checklist.md`

3. **Create Project Changelog**: Set up `CHANGELOG-COPILOT.md` at the project root with:
   - Proper project name and description
   - Template ready for tracking development activities
   - Project-specific development notes and patterns

4. **Update Entry Point**: Customize `.github/copilot-instructions.md` with:
   - Replace "[Project Name]" placeholders with actual project name
   - Add project-specific technology stack information
   - Include links to custom modules and themes

Please analyze the codebase and customize only the protected files to provide project-specific context while preserving the package-managed instruction files.
\`\`\`

## Package Updates

When the `square360/copilot-drupal-instructions` package is updated:

- ✅ **Instruction files are automatically updated** with latest package versions
- ✅ **New instruction files are automatically added**
- 🔒 **Project-specific files are protected**: `README.md`, `copilot.local.md`, `CHANGELOG-COPILOT.md`
- ✅ **Missing files are restored** from templates

This ensures you always have the latest Square360 standards while preserving your project-specific customizations.

## Documentation

For complete documentation and development guidelines, see:
`vendor/square360/copilot-drupal-instructions/README.md`

---

**Package Version**: Managed by `square360/copilot-drupal-instructions`
**Last Updated**: Files are automatically managed during composer install/update
