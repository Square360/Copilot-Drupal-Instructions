# Security and Performance Guidelines

## Security Best Practices

### Input Validation and Sanitization

#### Core Principles
- **Always validate and sanitize user input**
- **Never trust data from external sources**
- **Use Drupal's built-in sanitization functions**
- **Validate on both client and server side**

#### Drupal Security Functions

```php
// Sanitize HTML content
use Drupal\Component\Utility\Xss;
$safe_html = Xss::filter($untrusted_html);

// Escape plain text output
use Drupal\Component\Utility\Html;
$safe_text = Html::escape($untrusted_text);

// Sanitize URLs
use Drupal\Component\Utility\UrlHelper;
$safe_url = UrlHelper::filterBadProtocol($untrusted_url);

// Validate email addresses
if (!\Drupal::service('email.validator')->isValid($email)) {
  // Handle invalid email
}
```

#### Form Validation

```php
/**
 * {@inheritdoc}
 */
public function validateForm(array &$form, FormStateInterface $form_state) {
  $email = $form_state->getValue('email');

  // Validate email format
  if (!\Drupal::service('email.validator')->isValid($email)) {
    $form_state->setErrorByName('email', $this->t('Please enter a valid email address.'));
  }

  // Validate text length
  $message = $form_state->getValue('message');
  if (strlen($message) > 1000) {
    $form_state->setErrorByName('message', $this->t('Message cannot exceed 1000 characters.'));
  }

  // Sanitize text input
  $form_state->setValue('message', Html::escape($message));
}
```

### Output Escaping

#### Twig Template Security

```twig
{# Auto-escaped by default #}
{{ title }}

{# Manual escaping when needed #}
{{ url('<front>')|escape('url') }}

{# Raw output - ONLY use when content is already sanitized #}
{{ content|raw }}

{# Escape specific contexts #}
{{ user_input|escape('html') }}
{{ user_input|escape('js') }}
{{ user_input|escape('css') }}
```

#### PHP Output Escaping

```php
// In render arrays - automatically escaped
$build['content'] = [
  '#markup' => $this->t('Safe content: @input', ['@input' => $user_input]),
];

// Manual escaping when building HTML
$output = '<div class="' . Html::escape($css_class) . '">';
$output .= Html::escape($user_content);
$output .= '</div>';
```

### Permission and Access Control

#### Access Checking

```php
// Check user permissions
if (!$this->currentUser->hasPermission('access content')) {
  throw new AccessDeniedHttpException();
}

// Entity access checking
$node = $this->entityTypeManager->getStorage('node')->load($nid);
if (!$node || !$node->access('view', $this->currentUser)) {
  throw new AccessDeniedHttpException();
}

// Controller access methods
public function access(AccountInterface $account) {
  return AccessResult::allowedIfHasPermission($account, 'view special content')
    ->andIf(AccessResult::allowedIf($this->customCondition()));
}
```

#### Route Security

```yaml
# module_name.routing.yml
module_name.secure_page:
  path: '/admin/secure-page'
  defaults:
    _controller: '\Drupal\module_name\Controller\SecureController::build'
    _title: 'Secure Page'
  requirements:
    _permission: 'administer site configuration'
  options:
    _admin_route: TRUE
```

### SQL Injection Prevention

```php
// GOOD: Use entity query
$query = $this->entityTypeManager->getStorage('node')->getQuery();
$nids = $query
  ->condition('type', $content_type)
  ->condition('status', 1)
  ->condition('title', $search_term, 'CONTAINS')
  ->accessCheck(TRUE)
  ->execute();

// GOOD: Use database API with placeholders
$query = $this->database->select('node_field_data', 'n');
$query->fields('n', ['nid', 'title']);
$query->condition('n.type', $content_type);
$query->condition('n.title', '%' . $query->escapeLike($search_term) . '%', 'LIKE');
$result = $query->execute();

// BAD: Never concatenate user input into queries
// $query = "SELECT * FROM node WHERE title = '" . $user_input . "'";
```

