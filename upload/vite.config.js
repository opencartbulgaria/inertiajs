import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
	plugins: [
		vue(),
		tailwindcss(),
	],
	resolve: {
		alias: {
			'@': '/catalog/view/javascript',
		},
	},
	build: {
		outDir: 'catalog/view/javascript/dist',
		emptyOutDir: true,
		manifest: true,
		rollupOptions: {
			input: 'catalog/view/javascript/app.js',
		},
	},
	server: {
		host: true,
		port: 5173,
		strictPort: true,
		cors: {
			origin: '*',
			credentials: true,
		},
		hmr: {
			host: '127.0.0.1',
			clientPort: 5173,
		},
		watch: {
			usePolling: true,
		},
	},
});
