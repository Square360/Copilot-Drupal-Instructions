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
   * - Creates copilot.local.md.example if needed
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
    }    // Files to copy to .github/copilot/ (always update to latest package version)
    $instructionFiles = [
      'overview.md',
      'instructions.md',
      'drupal-modules.md',
      'themes-frontend.md',
      'accessibility.md',
      'security-performance.md',
      'session-checklist.md',
      'clickup-documentation.md',
    ];

    // Copy instruction files (always overwrite with package version for updates)
    $io->write("<info>📄 Installing/updating instruction files...</info>");
    $copiedCount = 0;
    $skippedCount = 0;
    $updatedCount = 0;

    foreach ($instructionFiles as $file) {
      $source = $packageDir . '/' . $file;
      $dest = $copilotDir . '/' . $file;

      if (file_exists($source)) {
        $isUpdate = file_exists($dest);
        copy($source, $dest);

        if ($isUpdate) {
          $io->write("   <info>🔄 Updated $file with latest package version</info>");
          $updatedCount++;
        } else {
          $io->write("   <info>✅ Installed $file to .github/copilot/</info>");
          $copiedCount++;
        }
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

    // Copy copilot.local.md.example to .github/copilot/ if it doesn't exist
    $io->write("\n<info>📋 Setting up local example...</info>");
    $exampleSource = $packageDir . '/copilot.local.md.example';
    $exampleDest = $copilotDir . '/copilot.local.md.example';

    if (!file_exists($exampleDest) && file_exists($exampleSource)) {
      copy($exampleSource, $exampleDest);
      $io->write("   <info>✅ Copied copilot.local.md.example to .github/copilot/</info>");
      $copiedCount++;
    } elseif (file_exists($exampleDest)) {
      $io->write("   <comment>⏭️  Skipped copilot.local.md.example (already exists)</comment>");
      $skippedCount++;
    } else {
      $io->writeError("   <error>⚠️  Warning: copilot.local.md.example not found in package directory</error>");
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

    // Create .github/copilot-instructions.md entry point
    $io->write("\n<info>🔗 Setting up Copilot entry point...</info>");
    $entryPointSource = $packageDir . '/COPILOT-INSTRUCTIONS-TEMPLATE.md';
    $entryPointDest = $projectRoot . '/.github/copilot-instructions.md';

    if (!file_exists($entryPointDest) && file_exists($entryPointSource)) {
      copy($entryPointSource, $entryPointDest);
      $io->write("   <info>✅ Created .github/copilot-instructions.md entry point</info>");
      $copiedCount++;
    } elseif (file_exists($entryPointDest)) {
      $io->write("   <comment>🔒 Skipped copilot-instructions.md (already exists - preserving your version)</comment>");
      $skippedCount++;
    } else {
      $io->writeError("   <error>⚠️  Warning: COPILOT-INSTRUCTIONS-TEMPLATE.md not found in package directory</error>");
    }

    // Ensure .gitignore includes copilot.local.md
    $io->write("\n<info>🔍 Checking .gitignore...</info>");
    static::ensureGitignoreEntry($projectRoot, $io);

    // Summary
    $io->write("\n" . str_repeat("=", 70));
    $io->write("<info>✨ Copilot instructions installation complete!</info>");
    $io->write(str_repeat("=", 70) . "\n");

    if ($copiedCount > 0) {
      $io->write("<info>📦 Installed $copiedCount new file(s)</info>");
    }
    if ($updatedCount > 0) {
      $io->write("<info>🔄 Updated $updatedCount file(s) with latest package version</info>");
    }
    if ($skippedCount > 0) {
      $io->write("<comment>🔒 Protected $skippedCount file(s) from overwriting</comment>");
    }

    $io->write("\n<info>📝 Next steps:</info>");
    $io->write("   1. Start with .github/copilot-instructions.md - the main entry point for Copilot");
    $io->write("   2. Review detailed files in .github/copilot/");
    $io->write("   3. Customize CHANGELOG-COPILOT.md at project root with your project name");
    $io->write("   4. Run the auto-customization prompt from README.md to customize for your project");
    $io->write("   5. Optional: Copy .github/copilot/copilot.local.md.example to");
    $io->write("      .github/copilot/copilot.local.md for personal instructions");
    $io->write("      (Both .github/copilot/ and project root locations are now git-ignored)\n");
    $io->write("<info>🔗 Documentation: vendor/square360/copilot-drupal-instructions/README.md</info>\n");
  }

  /**
   * Ensure .gitignore contains copilot.local.md entry.
   *
   * Checks if the project's .gitignore file includes the copilot.local.md entry
   * and adds it if not present. This ensures personal instructions stay local.
   * Covers both .github/copilot/ and project root locations.
   *
   * @param string $projectRoot
   *   The absolute path to the project root directory.
   * @param \Composer\IO\IOInterface $io
   *   The Composer IO interface for output.
   */
  private static function ensureGitignoreEntry($projectRoot, $io) {
    $gitignorePath = $projectRoot . '/.gitignore';
    $gitignoreEntries = [
      '.github/copilot/copilot.local.md',
      'copilot.local.md'
    ];

    // Check if .gitignore exists
    if (!file_exists($gitignorePath)) {
      $io->write("   <comment>⚠️  No .gitignore file found at project root</comment>");
      $io->write("   <info>💡 Consider creating a .gitignore with entries for both locations:</info>");
      foreach ($gitignoreEntries as $entry) {
        $io->write("      $entry");
      }
      return;
    }

    // Read current .gitignore contents
    $gitignoreContents = file_get_contents($gitignorePath);

    // Split into lines for precise matching
    $gitignoreLines = array_map('trim', explode("\n", $gitignoreContents));

    // Check for various possible formats that would cover our entries
    $copilotFolderPatterns = [
      '.github/copilot/copilot.local.md',
      '/.github/copilot/copilot.local.md',
      '.github/copilot/*.local.md',
      '/.github/copilot/*.local.md',
    ];

    $projectRootPatterns = [
      'copilot.local.md',
      '/copilot.local.md',
    ];

    $globalPatterns = [
      '*.local.md',
    ];

    $foundPatterns = [];

    // Check which patterns already exist (exact line matches)
    foreach (array_merge($copilotFolderPatterns, $projectRootPatterns, $globalPatterns) as $pattern) {
      if (in_array($pattern, $gitignoreLines)) {
        $foundPatterns[] = $pattern;
      }
    }

    // Determine if we need to add specific entries
    $needsCopilotFolder = true;
    $needsProjectRoot = true;

    foreach ($foundPatterns as $pattern) {
      // Global patterns cover everything
      if (in_array($pattern, $globalPatterns)) {
        $needsCopilotFolder = false;
        $needsProjectRoot = false;
        break;
      }
      // Check copilot folder coverage
      if (in_array($pattern, $copilotFolderPatterns)) {
        $needsCopilotFolder = false;
      }
      // Check project root coverage
      if (in_array($pattern, $projectRootPatterns)) {
        $needsProjectRoot = false;
      }
    }

    // Build list of entries to add
    $missingEntries = [];
    if ($needsCopilotFolder) {
      $missingEntries[] = '.github/copilot/copilot.local.md';
    }
    if ($needsProjectRoot) {
      $missingEntries[] = 'copilot.local.md';
    }

    // Report existing coverage
    if (!empty($foundPatterns)) {
      $io->write("   <info>✅ .gitignore already contains: " . implode(', ', $foundPatterns) . "</info>");
    }

    // Add missing entries if needed
    if (empty($missingEntries)) {
      $io->write("   <info>✅ All copilot.local.md locations already covered</info>");
      return;
    }

    // Add the missing entries to .gitignore
    $newEntries = "\n# Copilot personal instructions (local only)\n" . implode("\n", $missingEntries) . "\n";

    // Append to .gitignore
    if (file_put_contents($gitignorePath, $gitignoreContents . $newEntries, LOCK_EX)) {
      $io->write("   <info>✅ Added to .gitignore: " . implode(', ', $missingEntries) . "</info>");
      $io->write("   <info>💡 Your personal copilot.local.md files will now be git-ignored</info>");
    } else {
      $io->writeError("   <error>❌ Failed to update .gitignore file</error>");
      $io->write("   <info>💡 Please manually add:</info>");
      foreach ($missingEntries as $entry) {
        $io->write("      $entry");
      }
    }
  }  /**
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
