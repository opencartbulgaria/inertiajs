<?php
/**
 * @package        OpenCart Bulgaria
 *
 * @author         Pavel Palashturov
 * @copyright      Copyright (c) 2020 - 2026, OpenCart Bulgaria, Ltd. (https://opencartbulgaria.com/)
 * @license        https://opensource.org/licenses/GPL-3.0
 *
 * @see           https://opencartbulgaria.com
 */

namespace Opencart\System\Library;

use Opencart\System\Engine\Registry;

class Inertia
{
	/**
	 * @var Registry
	 */
	private Registry $registry;
	/**
	 * @var array
	 */
	private array $shared_data = [];

	/**
	 * Constructor
	 */
	public function __construct(Registry $registry)
	{
		$this->registry = $registry;
	}

	/**
	 * Share data across all Inertia responses
	 */
	public function share($key, $value = null): static
	{
		if (is_array($key)) {
			$this->shared_data = array_merge($this->shared_data, $key);
		} else {
			$this->shared_data[$key] = $value;
		}
		return $this;
	}

	/**
	 * Render an Inertia response
	 */
	public function render($component, $props = []): bool|string
	{
		// Merge shared data with props
		$all_props = array_merge($this->shared_data, $props);

		// Create page object
		$page = [
			'component' => $component,
			'props'     => $all_props,
			'url'       => $this->getCurrentUrl(),
			'version'   => $this->getVersion()
		];

		// Check if this is an Inertia request
		if ($this->isInertiaRequest()) {
			return $this->sendInertiaResponse($page);
		}

		// First load - send HTML with embedded page data
		return $this->sendHtmlResponse($page);
	}

	/**
	 * Check if current request is an Inertia request
	 */
	private function isInertiaRequest(): bool
	{
		return isset($this->registry->get('request')->server['HTTP_X_INERTIA']) &&
			$this->registry->get('request')->server['HTTP_X_INERTIA'] === 'true';
	}

	/**
	 * Send JSON response for Inertia requests
	 */
	private function sendInertiaResponse($page): bool|string
	{
		header('Content-Type: application/json');
		header('X-Inertia: true');
		header('Vary: X-Inertia');

		return json_encode($page);
	}

	/**
	 * Send HTML response for initial page load
	 */
	private function sendHtmlResponse($page)
	{
		// Add metadata to the data array (not to page props)
		$data = [
			'page'             => $page,
			'page_json'        => htmlspecialchars(json_encode($page), ENT_QUOTES, 'UTF-8'),
			'vite_assets'      => $this->getViteAssets(),
			'language'         => $page['props']['language'] ?? ['code' => 'bg', 'direction' => 'ltr'],
			'meta_title'       => $page['props']['meta_title'] ?? '',
			'meta_description' => $page['props']['meta_description'] ?? '',
			'meta_keywords'    => $page['props']['meta_keywords'] ?? '',
		];

		// Load Twig template
		try {
			$loader = $this->registry->get('load');
			return $loader->view('app', $data);
		} catch (\Exception $e) {
			return $this->getFallbackHtml($page);
		}
	}

	/**
	 * Fallback HTML if Twig template is not available
	 */
	private function getFallbackHtml($page): string
	{
		$page_json   = htmlspecialchars(json_encode($page), ENT_QUOTES, 'UTF-8');
		$meta_title  = htmlspecialchars($page['props']['meta_title'] ?? 'OpenCart');
		$vite_assets = $this->getViteAssets();

		return '<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . $meta_title . '</title>
    ' . $vite_assets . '
</head>
<body>
    <div id="app" data-page="' . $page_json . '"></div>
</body>
</html>';
	}

	/**
	 * Get current URL
	 */
	private function getCurrentUrl()
	{
		$request = $this->registry->get('request');
		return $request->server['REQUEST_URI'] ?? '/';
	}

	/**
	 * Get app version for cache busting
	 */
	private function getVersion(): string
	{
		return '1.0.0';
	}

	private function getViteAssets(): string
	{
		$manifest_path = DIR_APPLICATION . 'view/javascript/dist/.vite/manifest.json';

		// If Vite dev server is running, prefer dev assets (even if a manifest exists)
		if ($this->isViteDevServerRunning()) {
			// Development mode - use Vite dev server
			$vite_host = 'http://127.0.0.1:5173';

			return '<script type="module" crossorigin src="' . $vite_host . '/@vite/client"></script>
    <script type="module" crossorigin src="' . $vite_host . '/catalog/view/javascript/app.js"></script>';
		}

		// Otherwise, use production build if present
		if (file_exists($manifest_path)) {
			return $this->getProductionAssets();
		}

		// No dev server and no build
		return '<!-- ERROR: No Vite dev server and no build manifest. Run: npm run dev or npm run build -->';
	}


	/**
	 * Check if Vite dev server is running
	 */
	/**
	 * Check if Vite dev server is running
	 */
	private function isViteDevServerRunning(): bool
	{
		$errno = 0;
		$error = '';

		// Some environments (incl. OpenCart) may have a custom error handler that still
		// surfaces warnings even when using @. Temporarily swallow warnings for this probe.
		$prevHandler = set_error_handler(function () {
			return true;
		});

		try {
			$socket = fsockopen('127.0.0.1', 5173, $errno, $error, 0.2);
		} finally {
			restore_error_handler();
			// If there was a previous handler, restore_error_handler() already restored it.
			// $prevHandler is kept only to avoid unused-variable notices in older setups.
			unset($prevHandler);
		}

		if (is_resource($socket)) {
			fclose($socket);
			return true;
		}

		return false;
	}

	/**
	 * Get production asset tags
	 */
	private function getProductionAssets(): string
	{
		$manifest_path = DIR_APPLICATION . 'view/javascript/dist/.vite/manifest.json';

		$manifest = json_decode(file_get_contents($manifest_path), true);

		if (!$manifest || !isset($manifest['catalog/view/javascript/app.js'])) {
			return '<!-- ERROR: Invalid manifest file. Please run: npm run build -->';
		}

		$entry = $manifest['catalog/view/javascript/app.js'];
		$html  = '';

		// Add CSS files
		if (isset($entry['css'])) {
			foreach ($entry['css'] as $css) {
				$html .= '<link rel="stylesheet" href="/catalog/view/javascript/dist/' . $css . '">' . "\n    ";
			}
		}

		// Add JS file
		if (isset($entry['file'])) {
			$html .= '<script type="module" src="/catalog/view/javascript/dist/' . $entry['file'] . '"></script>';
		}

		return $html;
	}
}
