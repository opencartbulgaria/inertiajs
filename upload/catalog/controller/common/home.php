<?php
namespace Opencart\Catalog\Controller\Common;
/**
 * Class Home
 *
 * Can be called from $this->load->controller('common/home');
 *
 * @package Opencart\Catalog\Controller\Common
 */
class Home extends \Opencart\System\Engine\Controller {
	/**
	 * Index
	 *
	 * @return void
	 */
	public function index(): void {
		$this->load->language('common/home');

		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		// Зареждане на products модел
		$this->load->model('catalog/product');

		// Вземане на продукти
		$filter_data = [
			'start' => 0,
			'limit' => 6
		];

		$products = [];
		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			$products[] = [
				'product_id' => $result['product_id'],
				'name' => $result['name'],
				'price' => $this->currency->format($result['price'], $this->session->data['currency'])
			];
		}

		// Inertia render
		$data = [
			'store_name' => $this->config->get('config_name'),
			'product_count' => count($products),
			'products' => $products
		];

		$output = $this->inertia->render('Home/Index', $data);

		$this->response->setOutput($output);
	}
}
