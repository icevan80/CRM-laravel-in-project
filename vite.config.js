import {defineConfig} from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/background.css',
                'resources/css/paddings-margins.css',
                'resources/css/text.css',
                'resources/css/border.css',
                'resources/css/ring.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
    resolve: {
        alias: {
            '~font' : path.resolve(__dirname,'resources/fonts')
        }
    }
});
