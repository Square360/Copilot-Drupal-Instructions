# Troubleshooting Guide

This guide covers common issues when using GitHub Copilot with Drupal projects and their solutions.

## macOS Issues

### Terminal Commands Hanging or Slow to Respond

**Symptoms:**
- GitHub Copilot hangs after running terminal commands
- Long delays when opening integrated terminals in VS Code
- Commands take excessive time to complete
- Copilot appears frozen after using `run_in_terminal` tool

**Root Cause:**
Oh My Zsh (and similar shell enhancement frameworks) can interfere with VS Code's integrated terminal, causing performance issues and hanging when Copilot attempts to run automated commands.

**Solution: Disable Oh My Zsh in VS Code Terminals**

Add the following to the **very top** of your `~/.zshrc` file, before the Oh My Zsh initialization:

```bash
# Skip Oh My Zsh in VS Code integrated terminal
if [[ "$TERM_PROGRAM" == "vscode" ]]; then
    return
fi

# Oh My Zsh configuration starts here...
export ZSH="$HOME/.oh-my-zsh"
# ... rest of your .zshrc
```

**What this does:**
- Detects when zsh is running inside VS Code
- Skips loading Oh My Zsh and all its plugins/themes
- Keeps your regular terminal (Terminal.app, iTerm2, etc.) fully functional with Oh My Zsh
- Provides a clean, fast shell environment for VS Code and Copilot

**After making the change:**
1. Save your `~/.zshrc` file
2. Reload VS Code window: `Cmd+Shift+P` → "Developer: Reload Window"
3. Open a new terminal in VS Code to verify it's working

**To verify it worked:**
- Open a new VS Code terminal (`` Ctrl+` ``)
- Notice the prompt is plain instead of fancy
- Run a command like `ls -la` - it should execute instantly
- Copilot commands should no longer hang

**Alternative Solution: Use Plain Zsh**

If you still experience issues, configure VS Code to use zsh without any configuration files:

1. Open VS Code Settings JSON: `Cmd+Shift+P` → "Preferences: Open User Settings (JSON)"
2. Add:

```json
{
  "terminal.integrated.profiles.osx": {
    "zsh-plain": {
      "path": "/bin/zsh",
      "args": ["--no-rcs"]
    }
  },
  "terminal.integrated.defaultProfile.osx": "zsh-plain"
}
```

3. Reload VS Code

**Why This Matters for Copilot:**
- Copilot needs to run commands like `composer`, `drush`, `git`, etc.
- Oh My Zsh adds startup overhead and can interfere with output parsing
- A clean terminal environment ensures reliable automation
- Faster terminals = faster development workflow

---

## General Issues

### Package Installing to Wrong Location

**Symptoms:**
- Files install to `vendor/square360/copilot-drupal-instructions/`
- Files install to `web/libraries/copilot/`
- Files not in `.github/copilot/` as expected

**Solution:**

1. Ensure the specific installer path is configured in your project's `composer.json` **before** the generic `drupal-library` path:

```json
{
  "extra": {
    "installer-paths": {
      ".github/{$name}/": ["square360/copilot-drupal-instructions"],
      "web/libraries/{$name}/": ["type:drupal-library"]
    }
  }
}
```

**Important:** The `.github/{$name}/` line must come **before** the `web/libraries/{$name}/` line.

2. Remove incorrectly installed files:

```bash
rm -rf web/libraries/copilot .github/copilot vendor/square360/copilot-drupal-instructions
```

3. Reinstall the package:

```bash
composer require square360/copilot-drupal-instructions
```

See [INSTALL.md](./INSTALL.md) for complete installation instructions.

---

### Changelog Gets Overwritten on Updates

**Symptoms:**
- Your project-specific `copilot-changelog.md` entries are lost after running `composer update`
- Changes to the changelog don't persist

**Root Cause:**
This should NOT happen with version 1.1.0+ of the package. The `copilot-changelog.md` file is excluded from the composer package distribution via `export-ignore`, meaning it will only be created on first install and never updated.

**Solution:**

1. **Check your package version:**

```bash
composer show square360/copilot-drupal-instructions
```

If you're on an older version, update to the latest:

```bash
composer update square360/copilot-drupal-instructions
```

2. **Verify the file is excluded:**

After updating, the `copilot-changelog.md` should not be included in future updates. Your project-specific entries will be preserved automatically.

3. **If you lost changelog entries:**

Check git history to recover them:

```bash
git log .github/copilot/copilot-changelog.md
git show <commit-hash>:.github/copilot/copilot-changelog.md > .github/copilot/copilot-changelog.md
```

**How It Works:**
- The package repository has `copilot-changelog.md` as a template
- The `.gitattributes` file marks it as `export-ignore`
- When composer installs the package, this file is NOT included in the distribution
- On first install, it's created from the repo
- On updates, composer doesn't have this file to overwrite yours with

---

### Copilot Not Using Project Instructions

**Symptoms:**
- Copilot doesn't follow the coding standards in the instruction files
- Suggestions don't match project patterns
- Copilot seems unaware of the `.github/copilot/` files

**Possible Causes & Solutions:**

1. **Files not installed correctly**
   - Verify files are in `.github/copilot/` directory
   - Run `ls -la .github/copilot/` to check

2. **Working in wrong directory**
   - Ensure VS Code workspace root includes the `.github/` directory
   - Open the project root, not a subdirectory

3. **VS Code needs reload**
   - Reload window: `Cmd+Shift+P` → "Developer: Reload Window"
   - Or restart VS Code completely

4. **Instructions not customized for project**
   - Generic examples may not be recognized as relevant
   - Customize the files for your specific project
   - See [INSTALL.md](./INSTALL.md) for customization steps

---

### composer/installers Not Found

**Symptoms:**
- Error about missing `composer/installers` package
- Custom installer paths not working

**Solution:**

```bash
composer require composer/installers:^2.0
```

This package is required for custom installation paths to work.

---

### Personal Instructions Not Working

**Symptoms:**
- `.copilot.local.md` file is being committed to git
- Personal instructions are visible to the team
- File changes are tracked by git

**Solution:**

1. Ensure `.copilot.local.md` is in your project's `.gitignore`:

```bash
echo ".github/copilot/.copilot.local.md" >> .gitignore
```

2. If already committed, remove from git (but keep local copy):

```bash
git rm --cached .github/copilot/.copilot.local.md
git commit -m "Remove personal Copilot instructions from tracking"
```

3. The file will remain on your local machine but won't be tracked by git

---

## Getting Help

### Check Package Documentation

- [Installation Guide](./INSTALL.md)
- [Getting Started](./START-HERE.md)
- [Personal Instructions Guide](./PERSONAL-INSTRUCTIONS.md)
- [Package Summary](./PACKAGE-SUMMARY.md)

### Common Debug Commands

```bash
# Verify installation location
ls -la .github/copilot/

# Check composer configuration
composer config extra.installer-paths

# Verify git merge strategy
git config merge.ours.driver

# Check package version
composer show square360/copilot-drupal-instructions
```

### Still Having Issues?

1. Check the [GitHub repository](https://github.com/Square360/Copilot-Drupal-Instructions) for updates
2. Review recent issues for similar problems
3. Contact your team lead or submit an issue

---

**Last Updated:** October 6, 2025
