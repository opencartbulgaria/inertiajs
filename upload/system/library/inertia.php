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
	private array    $shared_data = [];

	/**
	 * Constructor
	 */
	public function __construct(Registry $registry)
	{
		$this->registry = $registry;
	}

	/**
	 *
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
	 *
	 */
	public function render($component, $props = [])
	{
		$all_props = array_merge($this->shared_data, $props);

		$page = [
			'component' => $component,
			'props'     => $all_props,
			'url'       => $this->registry->get('request')->server['REQUEST_URI'] ?? '/',
			'version'   => '1.0'
		];

		// Проверка дали е Inertia заявка
		$is_inertia = isset($this->registry->get('request')->server['HTTP_X_INERTIA']);

		if ($is_inertia) {
			header('Content-Type: application/json');
			header('X-Inertia: true');
			echo json_encode($page);
			exit;
		}

		// Първоначално зареждане - HTML layout
		return $this->renderHtml($page);
	}

	/**
	 * Render HTML layout
	 */
	private function renderHtml($page): string
	{
		return '<!DOCTYPE html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OpenCart</title>
    ' . $this->getViteAssets() . '
</head>
<body>
    <div id="app" data-page="' . htmlspecialchars(json_encode($page)) . '"></div>
</body>
</html>';
	}

	/**
	 *
	 */
	private function getViteAssets(): string
	{
		// За development
		if (file_exists(DIR_APPLICATION . '../vite.config.js') &&
			!file_exists(DIR_APPLICATION . 'view/javascript/dist/manifest.json')) {
			return '<script type="module" src="http://localhost:5173/@vite/client"></script>
                    <script type="module" src="http://localhost:5173/catalog/view/javascript/app.js"></script>';
		}

		// За production
		$manifest_path = DIR_APPLICATION . 'view/javascript/dist/manifest.json';
		if (file_exists($manifest_path)) {
			$manifest = json_decode(file_get_contents($manifest_path), true);

			$js_file   = $manifest['catalog/view/javascript/app.js']['file'] ?? '';
			$css_files = $manifest['catalog/view/javascript/app.js']['css'] ?? [];

			$html = '';
			foreach ($css_files as $css) {
				$html .= '<link rel="stylesheet" href="/catalog/view/javascript/dist/' . $css . '">';
			}
			$html .= '<script type="module" src="/catalog/view/javascript/dist/' . $js_file . '"></script>';

			return $html;
		}

		return '';
	}
}
