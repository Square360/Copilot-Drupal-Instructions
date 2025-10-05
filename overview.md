# How GitHub Copilot Will Use These Files
Context-Aware Assistance: Copilot will automatically apply the relevant instructions based on what you're working on:

- Working on .module files: Will reference drupal-modules.md for PHPCS standards and dependency injection
- Editing .scss or .js files: Will use themes-frontend.md for frontend best practices
- Creating forms or templates: Will apply accessibility.md for WCAG compliance
- Building controllers or services: Will reference security-performance.md for secure coding

# Key Benefits of This Organization
- Focused Context: Each file contains domain-specific rules that won't overwhelm Copilot with unrelated information
- Easier Maintenance: You can update specific areas without affecting other guidelines
- Team Collaboration: Different team members can focus on their expertise areas
- Scalability: Easy to add new instruction files as the project grows