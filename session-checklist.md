# Development Session Checklist

> **For GitHub Copilot:** At the end of EVERY development session, proactively offer to summarize the completed work and update the project root file `CHANGELOG-COPILOT.md` (located at `./CHANGELOG-COPILOT.md`). Do not wait for the user to ask - this is a required step.

> **For Developers:** Make it a habit to ask Copilot to summarize your session and update the changelog. Simply say: "Summarize the work completed in this session and add it to the project root file CHANGELOG-COPILOT.md"

## End-of-Session Requirements

At the conclusion of every development session, ensure the following tasks are completed:

### 1. Update Changelog Documentation ✅
- [ ] Add new accomplishments to the project root file `CHANGELOG-COPILOT.md` (located at `./CHANGELOG-COPILOT.md`)
- [ ] Include problem/solution descriptions for each task
- [ ] Document technical implementation details with code examples
- [ ] Note any new patterns or standards established
- [ ] **Add date and time stamp for each entry** (Format: YYYY-MM-DD HH:MM timezone)
- [ ] Update the "Last Updated" date

### 2. Code Quality Verification ✅
- [ ] Run `lando composer code-sniff` to verify PHPCS compliance
- [ ] Fix any coding standard violations
- [ ] Ensure all new code follows established dependency injection patterns
- [ ] Verify proper documentation/docblocks for new methods

### 3. Testing and Validation ✅
- [ ] Test new functionality manually in the browser
- [ ] Verify no PHP errors or warnings in logs
- [ ] Confirm user experience improvements work as expected
- [ ] Check that existing functionality still works (regression testing)

### 4. Documentation Updates ✅
- [ ] Update relevant Copilot instruction files if new patterns emerged
- [ ] Document any new development standards or practices
- [ ] Note any technical decisions that future developers should know about

### 5. Repository Housekeeping ✅
- [ ] Ensure all changes are properly committed with meaningful commit messages
- [ ] Update any relevant README files or module documentation
- [ ] Clean up any temporary files or debugging code

## Changelog Update Template

When adding to the project root file `CHANGELOG-COPILOT.md` (located at `./CHANGELOG-COPILOT.md`), use this structure:

```markdown
### X. [Feature/Enhancement Name] *(YYYY-MM-DD HH:MM timezone)*

- **Problem**: [Description of what needed to be solved]
- **Solution**: [High-level approach taken]
- **Implementation**:
  - [Bullet point of specific changes made]
  - [Technical details and services used]
  - [Files modified or created]
- **Benefits/Impact**: [How this improves the system]

#### Technical Implementation Details

```php
// Code examples showing key patterns or methods
```

#### Example Behavior/Usage

- [Specific examples of how the feature works]
- [Before and after comparisons if applicable]
```

## Session Completion Confirmation

Before closing the session, confirm:
- ✅ All requested tasks have been completed
- ✅ Code quality standards maintained
- ✅ Documentation updated appropriately
- ✅ User experience improvements validated
- ✅ No regressions introduced

## Notes for Future Sessions

- Always check the current state of files before making changes
- Review recent changelog entries to understand previous work
- Follow established patterns and standards documented in Copilot instructions
- Test thoroughly, especially when modifying existing functionality

---

**Remember**: Good documentation today saves hours of confusion tomorrow. Take the extra few minutes to document your work properly - future you (and your teammates) will thank you!