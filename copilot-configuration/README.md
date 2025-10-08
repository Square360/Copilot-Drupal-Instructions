# Copilot Configuration

This directory contains the configuration files, scripts, and templates used by the Copilot Drupal Instructions package.

## Directory Structure

```
copilot-configuration/
├── README.md                           # This file
├── scripts/
│   └── ComposerScripts.php            # Composer hook scripts
└── templates/
    └── CHANGELOG-COPILOT.md.template  # Template for project changelog
```

## Purpose

The `copilot-configuration/` directory is inspired by Pantheon's `upstream-configuration/` pattern and serves to:

1. **Organize package internals** - Keeps automation scripts and templates separate from documentation files
2. **Provide automated installation** - Composer scripts automatically copy instruction files to projects
3. **Protect customizations** - Never overwrites existing files during updates
4. **Maintain clean structure** - Clear separation between package internals and project documentation

## Components

### scripts/ComposerScripts.php

A namespaced PHP class (`CopilotDrupalInstructions\ComposerScripts`) that handles:

- **Post-install hook** - Runs after `composer install` to set up instruction files
- **Post-update hook** - Runs after `composer update` to add new files (preserves existing)
- **File protection** - Never overwrites existing project files
- **Smart copying** - Copies instruction files to `.github/copilot/` directory
- **Template instantiation** - Creates `CHANGELOG-COPILOT.md` from template at project root

### templates/CHANGELOG-COPILOT.md.template

Template file for creating the project-specific `CHANGELOG-COPILOT.md` file. This file:

- Gets copied to project root on first installation
- Tracks development sessions and technical decisions
- Is never overwritten by package updates (protects customizations)
- Provides structure for documenting Copilot-assisted development

## How It Works

When a project requires this package via Composer:

1. **Installation** - Package installs to `vendor/square360/copilot-drupal-instructions/`
2. **Autoloading** - `ComposerScripts.php` is added to Composer's classmap
3. **Hook execution** - Post-install/update hooks run automatically
4. **File copying** - Instruction files copied to `.github/copilot/` (if they don't exist)
5. **Changelog creation** - `CHANGELOG-COPILOT.md` created at project root (if it doesn't exist)
6. **Protection** - Existing files are never overwritten

## Design Philosophy

This approach balances:

- ✅ **Automatic setup** - Files appear in the right places without manual work
- ✅ **Customization protection** - Your changes are never overwritten
- ✅ **Clean separation** - Package internals separate from project documentation
- ✅ **Standard patterns** - Uses Composer's native autoloading and hooks
- ✅ **Cross-platform** - Pure PHP, no shell dependencies

Inspired by [Pantheon's upstream-configuration pattern](https://github.com/pantheon-upstreams/drupal-composer-managed), adapted for documentation/instruction package use case.

## Differences from Pantheon's Approach

Unlike Pantheon's upstream management which:
- Automatically modifies `composer.json` during updates
- Re-adds hooks if users remove them
- Manages platform PHP versions
- Updates configuration settings

This package:
- 🎯 **Only copies files** - No aggressive composer.json modifications
- 🔒 **Respects customizations** - Never overwrites existing files
- 📝 **Focuses on documentation** - Provides instructions, not infrastructure
- 🤝 **Lighter touch** - Appropriate for a documentation/instruction package

The key difference: Pantheon manages an upstream that requires persistent configuration, while this package provides reusable instructions that projects customize once.
