<?php

namespace CopilotDrupalInstructions;

use Composer\Script\Event;

/**
 * Composer scripts for Copilot Drupal Instructions package.
 *
 * Handles automated installation of instruction files and templates
 * when the package is installed or updated via Composer.
 */
class ComposerScripts {

  /**
   * Post-install hook.
   *
   * Runs after composer install to set up instruction files.
   *
   * @param \Composer\Script\Event $event
   *   The Composer event object.
   */
  public static function postInstall(Event $event) {
    static::installFiles($event);
  }

  /**
   * Post-update hook.
   *
   * Runs after composer update to update instruction files.
   *
   * @param \Composer\Script\Event $event
   *   The Composer event object.
   */
  public static function postUpdate(Event $event) {
    static::installFiles($event);
  }

  /**
   * Install Copilot instruction files to the project.
   *
   * This method:
   * - Copies instruction files to .github/copilot/
   * - Only copies files that don't exist (protects customizations)
   * - Creates CHANGELOG-COPILOT.md from template if it doesn't exist
   * - Creates .copilot.local.md.example if needed
   *
   * @param \Composer\Script\Event $event
   *   The Composer event object.
   */
  private static function installFiles(Event $event) {
    $io = $event->getIO();
    $composer = $event->getComposer();
    $config = $composer->getConfig();
    
    // Debug output
    $io->write("\n<info>🚀 Installing Copilot Drupal Instructions...</info>");
    $io->write("<info>🔍 DEBUG: ComposerScripts::installFiles() called</info>");
    
    // Determine paths
    $vendorDir = $config->get('vendor-dir');
    $packageDir = $vendorDir . '/square360/copilot-drupal-instructions';
    $projectRoot = dirname($vendorDir);

    // Debug paths
    $io->write("<info>� DEBUG: Vendor dir: $vendorDir</info>");
    $io->write("<info>🔍 DEBUG: Package dir: $packageDir</info>");
    $io->write("<info>🔍 DEBUG: Project root: $projectRoot</info>");
    
    // Check if package directory exists
    if (!is_dir($packageDir)) {
      $io->writeError("<error>❌ Package directory not found: $packageDir</error>");
      return;
    } else {
      $io->write("<info>✅ Package directory found: $packageDir</info>");
    }

    // Ensure .github/copilot directory exists
    $copilotDir = $projectRoot . '/.github/copilot';
    $io->write("<info>🔍 DEBUG: Target copilot dir: $copilotDir</info>");
    
    if (!is_dir($copilotDir)) {
      $io->write("<info>📁 Creating .github/copilot directory...</info>");
      if (mkdir($copilotDir, 0755, true)) {
        $io->write("<info>✅ Created .github/copilot directory</info>");
      } else {
        $io->writeError("<error>❌ Failed to create .github/copilot directory</error>");
        return;
      }
    } else {
      $io->write("<info>📁 .github/copilot directory already exists</info>");
    }    // Files to copy to .github/copilot/ (only if they don't exist)
    $instructionFiles = [
      'overview.md',
      'instructions.md',
      'drupal-modules.md',
      'themes-frontend.md',
      'accessibility.md',
      'security-performance.md',
      'session-checklist.md',
    ];

    // Copy instruction files (only if they don't exist)
    $io->write("<info>📄 Copying instruction files...</info>");
    $copiedCount = 0;
    $skippedCount = 0;

    foreach ($instructionFiles as $file) {
      $source = $packageDir . '/' . $file;
      $dest = $copilotDir . '/' . $file;

      if (!file_exists($dest) && file_exists($source)) {
        copy($source, $dest);
        $io->write("   <info>✅ Copied $file to .github/copilot/</info>");
        $copiedCount++;
      } elseif (file_exists($dest)) {
        $io->write("   <comment>⏭️  Skipped $file (already exists - preserving your version)</comment>");
        $skippedCount++;
      } else {
        $io->writeError("   <error>⚠️  Warning: $file not found in package directory</error>");
      }
    }

    // Copy README to .github/copilot/ if it doesn't exist
    $io->write("\n<info>📝 Setting up README...</info>");
    $readmeSource = $packageDir . '/PROJECT-README.md';
    $readmeDest = $copilotDir . '/README.md';

    if (!file_exists($readmeDest) && file_exists($readmeSource)) {
      copy($readmeSource, $readmeDest);
      $io->write("   <info>✅ Copied PROJECT-README.md to .github/copilot/README.md</info>");
      $copiedCount++;
    } elseif (file_exists($readmeDest)) {
      $io->write("   <comment>⏭️  Skipped README.md (already exists - preserving your version)</comment>");
      $skippedCount++;
    } else {
      $io->writeError("   <error>⚠️  Warning: PROJECT-README.md not found in package directory</error>");
    }

    // Copy .copilot.local.md.example to .github/copilot/ if it doesn't exist
    $io->write("\n<info>📋 Setting up local example...</info>");
    $exampleSource = $packageDir . '/.copilot.local.md.example';
    $exampleDest = $copilotDir . '/.copilot.local.md.example';

    if (!file_exists($exampleDest) && file_exists($exampleSource)) {
      copy($exampleSource, $exampleDest);
      $io->write("   <info>✅ Copied .copilot.local.md.example to .github/copilot/</info>");
      $copiedCount++;
    } elseif (file_exists($exampleDest)) {
      $io->write("   <comment>⏭️  Skipped .copilot.local.md.example (already exists)</comment>");
      $skippedCount++;
    } else {
      $io->writeError("   <error>⚠️  Warning: .copilot.local.md.example not found in package directory</error>");
    }

    // Create CHANGELOG-COPILOT.md from template if it doesn't exist
    $io->write("\n<info>📊 Setting up project changelog...</info>");
    $changelogDest = $projectRoot . '/CHANGELOG-COPILOT.md';

    if (!file_exists($changelogDest)) {
      $changelogTemplate = $packageDir . '/copilot-configuration/templates/CHANGELOG-COPILOT.md.template';

      if (file_exists($changelogTemplate)) {
        copy($changelogTemplate, $changelogDest);
        $io->write("   <info>✅ Created CHANGELOG-COPILOT.md from template at project root</info>");
        $copiedCount++;
      } else {
        // Fallback: create basic changelog if template doesn't exist
        $content = static::getDefaultChangelogTemplate();
        file_put_contents($changelogDest, $content);
        $io->write("   <info>✅ Created CHANGELOG-COPILOT.md with default template at project root</info>");
        $copiedCount++;
      }
    } else {
      $io->write("   <info>🔒 Skipped CHANGELOG-COPILOT.md (already exists - your changelog is protected)</info>");
      $skippedCount++;
    }

    // Summary
    $io->write("\n" . str_repeat("=", 70));
    $io->write("<info>✨ Copilot instructions installation complete!</info>");
    $io->write(str_repeat("=", 70) . "\n");

    if ($copiedCount > 0) {
      $io->write("<info>📦 Copied $copiedCount file(s)</info>");
    }
    if ($skippedCount > 0) {
      $io->write("<comment>⏭️  Skipped $skippedCount existing file(s)</comment>");
    }

    $io->write("\n<info>📝 Next steps:</info>");
    $io->write("   1. Review files in .github/copilot/");
    $io->write("   2. Customize CHANGELOG-COPILOT.md at project root with your project name");
    $io->write("   3. Run the auto-customization prompt from README.md to customize for your project");
    $io->write("   4. Optional: Copy .github/copilot/.copilot.local.md.example to");
    $io->write("      .github/copilot/.copilot.local.md for personal instructions\n");
    $io->write("<info>🔗 Documentation: vendor/square360/copilot-drupal-instructions/README.md</info>\n");
  }

  /**
   * Get the default changelog template content.
   *
   * Used as a fallback if the template file is missing.
   *
   * @return string
   *   The default changelog template content.
   */
  private static function getDefaultChangelogTemplate() {
    return <<<'EOD'
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

EOD;
  }

  /**
   * Pretty-print JSON with consistent formatting.
   *
   * Inspired by Pantheon's approach for keeping composer.json readable.
   *
   * @param array $data
   *   The data array to encode.
   *
   * @return string
   *   The pretty-printed JSON string.
   */
  public static function jsonEncodePretty(array $data) {
    $prettyContents = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    // Collapse single-item arrays to one line
    $prettyContents = preg_replace('#": \[\s*("[^"]*")\s*\]#m', '": [\1]', $prettyContents);
    return $prettyContents;
  }

}