## Performance Optimization

### Caching Strategies

#### Cache Tags and Contexts

```php
// Use cache tags for automatic invalidation
$build = [
  '#markup' => $this->generateContent(),
  '#cache' => [
    'tags' => ['node:' . $node->id(), 'user:' . $this->currentUser->id()],
    'contexts' => ['user.permissions', 'route'],
    'max-age' => 3600, // 1 hour
  ],
];

// Cache invalidation
\Drupal::service('cache_tags.invalidator')->invalidateTags(['node:' . $node->id()]);
```

#### Lazy Builders for Dynamic Content

```php
// Create lazy builder service
class DynamicContentBuilder {

  public static function buildDynamicContent($parameter) {
    return [
      '#markup' => 'Dynamic content based on: ' . $parameter,
      '#cache' => [
        'contexts' => ['user'],
        'max-age' => 0, // Don't cache
      ],
    ];
  }
}

// Use in render array
$build['dynamic'] = [
  '#lazy_builder' => ['dynamic_content.builder:buildDynamicContent', [$parameter]],
  '#create_placeholder' => TRUE,
];
```

#### Configuration Caching

```php
// Cache configuration objects
$config = $this->configFactory->get('module_name.settings');
$cached_value = $config->get('expensive_calculation');

if (!$cached_value) {
  $cached_value = $this->performExpensiveCalculation();
  $config->set('expensive_calculation', $cached_value)->save();
}
```

### Database Query Optimization

#### Entity Query Best Practices

```php
// Efficient entity queries
$query = $this->entityTypeManager->getStorage('node')->getQuery();
$query->condition('type', 'article')
  ->condition('status', 1)
  ->sort('created', 'DESC')
  ->range(0, 10) // Limit results
  ->accessCheck(TRUE);

// Add indexes for queried fields
$nids = $query->execute();

// Load entities efficiently
if (!empty($nids)) {
  $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($nids);
}
```

#### Database Indexes

```php
// In .install file
function module_name_schema() {
  $schema['custom_table'] = [
    'fields' => [
      'id' => [
        'type' => 'serial',
        'not null' => TRUE,
      ],
      'user_id' => [
        'type' => 'int',
        'not null' => TRUE,
      ],
      'created' => [
        'type' => 'int',
        'not null' => TRUE,
      ],
    ],
    'primary key' => ['id'],
    'indexes' => [
      'user_created' => ['user_id', 'created'], // Composite index
      'created' => ['created'], // Single field index
    ],
  ];

  return $schema;
}
```

### Memory Management

#### Batch Processing for Large Datasets

```php
// Batch operations for large data sets
function module_name_process_large_dataset() {
  $batch = [
    'title' => t('Processing large dataset'),
    'operations' => [],
    'finished' => 'module_name_batch_finished',
  ];

  $total_items = 10000;
  $batch_size = 100;

  for ($i = 0; $i < $total_items; $i += $batch_size) {
    $batch['operations'][] = [
      'module_name_batch_process',
      [$i, $batch_size],
    ];
  }

  batch_set($batch);
}

function module_name_batch_process($start, $batch_size, &$context) {
  // Process batch of items
  $items = range($start, $start + $batch_size - 1);

  foreach ($items as $item) {
    // Process individual item
    module_name_process_item($item);
  }

  $context['results'][] = count($items);
  $context['message'] = t('Processed @start to @end', [
    '@start' => $start,
    '@end' => $start + $batch_size - 1,
  ]);
}
```

#### Memory-Efficient Entity Loading

```php
// Avoid loading all entities at once
$query = $this->entityTypeManager->getStorage('node')->getQuery();
$query->condition('type', 'article')
  ->condition('status', 1)
  ->accessCheck(TRUE);

$nids = $query->execute();

// Process in chunks
$chunk_size = 50;
$chunks = array_chunk($nids, $chunk_size);

foreach ($chunks as $chunk) {
  $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($chunk);

  foreach ($nodes as $node) {
    // Process node
    $this->processNode($node);
  }

  // Clear loaded entities from memory
  unset($nodes);
}
```

