# Signalfire WP Alpha WordPress Theme

A modern, minimal WordPress theme scaffold built with **Tailwind CSS v4** and **Vite** for lightning-fast development.

## Features

- ⚡ **Vite** for fast builds and HMR (Hot Module Replacement)
- 🎨 **Tailwind CSS v4** with JIT mode for optimal performance
- 📱 **Responsive** design with mobile-first approach
- ♿ **Accessible** markup and navigation
- 🧩 **Modular** JavaScript components with ES Modules
- 🔧 **Developer-friendly** with ESLint, Prettier, and EditorConfig
- 🚀 **Performance-focused** with optimized asset loading

## Quick Start

### Prerequisites

- Node.js 18+ and npm/yarn
- WordPress 6.0+
- PHP 8.0+

### Installation

1. **Clone or download** this theme to your WordPress themes directory:
   ```bash
   cd wp-content/themes/
   git clone [repository-url] signalfire-wp-alpha
   ```

2. **Install dependencies**:
   ```bash
   cd signalfire-wp-alpha
   npm install
   ```

3. **Start development server**:
   ```bash
   npm run dev
   ```

4. **Activate the theme** in WordPress admin dashboard

5. **Build for production**:
   ```bash
   npm run build
   ```

## Development Workflow

### Development Mode
```bash
npm run dev
```
- Starts Vite dev server on `http://localhost:5173`
- Enables HMR for instant updates
- Automatically compiles Tailwind CSS

### Production Build
```bash
npm run build
```
- Builds optimized assets to `/dist` directory
- Minifies CSS and JavaScript
- Generates manifest.json for asset versioning

### Code Quality
```bash
npm run lint    # Run ESLint
npm run format  # Run Prettier
```

## File Structure

```
signalfire-wp-alpha/
├── theme-src/           # Source files (development)
│   ├── main.js         # Main entry point
│   ├── css/
│   │   └── main.css    # Tailwind CSS entry
│   ├── js/
│   │   ├── theme.js    # Main theme JavaScript
│   │   └── modules/    # Modular components
│   └── components/     # Reusable JS components
├── dist/               # Built assets (production)
├── *.php              # WordPress template files
├── vite.config.js     # Vite configuration
├── tailwind.config.js # Tailwind configuration
└── package.json       # Dependencies and scripts
```

## Customization

### Tailwind CSS
- Edit `tailwind.config.js` to customize design tokens
- Add custom components in `theme-src/css/main.css`
- Use `@layer` directives for proper CSS organization

### JavaScript
- Add new modules in `theme-src/js/modules/`
- Import modules in `theme-src/js/theme.js`
- Use ES6+ features and modules

### WordPress Features
- Navigation menus
- Widget areas
- Custom logo support
- Post thumbnails
- Translation ready

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- ES2022+ features
- CSS Grid and Flexbox

## Performance

- Critical CSS inlined automatically
- JavaScript modules loaded efficiently
- Optimized asset caching with versioning
- Lazy loading for images

## Contributing

1. Follow WordPress coding standards
2. Use ESLint and Prettier for code formatting
3. Test across different browsers and devices
4. Ensure accessibility standards are met

## License

GPL v2 or later