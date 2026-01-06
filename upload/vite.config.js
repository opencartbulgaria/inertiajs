import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
	plugins: [
		vue(),
		tailwindcss(),
	],
	build: {
		outDir: 'catalog/view/javascript/dist',
		emptyOutDir: true,
		manifest: true,
		rollupOptions: {
			input: 'catalog/view/javascript/app.js',
		},
	},
	server: {
		host: '0.0.0.0',
		port: 5173,
		strictPort: true,
		cors: true,
		origin: 'http://localhost:5173',
		hmr: {
			host: 'localhost',
			protocol: 'ws',
		},
	},
});