### Frontend Performance

#### Asset Aggregation and Compression

```yaml
# In .info.yml file
libraries:
  - theme_name/critical-css
  - theme_name/main

# In .libraries.yml
critical-css:
  css:
    theme:
      dist/css/critical.css: { preprocess: false, weight: -100 }

main:
  css:
    theme:
      dist/css/main.css: { preprocess: true }
  js:
    dist/js/main.js: { preprocess: true, minified: true }
```

#### Image Optimization

```php
// Responsive images in render arrays
$build['image'] = [
  '#theme' => 'responsive_image',
  '#responsive_image_style_id' => 'hero_image',
  '#uri' => $image_uri,
  '#alt' => $alt_text,
  '#attributes' => ['loading' => 'lazy'],
];

// Image style definitions for different breakpoints
// Configure in admin/config/media/responsive-image-style
```

#### JavaScript Performance

```javascript
// Use Intersection Observer for lazy loading
const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      loadContent(entry.target);
      observer.unobserve(entry.target);
    }
  });
});

// Debounce expensive operations
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Use with Drupal behaviors
Drupal.behaviors.performantSearch = {
  attach: function (context) {
    const searchInput = context.querySelector('#search-input');
    if (searchInput) {
      const debouncedSearch = debounce((query) => {
        performSearch(query);
      }, 300);

      searchInput.addEventListener('input', (e) => {
        debouncedSearch(e.target.value);
      });
    }
  }
};
```

## Monitoring and Maintenance

### Performance Monitoring

```php
// Log slow queries and operations
$start_time = microtime(TRUE);

// Perform operation
$result = $this->performExpensiveOperation();

$execution_time = microtime(TRUE) - $start_time;
if ($execution_time > 1.0) { // Log operations taking more than 1 second
  $this->logger->warning('Slow operation detected: @operation took @time seconds', [
    '@operation' => 'expensive_operation',
    '@time' => round($execution_time, 2),
  ]);
}
```

### Security Logging

```php
// Log security-related events
$this->logger->notice('User login attempt: @username from @ip', [
  '@username' => $username,
  '@ip' => $request->getClientIp(),
]);

// Log access attempts
$this->logger->warning('Unauthorized access attempt to @path by user @uid', [
  '@path' => $request->getRequestUri(),
  '@uid' => $this->currentUser->id(),
]);
```

### Regular Maintenance Tasks

```php
// Implement hook_cron for regular cleanup
function module_name_cron() {
  // Clean up old log entries
  $database = \Drupal::database();
  $database->delete('module_name_logs')
    ->condition('created', \Drupal::time()->getRequestTime() - 2592000, '<') // 30 days
    ->execute();

  // Clear expired cache entries
  \Drupal::cache()->deleteMultiple(['expensive_calculation_1', 'expensive_calculation_2']);
}
```

## Configuration Security

### Environment-Specific Settings

```php
// In settings.php - never commit sensitive data
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {
  include $app_root . '/' . $site_path . '/settings.local.php';
}

// Use environment variables for sensitive configuration
$config['system.mail']['default-system']['mail'] = getenv('SITE_MAIL') ?: 'noreply@example.com';

// Disable certain modules in production
if (isset($_ENV['PANTHEON_ENVIRONMENT']) && $_ENV['PANTHEON_ENVIRONMENT'] === 'live') {
  $config['system.performance']['css']['preprocess'] = TRUE;
  $config['system.performance']['js']['preprocess'] = TRUE;
  $config['system.logging']['error_level'] = 'none';
}
```

### Content Security Policy

```php
// Implement CSP headers
function module_name_page_attachments_alter(array &$attachments) {
  $csp = "default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'";

  $attachments['#attached']['http_header'][] = [
    'Content-Security-Policy',
    $csp,
  ];
}
```