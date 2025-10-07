# GitHub Copilot Interaction Instructions

> **For GitHub Copilot:** At the END of every development session, you MUST proactively ask: "Should I summarize the completed work and update the changelog?" Then add a comprehensive summary to the project root file `CHANGELOG-COPILOT.md` (located at `./CHANGELOG-COPILOT.md`). This is not optional - it's a required workflow step.

> **For Developers:** Always end sessions by asking: "Summarize the work completed in this session and add it to the project root file CHANGELOG-COPILOT.md"

## General Development Guidance

This file contains best practices and interaction patterns for working with GitHub Copilot on Drupal projects.

## Communication Patterns

### ✅ Effective Interaction Strategies

1. **Be Specific with Requests**
   - Provide clear context about what you want to accomplish
   - Include relevant file paths, function names, or code snippets
   - Specify the desired outcome or behavior

2. **Share Relevant Context**
   - Attach files that are related to the task
   - Mention any constraints or requirements
   - Reference existing patterns or standards when applicable

3. **Break Down Complex Tasks**
   - Large requests work better when split into logical steps
   - Allow for iterative development and testing
   - Confirm each step before moving to the next

### 🚨 Known Technical Issues

1. **Terminal Command Processing**
   - **Issue**: AI may hang after using `run_in_terminal` tool
   - **Workaround**: Stop generation and confirm "command completed"
   - **Better Pattern**: AI should use `run_in_terminal` + immediate verification tools
   - **Reported**: Issue logged with GitHub Copilot support

## Project-Specific Guidelines

### Code Quality Standards
- Always run `lando composer code-sniff` before finalizing changes
- Follow Drupal coding standards and dependency injection patterns
- Maintain comprehensive documentation for all methods
- Use semantic commit messages

### Development Workflow
1. **Start with Context**: Review recent changelog entries and existing code
2. **Plan Before Coding**: Break complex tasks into manageable steps
3. **Test Thoroughly**: Verify functionality manually and check for regressions
4. **Document Everything**: Update changelogs, comments, and instructions

### File Organization
- Keep Copilot instructions organized by domain (modules, themes, security, etc.)
- Update session checklist after each development session
- Maintain comprehensive changelog with technical details
- Use consistent formatting and structure across documentation

## Collaboration Best Practices

### For Developers
- **Provide Clear Problem Statements**: Explain what needs to be solved and why
- **Share Error Messages**: Include full error text and context
- **Specify Environment Details**: Mention if testing on local, staging, or production
- **Reference Existing Code**: Point to similar implementations when available

### For AI Assistant
- **Verify Understanding**: Confirm requirements before implementing
- **Explain Technical Decisions**: Document why specific approaches were chosen
- **Provide Multiple Options**: When applicable, offer alternative solutions
- **Test Thoroughly**: Validate changes before marking tasks complete

## Common shortcuts and commands

### Shortcuts
 - When I say "Add to changelog", add a detailed entry to the project root file `CHANGELOG-COPILOT.md` (located at `./CHANGELOG-COPILOT.md`) summarizing the work done in this session.
 - When I say "Run code sniff", execute `lando composer code-sniff` and report any issues found.
 - When I say "terminal done", it means "the terminal command has completed successfully, please continue".

## Common Development Patterns

### Drupal Controller Enhancement
```php
// Standard dependency injection pattern
public function __construct(
  protected readonly ServiceInterface $service,
) {}

public static function create(ContainerInterface $container): self {
  return new self(
    $container->get('service_name'),
  );
}
```

### Error Handling
```php
try {
  // Operation that might fail
} catch (\Exception $e) {
  $this->logger->error('Error message: ' . $e->getMessage());
  // Graceful fallback
}
```

### Twig Template Libraries
```twig
{{ attach_library('module_name/library.base') }}
{{ attach_library('module_name/library.specific') }}
```

## Documentation Standards

### Changelog Entries
- Include problem/solution description
- Provide technical implementation details
- Add code examples for complex patterns
- Document user experience improvements

### Code Comments
- Explain complex business logic
- Document security considerations
- Note performance implications
- Reference related functionality

### Method Documentation
```php
/**
 * Brief description of what the method does.
 *
 * @param string $parameter
 *   Description of the parameter.
 *
 * @return mixed
 *   Description of return value.
 */
```

## Troubleshooting Guide

### Common Issues and Solutions

1. **PHPCS Violations**
   - Run: `lando composer code-sniff`
   - Fix naming conventions and documentation
   - Ensure proper dependency injection

2. **Template Library Issues**
   - Check library definitions in `.libraries.yml`
   - Verify file paths and dependencies
   - Ensure proper Twig syntax

3. **Controller Access Issues**
   - Verify proper dependency injection
   - Check service definitions
   - Confirm access control logic

## Quality Assurance Checklist

Before concluding any development session:

- [ ] All requested functionality implemented
- [ ] Code passes PHPCS validation
- [ ] Manual testing completed successfully
- [ ] Documentation updated appropriately
- [ ] Changelog entries added
- [ ] No regression issues identified

## Future Improvements

### Areas for Enhancement
- Automated testing integration
- Performance monitoring setup
- Security scanning automation
- Accessibility testing procedures

### Learning Opportunities
- Advanced Drupal patterns
- Modern JavaScript/TypeScript practices
- Accessibility best practices
- Performance optimization techniques


---

## Notes for Future Sessions

- Always check recent changelog entries before starting
- Review existing patterns before implementing new features
- Do not look for code changes beyond the scope of the task
- Test changes in development environment first
- Document any new patterns or decisions made

**Remember**: These instructions evolve with our development practices. Update this file when new patterns emerge or better approaches are discovered.