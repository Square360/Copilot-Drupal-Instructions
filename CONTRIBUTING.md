# Contributing to Copilot Drupal Instructions

Thank you for your interest in contributing to this project! This package helps standardize GitHub Copilot assistance across Square360's Drupal projects.

## How to Contribute

### Reporting Issues

If you find any issues or have suggestions for improvements:

1. Check if the issue already exists in the [Issues](https://github.com/Square360/copilot-drupal-instructions/issues) section
2. If not, create a new issue with:
   - Clear description of the problem or suggestion
   - Examples or use cases
   - Expected vs actual behavior (for bugs)

### Submitting Changes

1. **Fork the Repository**
   ```bash
   git clone https://github.com/Square360/copilot-drupal-instructions.git
   cd copilot-drupal-instructions
   ```

2. **Create a Feature Branch**
   ```bash
   git checkout -b feature/your-feature-name
   ```

3. **Make Your Changes**
   - Follow the existing documentation style
   - Ensure examples are accurate and tested
   - Update CHANGELOG.md with your changes

4. **Test Your Changes**
   - Install the package in a test Drupal project
   - Verify Copilot can access and use the instructions
   - Check that project-specific files are preserved during updates

5. **Commit Your Changes**
   ```bash
   git add .
   git commit -m "Brief description of changes"
   ```

6. **Push and Create Pull Request**
   ```bash
   git push origin feature/your-feature-name
   ```
   Then create a pull request on GitHub.

## Documentation Standards

### Style Guidelines

- Use clear, concise language
- Include code examples where applicable
- Follow Markdown best practices
- Keep examples compatible with Drupal 10 and 11

### File Organization

- **README.md** - Package overview and quick start
- **INSTALL.md** - Detailed installation instructions
- **instructions.md** - Copilot interaction patterns
- **drupal-modules.md** - Module development standards
- **themes-frontend.md** - Frontend development guidelines
- **accessibility.md** - WCAG compliance guidelines
- **security-performance.md** - Security and performance best practices

### Code Examples

When adding code examples:

```php
// ✅ Good: Clear, documented, follows Drupal standards
/**
 * Load a node by ID.
 */
public function loadNode(int $nid): ?NodeInterface {
  return $this->entityTypeManager
    ->getStorage('node')
    ->load($nid);
}

// ❌ Bad: Static calls, no documentation
function load_node($nid) {
  return Node::load($nid);
}
```

## Versioning

This project follows [Semantic Versioning](https://semver.org/):

- **MAJOR** - Breaking changes or major restructuring
- **MINOR** - New features, backwards compatible
- **PATCH** - Bug fixes, minor improvements

## Review Process

All contributions go through a review process:

1. Automated checks (if configured)
2. Peer review by maintainers
3. Testing in real projects
4. Approval and merge

## Questions?

If you have questions about contributing:

- Open a discussion on GitHub
- Contact Square360 development team
- Review existing documentation and issues

## Code of Conduct

- Be respectful and professional
- Focus on constructive feedback
- Help create a welcoming environment
- Follow Square360's development standards

## License

By contributing, you agree that your contributions will be licensed under the same MIT License that covers the project.
