# Accessibility Guidelines - WCAG 2.1 AA Standards

## Core Accessibility Principles

### Always Ensure
- **Perceivable**: Information must be presentable in ways users can perceive
- **Operable**: Interface components must be operable by all users
- **Understandable**: Information and UI operation must be understandable
- **Robust**: Content must be robust enough for various assistive technologies

## Semantic HTML Requirements

### Proper Document Structure

```html
<!-- Correct heading hierarchy -->
<h1>Page Title</h1>
  <h2>Section Title</h2>
    <h3>Subsection Title</h3>
    <h3>Another Subsection</h3>
  <h2>Another Section</h2>
```

### Semantic Elements

```html
<!-- Use semantic HTML5 elements -->
<nav aria-label="Main navigation">
  <ul>
    <li><a href="/">Home</a></li>
    <li><a href="/about">About</a></li>
  </ul>
</nav>

<main>
  <article>
    <header>
      <h1>Article Title</h1>
    </header>
    <section>
      <h2>Section Heading</h2>
      <p>Content...</p>
    </section>
  </article>
</main>

<aside>
  <h2>Related Links</h2>
  <!-- Sidebar content -->
</aside>

<footer>
  <!-- Footer content -->
</footer>
```

### Interactive Elements

```html
<!-- Use buttons for actions -->
<button type="button" aria-label="Close dialog">
  <span aria-hidden="true">×</span>
</button>

<!-- Use links for navigation -->
<a href="/contact" aria-describedby="contact-description">
  Contact Us
</a>
<p id="contact-description">Get in touch with our support team</p>
```

## Keyboard Navigation

### Accessibility Requirements

- All interactive elements must be keyboard accessible
- Provide visible focus indicators
- Use `tabindex="0"` only when necessary, avoid positive values
- Implement skip links for main content

### Focus Management

```css
/* Visible focus indicators */
a:focus,
button:focus,
input:focus,
select:focus,
textarea:focus {
  outline: 2px solid #0066cc;
  outline-offset: 2px;
}

/* Skip link implementation */
.skip-link {
  position: absolute;
  top: -40px;
  left: 6px;
  z-index: 999999;
  text-decoration: underline;
  background: #000;
  color: #fff;
  padding: 8px 16px;
}

.skip-link:focus {
  top: 6px;
}
```

### Skip Navigation

```html
<!-- Skip links at the beginning of the page -->
<div class="skip-links">
  <a href="#main-content" class="skip-link">Skip to main content</a>
  <a href="#main-navigation" class="skip-link">Skip to navigation</a>
</div>
```

## ARIA Attributes and Roles

### Proper ARIA Usage

```html
<!-- Buttons with state -->
<button
  aria-label="Close dialog"
  aria-expanded="false"
  aria-controls="dialog-content">
  <span aria-hidden="true">×</span>
</button>

<!-- Navigation with labels -->
<nav aria-label="Main navigation">
  <ul role="list">
    <li role="listitem">
      <a href="/" aria-current="page">Home</a>
    </li>
  </ul>
</nav>

<!-- Form fields with descriptions -->
<label for="email">Email Address</label>
<input
  type="email"
  id="email"
  name="email"
  aria-required="true"
  aria-describedby="email-hint"
  aria-invalid="false">
<div id="email-hint">We'll never share your email address.</div>

<!-- Error states -->
<input
  type="email"
  id="email-error"
  name="email"
  aria-required="true"
  aria-describedby="email-error-message"
  aria-invalid="true">
<div id="email-error-message" role="alert">
  Please enter a valid email address.
</div>
```

### Live Regions

```html
<!-- Status updates -->
<div aria-live="polite" aria-atomic="true" id="status-message"></div>

<!-- Urgent announcements -->
<div aria-live="assertive" aria-atomic="true" id="alert-message"></div>

<!-- Loading states -->
<div aria-live="polite" aria-busy="true">
  Loading content...
</div>
```

## Color and Contrast Standards

### Contrast Requirements

- **Normal text**: Minimum 4.5:1 contrast ratio
- **Large text** (18pt+ or 14pt+ bold): Minimum 3:1 contrast ratio
- **UI components**: Minimum 3:1 contrast ratio for focus indicators
- **Don't rely solely on color** to convey information

### Color Implementation

```css
/* Good contrast examples */
.text-primary {
  color: #1a5490; /* 4.5:1 on white background */
  background-color: #ffffff;
}

.text-secondary {
  color: #6c757d; /* 4.5:1 on white background */
  background-color: #ffffff;
}

/* Error states - don't rely only on color */
.error {
  color: #dc3545;
  border-left: 4px solid #dc3545;
}

.error::before {
  content: "⚠ ";
  font-weight: bold;
}
```

## Images and Media Accessibility

### Image Alt Text

```html
<!-- Informative images -->
<img src="chart.png" alt="Sales increased 25% from Q1 to Q2 2024">

<!-- Decorative images -->
<img src="decoration.png" alt="" role="presentation">

<!-- Complex images -->
<img src="complex-chart.png" alt="Annual sales data" aria-describedby="chart-description">
<div id="chart-description">
  Detailed description of the chart data...
</div>

<!-- Functional images (buttons, links) -->
<a href="/search">
  <img src="search-icon.png" alt="Search">
</a>
```

