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
	public function share($key, $value = null)
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
	public function render($component, $props = [])
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
	private function isInertiaRequest()
	{
		return isset($this->registry->get('request')->server['HTTP_X_INERTIA']) &&
			$this->registry->get('request')->server['HTTP_X_INERTIA'] === 'true';
	}

	/**
	 * Send JSON response for Inertia requests
	 */
	private function sendInertiaResponse($page)
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
		$html = '<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>' . htmlspecialchars($page['props']['store_name'] ?? 'OpenCart') . '</title>
    ' . $this->getViteAssets() . '
</head>
<body>
    <div id="app" data-page="' . htmlspecialchars(json_encode($page), ENT_QUOTES, 'UTF-8') . '"></div>
</body>
</html>';

		return $html;
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
	private function getVersion()
	{
		return '1.0.0';
	}

	/**
	 * Get Vite assets (dev or production)
	 */
	private function getViteAssets()
	{
		$is_dev = $this->isDevelopment();

		if ($is_dev) {
			// Development - use Vite dev server
			return '
    <script type="module" src="http://localhost:5173/@vite/client"></script>
    <script type="module" src="http://localhost:5173/catalog/view/javascript/app.js"></script>';
		}

		// Production - use built assets
		return $this->getProductionAssets();
	}

	/**
	 * Check if we're in development mode
	 */
	private function isDevelopment()
	{
		// Check if Vite dev server is running by looking for manifest
		$manifest_path = DIR_APPLICATION . 'view/javascript/dist/.vite/manifest.json';

		// If manifest doesn't exist, assume dev mode
		return !file_exists($manifest_path);
	}

	/**
	 * Get production asset tags
	 */
	private function getProductionAssets()
	{
		$manifest_path = DIR_APPLICATION . 'view/javascript/dist/.vite/manifest.json';

		if (!file_exists($manifest_path)) {
			return '<!-- Production assets not built. Run: npm run build -->';
		}

		$manifest = json_decode(file_get_contents($manifest_path), true);

		if (!$manifest || !isset($manifest['catalog/view/javascript/app.js'])) {
			return '<!-- Invalid manifest file -->';
		}

		$entry = $manifest['catalog/view/javascript/app.js'];

		$html = '';

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
