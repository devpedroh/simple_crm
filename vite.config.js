import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue2';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'], // Certifique-se de que está correto
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
    server: {
        host: '0.0.0.0', // Permite acessar de outros dispositivos
        port: 5173, // Porta padrão do Vite
        strictPort: true,
        hmr: {
            host: 'localhost', // Troque pelo IP do seu servidor se estiver rodando remotamente
        },
    },
});
