# Overview: How GitHub Copilot Uses These Instructions

## Context-Aware Assistance

GitHub Copilot automatically applies relevant instructions based on the file you're editing:

| File Type | Copilot References | For |
|-----------|-------------------|-----|
| `.module`, `.install`, `.php` in modules | `drupal-modules.md` | PHPCS standards, dependency injection, Drupal APIs |
| `.scss`, `.css`, `.js`, `.ts` | `themes-frontend.md` | Frontend patterns, BEM, JavaScript behaviors |
| `.twig`, forms, UI components | `accessibility.md` | WCAG 2.1 AA compliance, semantic HTML |
| Controllers, services, APIs | `security-performance.md` | Security practices, caching, performance |

**All file types** will reference:
- `instructions.md` - General Copilot interaction patterns
- `PROJECT-README.md` / `README.md` - Project-specific context
- `.copilot.local.md` - Your personal preferences (if present)

## Benefits of This Organization

### For Copilot
- **Focused Context**: Each file contains domain-specific instructions, preventing information overload
- **Better Suggestions**: More relevant code completions based on current work context
- **Consistent Patterns**: Copilot learns your project's specific conventions

### For Developers
- **Easier Maintenance**: Update specific areas without affecting other guidelines
- **Team Collaboration**: Different team members can focus on their expertise areas
- **Scalability**: Easy to add new instruction files as the project grows
- **Onboarding**: New team members get instant context

# Personal Developer Instructions

You can create a `.copilot.local.md` file in this directory for your personal, developer-specific instructions:

- **Not tracked in git**: Your personal preferences stay private
- **Testing ground**: Try new instruction patterns before proposing to the team
- **Personal shortcuts**: Define aliases and shortcuts that work for your workflow
- **Local environment**: Document your specific dev setup (Lando config, local URLs, etc.)
- **Style preferences**: Add personal coding style preferences that supplement team standards

To get started: `cp .copilot.local.md.example .copilot.local.md`

Copilot will automatically reference your `.copilot.local.md` file alongside the team instructions.