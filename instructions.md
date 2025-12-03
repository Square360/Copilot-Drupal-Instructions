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

- **Do not run `lando composer code-sniff` unless requested** by the developer
- **"Prepare for push"** = Run `lando composer code-sniff`, fix issues, then run again to verify
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

### 🤖 Preventing AI Hallucinations

**Critical**: GitHub Copilot may "hallucinate" (invent) Drupal APIs, events, or services that don't exist.

#### 🔌 Context7 MCP Connection Check

**Before writing or testing Drupal code**, verify Context7 MCP connection:

1. **Test Connection**: Check if Context7 MCP tools are available
   - If Context7 tools (e.g., `mcp_context7_*`) are not available, the MCP server is not connected
   - Display setup instructions to the user

2. **Setup Instructions for Developers**:

   If Context7 MCP is not connected, provide these instructions:

   ```text
   🔧 Context7 MCP Setup Required for Drupal Development

   To get accurate Drupal API documentation, connect Context7 MCP:

   1. Open VS Code Settings (Cmd/Ctrl + ,)
   2. Search for "MCP Servers" or navigate to:
      Extensions > GitHub Copilot > MCP Servers

   3. Add Context7 MCP server:
      - Click "Add MCP Server"
      - Server Name: context7
      - Command: npx
      - Arguments: -y @context7/mcp

   4. Restart VS Code or reload window (Cmd/Ctrl + Shift + P → "Reload Window")

   5. Verify by asking Copilot to "Get Drupal documentation using Context7"

   📚 More info: https://github.com/context7/mcp
   ```

#### 🔍 Always Verify Against Official Sources

- **Use Context7 MCP for Drupal**: When writing or testing Drupal code, use Context7 to fetch current API documentation
- **Drupal 10 API**: <https://api.drupal.org/api/drupal/10>
- **Drupal 11 API**: <https://api.drupal.org/api/drupal/11>
- **Events Reference**: <https://api.drupal.org/api/drupal/core%21core.api.php/group/events/>
- **Services List**: Use `drush eval "print_r(\Drupal::getContainer()->getServiceIds());"` for actual services
- **Hook Reference**: <https://api.drupal.org/api/drupal/core%21core.api.php/group/hooks/>

#### ⚠️ Common Hallucinations to Watch For

- **Fake Events**: `EntityUpdateEvent`, `NodeSaveEvent` (real: `EntityEvent`, hook_entity_update())
- **Non-existent Services**: Always check service exists before injecting
- **Deprecated APIs**: Verify methods exist in your Drupal version
- **Made-up Hook Names**: Cross-reference with official hook documentation

#### ✅ Verification Workflow

1. **Check Context7 MCP Connection**: Ensure Context7 MCP is available before writing Drupal code
2. **Use Context7 First**: Before implementing Drupal APIs, use Context7 MCP to get current documentation
3. **For Events**: Check <https://api.drupal.org/api/drupal/core%21core.api.php/group/events/> for real event names
4. **For Services**: Use `lando drush eval "print_r(\Drupal::getContainer()->getServiceIds());"` to list actual services
5. **For Methods**: Search official API docs for class/interface documentation
6. **For Hooks**: Verify hook exists in core.api.php or module documentation

#### 📝 Best Practices

- **Use Context7 MCP for Drupal documentation** before implementing any Drupal APIs
- **Copy exact API signatures** from official documentation
- **Test immediately** after implementing AI suggestions
- **Use IDE autocomplete** to verify method/class existence
- **Check deprecation warnings** in your Drupal version

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
- When I say "Prepare for push", run `lando composer code-sniff`, attempt to correct any errors, then run it again to verify no new issues have arisen.
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