### Video and Audio

```html
<!-- Video with captions and descriptions -->
<video controls>
  <source src="video.mp4" type="video/mp4">
  <track kind="captions" src="captions.vtt" srclang="en" label="English">
  <track kind="descriptions" src="descriptions.vtt" srclang="en" label="Audio descriptions">
  Your browser does not support the video tag.
</video>

<!-- Audio with transcript -->
<audio controls>
  <source src="audio.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>
<p><a href="transcript.html">Full transcript</a></p>
```

## Forms Accessibility

### Proper Form Structure

```html
<form>
  <!-- Grouped fields -->
  <fieldset>
    <legend>Contact Information</legend>

    <div class="form-group">
      <label for="first-name">First Name</label>
      <input type="text" id="first-name" name="first_name" required aria-describedby="first-name-hint">
      <div id="first-name-hint">Enter your legal first name</div>
    </div>

    <div class="form-group">
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required aria-describedby="email-hint">
      <div id="email-hint">We'll use this to send you updates</div>
    </div>
  </fieldset>

  <!-- Radio button groups -->
  <fieldset>
    <legend>Preferred Contact Method</legend>
    <div class="radio-group">
      <input type="radio" id="contact-email" name="contact_method" value="email">
      <label for="contact-email">Email</label>
    </div>
    <div class="radio-group">
      <input type="radio" id="contact-phone" name="contact_method" value="phone">
      <label for="contact-phone">Phone</label>
    </div>
  </fieldset>

  <button type="submit">Submit Form</button>
</form>
```

### Error Handling

```html
<!-- Form with errors -->
<form aria-labelledby="form-title" novalidate>
  <h2 id="form-title">Contact Form</h2>

  <!-- Error summary -->
  <div class="error-summary" role="alert" aria-labelledby="error-heading">
    <h3 id="error-heading">Please correct the following errors:</h3>
    <ul>
      <li><a href="#email">Email address is required</a></li>
      <li><a href="#phone">Phone number format is invalid</a></li>
    </ul>
  </div>

  <!-- Field with error -->
  <div class="form-group error">
    <label for="email">Email Address <span aria-label="required">*</span></label>
    <input
      type="email"
      id="email"
      name="email"
      aria-required="true"
      aria-invalid="true"
      aria-describedby="email-error">
    <div id="email-error" class="error-message" role="alert">
      Email address is required
    </div>
  </div>
</form>
```

## Drupal-Specific Accessibility

### Render Array Accessibility

```php
// Accessible button in render array
$build['button'] = [
  '#type' => 'button',
  '#value' => $this->t('Submit'),
  '#attributes' => [
    'aria-label' => $this->t('Submit search form'),
    'class' => ['btn', 'btn-primary'],
  ],
];

// Accessible link with description
$build['link'] = [
  '#type' => 'link',
  '#title' => $this->t('Read more about @title', ['@title' => $node->label()]),
  '#url' => $node->toUrl(),
  '#attributes' => [
    'aria-describedby' => 'description-' . $node->id(),
  ],
];

// Form field with accessibility attributes
$form['field_name'] = [
  '#type' => 'textfield',
  '#title' => $this->t('Field label'),
  '#required' => TRUE,
  '#description' => $this->t('Help text for the field'),
  '#attributes' => [
    'aria-describedby' => 'field-name-description',
    'aria-required' => 'true',
  ],
];
```

### Views Accessibility

```php
// In views template or preprocess
$variables['view']->setDisplay('default');
$variables['attributes']['role'] = 'region';
$variables['attributes']['aria-label'] = t('Search results');

// For pager
$variables['pager']['#attributes']['aria-label'] = t('Search result pages');

// For exposed filters
$variables['exposed']['#attributes']['role'] = 'search';
$variables['exposed']['#attributes']['aria-label'] = t('Filter search results');
```

### Menu Accessibility

```php
// In menu preprocess function
function themename_preprocess_menu(&$variables) {
  if ($variables['menu_name'] == 'main') {
    $variables['attributes']['role'] = 'navigation';
    $variables['attributes']['aria-label'] = t('Main navigation');
  }

  // Add current page indicator
  foreach ($variables['items'] as &$item) {
    if ($item['in_active_trail']) {
      $item['attributes']['aria-current'] = 'page';
    }
  }
}
```

## Testing and Validation

### Automated Testing Tools

- **axe-core**: Browser extension for accessibility testing
- **WAVE**: Web accessibility evaluation tool
- **Lighthouse**: Built into Chrome DevTools
- **Pa11y**: Command-line accessibility testing

### Manual Testing Checklist

- **Keyboard Navigation**: Tab through all interactive elements
- **Screen Reader Testing**: Test with NVDA, JAWS, or VoiceOver
- **Color Contrast**: Use tools like Colour Contrast Analyser
- **Focus Management**: Ensure focus is visible and logical
- **Form Validation**: Test error states and announcements

### Drupal Accessibility Modules

- **Accessibility**: Provides accessibility features and testing
- **Block ARIA Landmark Roles**: Adds ARIA landmarks to blocks
- **CKEditor Accessibility Checker**: Checks content for accessibility issues
- **Fluidvid**: Makes videos responsive and accessible