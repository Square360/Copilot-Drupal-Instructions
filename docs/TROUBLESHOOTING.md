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

**This should NOT happen** with the current package design.

**How It Works:**
- The `CHANGELOG-COPILOT.md` template is included in the installed README.md file
- The auto-customization prompt copies this template to `CHANGELOG-COPILOT.md` and customizes it
- After copying, the template section is removed from README.md
- Future updates only update instruction files, not the project-specific changelog

**If Your Changelog Is Missing:**

1. **Check if auto-customization was run:**

Look for the "Changelog Template" section in your `.github/copilot/README.md`. If it's there, run the auto-customization prompt:

```
I just installed the square360/copilot-drupal-instructions package into my Drupal project.
Please update the files in .github/copilot/ to reflect this project...
```

2. **Manual recovery:**

If the template section was removed but `CHANGELOG-COPILOT.md` wasn't created, copy the template from the package repository:

```bash
cd .github/copilot/
curl -O https://raw.githubusercontent.com/Square360/Copilot-Drupal-Instructions/master/CHANGELOG-COPILOT.md
```

3. **Recover lost entries from git:**

If you had a changelog that got overwritten:

```bash
git log CHANGELOG-COPILOT.md
git show <commit-hash>:CHANGELOG-COPILOT.md > CHANGELOG-COPILOT.md
```

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
- `copilot.local.md` file is being committed to git
- Personal instructions are visible to the team
- File changes are tracked by git

**Solution:**

1. Ensure `copilot.local.md` is in your project's `.gitignore`:

```bash
echo ".github/copilot/copilot.local.md" >> .gitignore
```

2. If already committed, remove from git (but keep local copy):

```bash
git rm --cached .github/copilot/copilot.local.md
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
