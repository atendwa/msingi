import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js', 'resources/css/**/theme.css'],
                refresh: [
                    ...refreshPaths,
                    'app/Filament/**',
                    'app/Forms/Components/**',
                    'app/Livewire/**',
                    'app/Livewire/**/*.php',
                    'app/Infolists/Components/**',
                    'app/Providers/Filament/**',
                    'app/Tables/Columns/**'
                ]
            })
        ],
        server: {
            open: env.APP_URL || 'http://localhost:8000',
            watch: {
                ignored: ['**/node_modules/**', '**/vendor/**']
            },
            ignored: [
                '**/node_modules/**',
                '**/vendor/**'
            ]
        },
        build: {
            minify: true,
            rollupOptions: {
                output: {
                    manualChunks: (path) => {
                        if (path.includes('node_modules')) {
                            return 'vendor';
                        }
                    }
                }
            }
        }
    };
});
