# [Project Name] - Copilot Instructions

> **Note:** This file should be renamed to `README.md` in `.github/copilot/` and customized for your project.

## Project Information

- **Site Name:** [Your Site Name]
- **Live URL:** [https://yourproject.com](https://yourproject.com)
- **Repository:** [https://github.com/YourOrg/your-project](https://github.com/YourOrg/your-project)
- **Module Prefix:** `yoursite_`

## Development Environment

- **Local Setup:** Lando / DDEV / other
- **PHP Version:** 8.1 / 8.2 / 8.3
- **Drupal Version:** 10.x / 11.x
- **Database:** MySQL / PostgreSQL
- **Hosting:** Pantheon / Acquia / other

## Custom Modules

List your custom modules here with brief descriptions:

- **`yoursite_core`** - Core functionality and utilities
- **`yoursite_content`** - Custom content types and fields
- **`yoursite_search`** - Search functionality
- **`yoursite_integrations`** - Third-party integrations

## Custom Themes

- **`yoursite_theme`** - Main theme (base: classy/gin/stable9)

## GitHub Copilot Instruction Files

These files guide GitHub Copilot to provide project-aware assistance:

- **[drupal-modules.md](./drupal-modules.md)** - Module development standards
- **[themes-frontend.md](./themes-frontend.md)** - Frontend development guidelines
- **[accessibility.md](./accessibility.md)** - Accessibility requirements
- **[security-performance.md](./security-performance.md)** - Security and performance
- **[instructions.md](./instructions.md)** - Copilot usage patterns
- **[overview.md](./overview.md)** - How Copilot uses these files
- **[copilot-changelog.md](./copilot-changelog.md)** - Project development history
- **[session-checklist.md](./session-checklist.md)** - Development session checklist

## Common Commands

### Development
```bash
lando composer code-sniff    # Run PHPCS
lando composer code-fix      # Auto-fix PHPCS issues
lando drush cr               # Clear cache
lando drush updb             # Run database updates
lando drush cim              # Import configuration
lando drush cex              # Export configuration
```

### Testing
```bash
lando phpunit                # Run unit tests
lando behat                  # Run Behat tests
```

## Project-Specific Patterns

### Custom Helper Functions

Document common helper functions:
- `yoursite_core_get_config($key)` - Get configuration value
- `yoursite_core_log_event($message)` - Log custom events

### Common Workflows

Document frequent development patterns:
1. Creating a new content type
2. Adding a custom block
3. Implementing a service
4. Creating a form

## API Integrations

List third-party APIs used:
- **API Name** - Purpose, authentication method, docs link

## Deployment Process

Brief overview of deployment workflow:
1. Create feature branch
2. Run code quality checks
3. Create pull request
4. QA review
5. Merge to main
6. Deploy to staging
7. Deploy to production

## Team Contacts

- **Project Lead:** [Name]
- **Backend Lead:** [Name]
- **Frontend Lead:** [Name]

## Resources

- Project Documentation: [Link]
- Design System: [Link]
- Issue Tracker: [Link]

---

**Last Updated:** [Date]
**Copilot Instructions Version:** [Package Version]
