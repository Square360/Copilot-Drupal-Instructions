# Drupal Module Development Guidelines

> **For GitHub Copilot:** When writing PHP code in `.module`, `.install`, `.theme`, or `src/` files, follow these Drupal-specific standards and patterns. Always prioritize dependency injection, PHPCS compliance, and Drupal best practices.

## PHPCS and Coding Standards

### Core Requirements
- **Always follow Drupal coding standards** as defined by `phpcs` with Drupal and DrupalPractice rulesets
- **Function naming**: Functions in `.module` files must be prefixed with the module name (e.g., `modulename_function_name`)
- **Hook implementations**: Use proper format `modulename_hook_name()` and document with `@implements hook_name()`
- **Line length**: Maximum 80 characters per line
- **Indentation**: 2 spaces for PHP, no tabs
- **Documentation**: All functions, classes, and methods must have proper doc blocks
- **Custom Module Naming**: Use the site machine name prefix for all custom modules

### Doc Block Requirements

```php
/**
 * Brief description of the function (starts with capital, ends with period).
 *
 * Longer description if needed. Explain the purpose and any important details.
 *
 * @param string $parameter_name
 *   Description of the parameter (starts lowercase, no period).
 * @param array $another_param
 *   Description of another parameter.
 *
 * @return string
 *   Description of return value (starts lowercase, no period).
 *
 * @throws \Exception
 *   When something goes wrong.
 */
function modulename_example_function($parameter_name, array $another_param) {
  // Function implementation.
}
```

## Dependency Injection

### Core Principles
- **Never use static calls** in classes (e.g., `\Drupal::`, `User::load()`, `Node::load()`)
- **Always inject services** via constructor and `create()` method

### Common Services to Inject
- `entity_type.manager` for entity operations
- `current_user` for user information
- `http_client` for external API calls
- `config.factory` for configuration
- `logger.factory` for logging
- `messenger` for user messages

### Example Implementation

```php
/**
 * Example controller with dependency injection.
 */
class ExampleController extends ControllerBase {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs an ExampleController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager, AccountProxyInterface $current_user) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('current_user')
    );
  }

}
```

## Module Structure

### Standard Directory Layout

```
module_name/
├── module_name.info.yml
├── module_name.module
├── module_name.install
├── module_name.routing.yml
├── module_name.services.yml
├── module_name.libraries.yml
├── config/
│   ├── install/
│   └── schema/
├── src/
│   ├── Controller/
│   ├── Form/
│   ├── Plugin/
│   └── Service/
└── templates/
```

## Configuration Management

### Best Practices
- Store configuration in `config/install/` for initial installation
- Use `config/schema/` for configuration schema definitions
- Never hardcode configuration values
- Use `\Drupal::config()` in procedural code or inject `config.factory` in classes

### Loading Configuration

```php
// Procedural code
$config = \Drupal::config('module_name.settings');
$value = $config->get('setting_key');

// In a class with DI
$config = $this->configFactory->get('module_name.settings');
$value = $config->get('setting_key');
```

## Entity Handling

### Entity Operations
- Use entity type manager for loading entities: `$this->entityTypeManager->getStorage('node')->load($nid)`
- Use entity query for complex queries
- Always check entity access before displaying
- Use entity view builders for rendering

### Entity Loading Examples

```php
// In a class with DI
$node_storage = $this->entityTypeManager->getStorage('node');
$node = $node_storage->load($nid);

// Multiple entities
$nodes = $node_storage->loadMultiple($nids);

// Entity query
$query = $this->entityTypeManager->getStorage('node')->getQuery();
$nids = $query
  ->condition('type', 'article')
  ->condition('status', 1)
  ->accessCheck(TRUE)
  ->execute();
```

### Entity Rendering

```php
$view_builder = $this->entityTypeManager->getViewBuilder('node');
$build = $view_builder->view($node, 'teaser');
```

## Form API

### Form Development Guidelines
- Extend `FormBase` or `ConfigFormBase`
- Use `#states` for dynamic form behavior
- Implement proper validation in `validateForm()`
- Use `MessengerInterface` for user feedback, not `drupal_set_message()`

### Form Structure Example

```php
$form['field_name'] = [
  '#type' => 'textfield',
  '#title' => $this->t('Field label'),
  '#required' => TRUE,
  '#description' => $this->t('Help text for the field'),
  '#attributes' => [
    'aria-describedby' => 'field-name-description',
  ],
];
```

## Logging and Messaging

### Logging

```php
// In a class with DI
$this->logger->error('Error message: @error', ['@error' => $error_message]);
$this->logger->warning('Warning message');
$this->logger->notice('Notice message');
```

### User Messages

```php
// In a class with DI
$this->messenger()->addMessage($this->t('Success message'));
$this->messenger()->addWarning($this->t('Warning message'));
$this->messenger()->addError($this->t('Error message'));
```

## Project-Specific Module Guidelines

**Note:** This section should be customized for your project after installation.

### Module Naming Convention

Example modules in this project:
- Core functionality: `yoursite_core`
- Custom content types: `yoursite_content`
- Search functionality: `yoursite_search`
- Integrations: `yoursite_integrations`

### Common Helper Functions

List project-specific helper functions and their usage here:
- Use `yoursite_core_helper_function()` for common operations
- Use `yoursite_core_get_config()` for configuration retrieval
- Use `yoursite_core_sanitize_input()` for input sanitization

## Testing and Quality Assurance

### Code Quality Checks
- Run `lando composer code-sniff` before committing
- Fix all PHPCS errors (warnings are acceptable if justified)
- Keep commits focused and atomic

### Documentation Standards

#### Inline Comments
- Explain "why", not "what"
- Keep comments up-to-date with code changes
- Use TODO comments with ticket numbers

#### README Files
- Include setup instructions
- Document environment variables
- List dependencies and requirements