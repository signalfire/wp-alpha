import { defineConfig } from 'vite';
import { resolve } from 'path';
import { fileURLToPath, URL } from 'node:url';

export default defineConfig(({ command }) => ({
  // Entry points
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        main: resolve(fileURLToPath(new URL('.', import.meta.url)), 'theme-src/main.js'),
      },
      output: {
        entryFileNames: 'assets/[name]-[hash].js',
        chunkFileNames: 'assets/[name]-[hash].js',
        assetFileNames: 'assets/[name]-[hash].[ext]',
      },
    },
  },

  // Development server
  server: {
    host: '0.0.0.0',
    port: 5173,
    cors: {
      origin: ['http://wpdemo.test', 'http://localhost', 'http://127.0.0.1'],
      credentials: true,
    },
    strictPort: true,
    hmr: {
      port: 5173,
      host: 'localhost',
      clientPort: 5173,
    },
  },

  // CSS processing
  css: {
    postcss: './postcss.config.js',
  },

  // Define global constants
  define: {
    'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'development'),
  },

  // Public base path
  base: command === 'build' ? '/wp-content/themes/signalfire-alpha/dist/' : '/',

  // Resolve aliases
  resolve: {
    alias: {
      '@': resolve(fileURLToPath(new URL('.', import.meta.url)), 'theme-src'),
    },
  },

  // File watching
  optimizeDeps: {
    include: ['tailwindcss'],
  },

  // Plugins
  plugins: [],
}));