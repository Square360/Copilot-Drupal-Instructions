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

# Personal Developer Instructions

You can create a `.copilot.local.md` file in this directory for your personal, developer-specific instructions:

- **Not tracked in git**: Your personal preferences stay private
- **Testing ground**: Try new instruction patterns before proposing to the team
- **Personal shortcuts**: Define aliases and shortcuts that work for your workflow
- **Local environment**: Document your specific dev setup (Lando config, local URLs, etc.)
- **Style preferences**: Add personal coding style preferences that supplement team standards

To get started: `cp .copilot.local.md.example .copilot.local.md`

Copilot will automatically reference your `.copilot.local.md` file alongside the team instructions.