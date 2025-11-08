## ClickUp Wiki Documentation Workflow

### Prerequisites: ClickUp MCP Server Connection

**Before performing any ClickUp operations**, verify the MCP server connection:

1. **Test Connection**: Check if ClickUp MCP tools are available
   - If ClickUp tools (e.g., `activate_clickup_*`) are not available, the MCP server is not connected
   - Display setup instructions to the user

2. **Setup Instructions for Developers**:

   If the ClickUp MCP server is not connected, provide these instructions:

   ```text
   🔧 ClickUp MCP Server Setup Required

   To enable ClickUp integration, you need to connect the ClickUp MCP server:

   1. Open VS Code Settings (Cmd/Ctrl + ,)
   2. Search for "MCP Servers" or navigate to:
      Extensions > GitHub Copilot > MCP Servers

   3. Add the ClickUp MCP server configuration:
      - Click "Add MCP Server"
      - Server Name: clickup
      - Command: npx
      - Arguments: -y @modelcontextprotocol/server-clickup

   4. Set your ClickUp API Token:
      - Get your API token from: https://app.clickup.com/settings/apps
      - In VS Code MCP settings, add environment variable:
        CLICKUP_API_TOKEN=your_api_token_here

   5. Restart VS Code or reload the window (Cmd/Ctrl + Shift + P → "Reload Window")

   6. Verify connection by asking Copilot to list ClickUp workspaces

   📚 More info: https://github.com/modelcontextprotocol/servers/tree/main/src/clickup
   ```

3. **After Connection**: Once connected, the agent will have access to ClickUp tools for:
   - Creating and updating documents
   - Managing tasks
   - Searching spaces and pages
   - Time tracking integration

---

### GitHub Integration

**When creating ClickUp documentation**, check for GitHub context:

1. **Detect Current Branch PR**:
   - Determine if the current working branch is connected to a GitHub pull request
   - Use GitHub MCP tools or git information to find associated PR
   - If a PR exists, include it in the documentation

2. **PR Information to Include**:
   - PR number and title
   - Direct link to the pull request
   - PR status (open, draft, ready for review)
   - Format the link prominently in the ClickUp document

3. **Example Format**:

   ```markdown
   ---
   **Related GitHub PR**: [#123 - Add AI Webform Guard Integration](https://github.com/Square360/project-name/pull/123)
   **Status**: Ready for Review
   ---
   ```

---

### ClickUp Documentation Workflow

When the user says **"Add to Wiki"** or similar phrases:

1. **Determine the ClickUp Space**:
   - **If unsure which client/project** → Ask: "Which ClickUp Space would you like to post this to? (e.g., client name, project name, or 'Company Wiki')"
   - **If project context is clear** → Confirm the Space before proceeding
   - **Common destinations**:
     - Client/Project-specific wikis (e.g., project documentation spaces)
     - Company internal wiki (e.g., "Company Wiki" or "Development")

2. **Locate Documentation Structure**:
   - Search for the appropriate parent page (typically "Technical Analyses" or similar documentation section)
   - If you don't have the document IDs, use ClickUp tools to search for the Space and locate the parent page
   - Ask user for specific parent page if the structure is unclear

3. **Document structure**:
   - **Each analysis should be a NEW subpage** under the appropriate section (e.g., Technical Analyses)
   - **Only add to existing pages** when explicitly updating/expanding existing documentation
   - Each new page should have a clear, descriptive title (e.g., "Module Interaction Analysis: AI Webform Guard & ConvertKit")

4. **What to include** in technical analyses:
   - Executive summary of findings
   - Detailed technical explanation
   - Code examples and execution flow diagrams
   - Recommendations and best practices
   - Related files and resources
   - Date and context
   - **GitHub Pull Request link** (if the current branch is connected to a PR):
     - Check if the current working branch has an associated pull request
     - If a PR exists, include the PR link at the top or bottom of the documentation
     - Format: `Related PR: [#123 - PR Title](https://github.com/owner/repo/pull/123)`
     - This helps track which code changes are related to the documentation

5. **User phrases to watch for**:
   - "Add to wiki" / "Post to wiki" / "Document this"
   - "Add this to ClickUp" / "Create a ClickUp doc"
   - "Post this to [client/project] wiki"
   - "Document in Technical Analyses"
   - **If user says "update existing" or "add to existing"** → Use update_document_page instead of creating new

6. **Workflow**:

   ```text
   User: "Add to wiki"
   → Ask: "Which ClickUp Space would you like to post this to?"
   User: "[Client/Project Name]"
   → Locate the appropriate Space and documentation section
   → Create page under appropriate parent section
   → Confirm with link
   ```

7. **Tips for Space Discovery**:
   - If user mentions a client or project name, search for a ClickUp Space matching that name
   - Look for common documentation sections like "Technical Analyses", "Documentation", or "Knowledge Base"
   - When in doubt, ask the user to specify the exact Space name or provide additional context
