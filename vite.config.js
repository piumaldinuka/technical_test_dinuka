import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base: '/dist/',
    publicDir: 'public',
    css: {
        postcss: {
            plugins: [
                tailwindcss('./tailwind.config.js'),
            ],
        },
    },  
  
  server: {
    proxy: {
      '/api': {
        target: 'http://127.0.0.1:8000',
        changeOrigin: true,
        secure: false,
      },
    },
  },
       plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue()
    ],
    build: {
        outDir: 'dist',
        sourcemap: true,
    },
    optimizeDeps: {
        include: ['axios'],
    },
    resolve: {
        alias: {
            '@': '/src',
        },
    },
});
