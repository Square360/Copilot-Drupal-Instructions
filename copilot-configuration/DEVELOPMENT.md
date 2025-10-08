# Development Instructions for Copilot Drupal Instructions Package

## Project Context

This package provides standardized GitHub Copilot instruction files for **Drupal 10/11 projects hosted on Pantheon**. It is designed specifically for Square360's development workflow and standards.

### Target Environment

- **Drupal Version**: 10/11
- **PHP Version**: 8.2+ (minimum)
- **Hosting**: Pantheon exclusively
- **Package Type**: Composer library
- **Installation Method**: Composer with automated file copying

**Important**: We do NOT support other hosting platforms or PHP versions below 8.2. All development decisions should assume Pantheon hosting and PHP 8.2+.

## Architecture Overview

### Design Philosophy

This package uses a **hybrid approach** inspired by [Pantheon's drupal-composer-managed upstream](https://github.com/pantheon-upstreams/drupal-composer-managed), specifically their `upstream-configuration/` pattern.

**Key Reference**: Study `https://github.com/pantheon-upstreams/drupal-composer-managed` for patterns, especially:
- `upstream-configuration/scripts/ComposerScripts.php` - Our model for composer automation
- `upstream-configuration/README.md` - Pattern for organizing upstream code
- Composer autoload with classmap approach
- Pre/post update hooks

### What We Adopted from Pantheon

✅ **Organizational Structure**
- `copilot-configuration/` directory (mirrors their `upstream-configuration/`)
- Separation of scripts, templates, and documentation
- Clear README explaining architecture

✅ **Technical Patterns**
- Namespaced PHP class: `CopilotDrupalInstructions\ComposerScripts`
- Classmap autoloading in `composer.json`
- Composer Event hooks (`postInstall`, `postUpdate`)
- Professional use of Composer IO for output
- `jsonEncodePretty()` method for future JSON formatting needs

✅ **Best Practices**
- File existence checks before copying
- Never overwrite existing files
- Change detection (only write when necessary)
- Cross-platform PHP (no shell dependencies)

### What We Intentionally Did NOT Adopt

❌ **Aggressive Configuration Management**
- No automatic `composer.json` modifications
- No self-perpetuating hooks that re-add themselves
- No platform PHP version management
- No automatic plugin/patching configuration

**Why?** Pantheon manages an upstream that requires persistent configuration across many forked sites. We provide **documentation and instructions** that projects customize once. A lighter touch is more appropriate.

## Directory Structure

```
copilot-configuration/
├── README.md                           # Architecture documentation
├── DEVELOPMENT.md                      # This file - development instructions
├── scripts/
│   └── ComposerScripts.php            # Namespaced automation class
└── templates/
    └── CHANGELOG-COPILOT.md.template  # Template for project changelog
```

### Why This Structure?

1. **Separation of Concerns**: Package internals separate from instruction files
2. **Clear Intent**: Anyone can understand what's package code vs. documentation
3. **Professional**: Follows industry patterns (Pantheon, Symfony, Laravel)
4. **Maintainable**: Easy to add new scripts or templates
5. **Git-friendly**: Can exclude `copilot-configuration/README.md` from distribution

## Core Components

### 1. ComposerScripts.php

**Location**: `copilot-configuration/scripts/ComposerScripts.php`

**Namespace**: `CopilotDrupalInstructions`

**Purpose**: Automate installation of instruction files using Composer hooks

**Key Methods**:
```php
public static function postInstall(Event $event)  // Runs after composer install
public static function postUpdate(Event $event)   // Runs after composer update
private static function installFiles(Event $event) // Core installation logic
private static function getDefaultChangelogTemplate() // Fallback template
public static function jsonEncodePretty(array $data) // JSON formatting utility
```

**What It Does**:
1. Creates `.github/copilot/` directory
2. Copies instruction files (if they don't exist)
3. Copies `PROJECT-README.md` → `.github/copilot/README.md`
4. Copies `.copilot.local.md.example`
5. Creates `CHANGELOG-COPILOT.md` at project root from template
6. **Never** overwrites existing files (protects customizations)
7. Provides clear console output with emoji and formatting

**Path Resolution**:
```php
$vendorDir = $config->get('vendor-dir');
$packageDir = $vendorDir . '/square360/copilot-drupal-instructions';
$projectRoot = dirname($vendorDir);
```

### 2. composer.json Configuration

**Autoload**:
```json
"autoload": {
  "classmap": [
    "copilot-configuration/scripts/ComposerScripts.php"
  ]
}
```

**Scripts**:
```json
"scripts": {
  "post-install-cmd": [
    "CopilotDrupalInstructions\\ComposerScripts::postInstall"
  ],
  "post-update-cmd": [
    "CopilotDrupalInstructions\\ComposerScripts::postUpdate"
  ]
}
```

### 3. File Protection Strategy

**Golden Rule**: NEVER overwrite existing files

**Implementation**:
```php
if (!file_exists($dest) && file_exists($source)) {
    copy($source, $dest);
    // Success message
} elseif (file_exists($dest)) {
    // Skip message - file protected
}
```

**Why?** Projects customize these files. Updates should only add NEW files or missing files, never replace existing ones.

## Development Workflow

### Making Changes to ComposerScripts.php

1. **Consider Pantheon patterns first**: Check their `ComposerScripts.php` for inspiration
2. **Keep it simple**: We copy files, we don't manage infrastructure
3. **Use Composer IO**: `$io->write()`, `$io->writeError()`, proper formatting tags
4. **Test locally**: Use `composer install` in a test Drupal project
5. **Check file paths**: Remember the package is in `vendor/square360/copilot-drupal-instructions/`

### Adding New Instruction Files

1. Create the `.md` file at package root (e.g., `new-feature.md`)
2. Add to `$instructionFiles` array in `ComposerScripts.php`:
   ```php
   $instructionFiles = [
       'overview.md',
       'instructions.md',
       'drupal-modules.md',
       'themes-frontend.md',
       'accessibility.md',
       'security-performance.md',
       'session-checklist.md',
       'new-feature.md', // Add here
   ];
   ```
3. Document in main `README.md`
4. Update `.gitattributes` if needed

### Adding New Templates

1. Create template in `copilot-configuration/templates/`
2. Add copy logic to `installFiles()` method
3. Follow the `CHANGELOG-COPILOT.md` pattern:
   - Check if destination exists
   - Copy from template if available
   - Provide fallback content
   - Never overwrite existing

### Testing Changes

**Local Testing**:
```bash
# In this repository
composer install

# In a test Drupal 10/11 project on Pantheon
composer config repositories.local path /path/to/Copilot-Drupal-Instructions
composer require square360/copilot-drupal-instructions:@dev

# Verify:
# - Files appear in .github/copilot/
# - CHANGELOG-COPILOT.md created at root
# - No errors in console output
# - Existing files not overwritten
```

**Testing Updates**:
```bash
# Make changes to package
# In test project:
composer update square360/copilot-drupal-instructions

# Verify:
# - New files copied
# - Existing files preserved
# - Console output clear and helpful
```

## Pantheon-Specific Considerations

### Why Pantheon Matters

All our Drupal sites use Pantheon, so we can assume:
- Integrated Composer builds
- Pantheon-specific directory structure
- `pantheon.yml` configuration file
- Pantheon's Git workflow
- Platform-specific caching and CDN

### Instruction File Content

When writing instruction files:
- ✅ Reference Pantheon-specific patterns
- ✅ Use Pantheon terminology (environments, multidevs, etc.)
- ✅ Assume Pantheon's Git + Composer workflow
- ✅ Reference Terminus CLI when relevant
- ❌ Don't waste space explaining other hosts
- ❌ Don't try to be generic for all platforms

### PHP 8.2+ Assumption

All instruction files can assume:
- Modern PHP syntax (8.2+)
- Type declarations
- Nullable types
- Constructor property promotion
- Match expressions
- Attributes

Don't waste time explaining PHP 7.x compatibility.

## Future Enhancement Ideas

### From Pantheon Pattern (If Needed)

If we need more sophisticated automation:

1. **Pre-update Hook**
   - Could check for configuration issues
   - Could validate environment
   - Could prepare for updates

2. **Automatic .gitignore Management**
   - Could ensure `CHANGELOG-COPILOT.md` is tracked
   - Could ensure `.copilot.local.md` is ignored

3. **Change Detection**
   - Already have `jsonEncodePretty()` ready
   - Could detect and report file changes
   - Could warn about configuration drift

4. **Pantheon Integration**
   - Could read `pantheon.yml` for environment info
   - Could customize based on PHP version in `pantheon.yml`
   - Could detect Pantheon-specific modules

### What NOT to Add

❌ Don't add features for other hosting platforms
❌ Don't make it configurable for non-Pantheon
❌ Don't add PHP version detection for <8.2
❌ Don't add aggressive auto-configuration
❌ Don't modify project `composer.json` automatically

## Important Files to Reference

### In This Package
- `copilot-configuration/scripts/ComposerScripts.php` - Core automation
- `copilot-configuration/README.md` - Architecture explanation
- `composer.json` - Package definition and hooks
- `.gitattributes` - Distribution control
- `README.md` - User-facing documentation

### External References
- [Pantheon drupal-composer-managed](https://github.com/pantheon-upstreams/drupal-composer-managed)
  - Especially `upstream-configuration/scripts/ComposerScripts.php`
  - Study their approach to composer automation
  - Note what they do aggressively vs. conservatively
- [Pantheon Docs - Integrated Composer](https://pantheon.io/docs/integrated-composer)
- [Pantheon Docs - Custom Upstreams](https://pantheon.io/docs/create-custom-upstream)

## Troubleshooting

### Files Not Copying

**Check**:
1. Composer autoload regenerated? (`composer dump-autoload`)
2. File paths correct in `ComposerScripts.php`?
3. File exists in package directory?
4. Permissions on target directory?

### Composer Errors

**Check**:
1. Namespace correct? (`CopilotDrupalInstructions`)
2. Class name correct? (`ComposerScripts`)
3. Method signature matches Composer expectations? (`Event $event`)
4. PHP syntax valid? (PHP 7.4+ for the script itself)

### Path Issues

**Remember**:
- Package installs to: `vendor/square360/copilot-drupal-instructions/`
- Target directory: `.github/copilot/` (relative to project root)
- Changelog target: `CHANGELOG-COPILOT.md` (project root)
- Use `dirname($vendorDir)` to get project root

## Version History Context

### v1.0.0 - v1.1.0 (Original)
- Direct file copying with custom installer
- Files in `.github/copilot/` directory
- COPILOT-CHANGELOG.md in same directory

### v1.2.0 (First Refactor)
- Moved to composer scripts with procedural PHP
- Renamed to CHANGELOG-COPILOT.md
- Moved changelog to project root
- Fixed CI/composer conflicts

### v2.0.0 (Current - Hybrid Approach)
- Adopted `copilot-configuration/` structure
- Namespaced `ComposerScripts` class
- Classmap autoloading
- Inspired by Pantheon's upstream-configuration pattern
- Professional OOP structure with simpler automation

## Maintenance Guidelines

### When to Update Instruction Files

Update when:
- Drupal releases new major version (10 → 11, etc.)
- Square360 changes coding standards
- New Pantheon features become available
- Common patterns emerge from projects
- Security best practices change

### When to Update ComposerScripts

Update when:
- Adding new instruction files
- Adding new templates
- Fixing bugs in file copying
- Improving console output
- Adding new automation features

### What to Avoid

- ❌ Making it work for non-Pantheon hosting
- ❌ Supporting PHP versions below 8.2
- ❌ Adding configuration options (keep it opinionated)
- ❌ Automatic modification of project files
- ❌ Complex dependency management

## Summary

**Remember**: We're building a documentation package for Square360's Pantheon-hosted Drupal 10/11 sites. Keep it focused, professional, and Pantheon-specific. When in doubt, check how Pantheon does it in their upstream-configuration, but keep our automation lighter since we're providing instructions, not infrastructure.

**Reference Repository**: Always check `https://github.com/pantheon-upstreams/drupal-composer-managed` for proven patterns and best practices.

**Target Audience**: Square360 developers working on Drupal 10/11 sites hosted on Pantheon with PHP 8.2+.
