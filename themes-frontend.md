# Theme and Frontend Development Guidelines

## Drupal Theming Standards

### Core Principles
- Use Twig templates, never PHP in templates
- Preprocess functions should be in `.theme` file
- Follow naming: `themename_preprocess_Hname: 'Yale Health Theme'
type: theme
base theme: classy
core_version_requirement: ^10
description: 'Custom theme for Yale Health site'$variables)`
- Use render arrays, not HTML strings

### Template Organization
- Store templates in the `templates/` directory
- Use proper Twig template naming conventions
- Implement template suggestions for customization
- Use semantic HTML5 elements

## CSS and SCSS Guidelines

### Methodology and Standards
- Use BEM methodology for class naming
- Use CSS custom properties for theming
- Organize by component
- Use modern CSS (Grid, Flexbox)
- Follow mobile-first responsive design

### SCSS Best Practices

```scss
// Use modern Sass API to avoid deprecation warnings
// vite.config.ts configuration:
export default defineConfig({
  css: {
    preprocessorOptions: {
      scss: {
        api: 'modern-compiler',
      },
    },
  },
});
```

### CSS Architecture

```scss
// Component-based organization
.component {
  // Base styles

  &__element {
    // Element styles
  }

  &--modifier {
    // Modifier styles
  }
}

// Use CSS custom properties for theming
:root {
  --primary-color: #1a5490;
  --secondary-color: #f8f9fa;
  --text-color: #333;
}
```

## JavaScript Development

### Modern JavaScript Standards
- Use modern ES6+ syntax
- Add `type: module` in libraries for ES6 modules
- Use Drupal behaviors: `Drupal.behaviors.moduleName`
- Avoid jQuery when possible, use vanilla JS

### Drupal JavaScript Patterns

```javascript
// Proper Drupal behavior implementation
(function (Drupal) {
  'use strict';

  /**
   * Behavior for custom functionality.
   */
  Drupal.behaviors.yalehealthCustomBehavior = {
    attach: function (context, settings) {
      // Use context to scope the behavior
      const elements = context.querySelectorAll('.custom-selector');

      elements.forEach(element => {
        // Modern JavaScript implementation
        if (!element.classList.contains('processed')) {
          element.classList.add('processed');
          // Add functionality here
        }
      });
    }
  };

})(Drupal);
```

### Library Definition

```yaml
# modulename.libraries.yml
custom-behavior:
  js:
    js/custom-behavior.js: {}
  dependencies:
    - core/drupal
    - core/once
```

## Build Tools Configuration

### Vite Configuration

```typescript
// vite.config.ts for modern build process
import { defineConfig } from 'vite';

export default defineConfig({
  css: {
    preprocessorOptions: {
      scss: {
        api: 'modern-compiler', // Avoid legacy JS API warnings
      },
    },
  },
  build: {
    outDir: 'dist',
    rollupOptions: {
      input: {
        main: 'src/main.scss',
        admin: 'src/admin.scss',
      },
    },
  },
});
```

### Webpack 5 Configuration

```typescript
// Use modern webpack 5 asset modules
export default {
  module: {
    rules: [
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        type: 'asset/resource', // Replace file-loader
        generator: {
          filename: 'images/[name].[hash][ext]',
        },
      },
    ],
  },
};
```

### Image Optimization

```typescript
// webpack.config.ts - Avoid fs.Stats deprecation
export const imageConfig = {
  test: /\.(gif|png|jpe?g|svg)$/i,
  type: 'asset/resource',
  use: [
    {
      loader: 'image-webpack-loader',
      options: {
        mozjpeg: {
          progressive: true,
          quality: 65,
        },
        optipng: {
          enabled: false,
        },
        pngquant: {
          quality: [0.65, 0.90],
          speed: 4,
        },
        gifsicle: {
          interlaced: false,
        },
        webp: {
          quality: 75,
        },
      },
    },
  ],
};
```

## Theme Library Management

### Library Definition Best Practices

```yaml
# theme_name.libraries.yml
global:
  css:
    theme:
      dist/css/main.css: {}
  js:
    dist/js/main.js: {}
  dependencies:
    - core/normalize
    - core/drupal

admin:
  css:
    theme:
      dist/css/admin.css: {}
  dependencies:
    - gin/gin

component-library:
  css:
    component:
      dist/css/components.css: {}
  js:
    dist/js/components.js: { type: module }
```

### Theme Configuration

```yaml
# theme_name.info.yml
name: 'NJ211 Theme'
type: theme
core_version_requirement: ^10 || ^11
base theme: gin
description: 'Custom theme for NJ211 site'

libraries:
  - theme_name/global

regions:
  header: Header
  primary_menu: 'Primary menu'
  secondary_menu: 'Secondary menu'
  content: Content
  sidebar_first: 'Left sidebar'
  sidebar_second: 'Right sidebar'
  footer: Footer
```

## Performance Optimization

### Asset Optimization
- Minimize and compress CSS/JS files
- Use image optimization tools
- Implement lazy loading for images
- Use critical CSS for above-the-fold content

### Caching Strategies
- Use cache tags for automatic invalidation
- Cache rendered output when possible
- Use lazy builders for dynamic content
- Implement proper browser caching headers

### Code Splitting

```javascript
// Dynamic imports for code splitting
const loadModule = async () => {
  const module = await import('./heavy-module.js');
  return module.default;
};

// Use with Drupal behaviors
Drupal.behaviors.lazyLoader = {
  attach: function (context) {
    const triggers = context.querySelectorAll('.lazy-load-trigger');

    triggers.forEach(trigger => {
      trigger.addEventListener('click', async () => {
        const module = await loadModule();
        module.initialize();
      });
    });
  }
};
```

## Responsive Design

### Breakpoint Management

```scss
// Define consistent breakpoints
$breakpoints: (
  'mobile': 320px,
  'tablet': 768px,
  'desktop': 1024px,
  'wide': 1200px,
);

@mixin respond-to($breakpoint) {
  @if map-has-key($breakpoints, $breakpoint) {
    @media (min-width: map-get($breakpoints, $breakpoint)) {
      @content;
    }
  }
}

// Usage
.component {
  padding: 1rem;

  @include respond-to('tablet') {
    padding: 2rem;
  }

  @include respond-to('desktop') {
    padding: 3rem;
  }
}
```

### Flexible Layouts

```scss
// Modern CSS Grid layouts
.layout-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;

  @supports (display: grid) {
    // Enhanced styles for grid-supporting browsers
  }
}

// Flexbox fallbacks
.layout-flex {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;

  > * {
    flex: 1 1 300px;
  }
}
```

## Theme Testing and Quality

### Code Quality
- Run SCSS linting with stylelint
- Use Prettier for consistent formatting
- Implement CSS and JS minification
- Test across different browsers and devices

### Performance Testing
- Monitor bundle sizes
- Test page load speeds
- Optimize images and assets
- Use browser dev tools for profiling

### Accessibility Testing
- Test keyboard navigation
- Verify color contrast ratios
- Check screen reader compatibility
- Validate semantic HTML structure