<?php

namespace Opencart\Catalog\Controller\Common;
/**
 * Class Home
 *
 * Can be called from $this->load->controller('common/home');
 *
 * @package Opencart\Catalog\Controller\Common
 */
class Home extends \Opencart\System\Engine\Controller
{
	/**
	 * Index
	 *
	 * @return void
	 */
	public function index(): void
	{

		// Load language
		$this->load->language('common/home');

		$description = $this->config->get('config_description');
		$language_id = $this->config->get('config_language_id');

		$data['language'] = ['code' => $this->config->get('config_language_catalog'), 'direction' => 'ltr'];

		if (isset($description[$language_id])) {
			$data['meta_title']       = $description[$language_id]['meta_title'];
			$data['meta_description'] = $description[$language_id]['meta_description'];
			$data['meta_keyword']     = $description[$language_id]['meta_keyword'];
		}

		$data['header'] = $this->load->controller('common/header');

//		$data['column_left']    = $this->load->controller('common/column_left');
//		$data['column_right']   = $this->load->controller('common/column_right');
//		$data['content_top']    = $this->load->controller('common/content_top');
//		$data['content_bottom'] = $this->load->controller('common/content_bottom');
//		$data['footer']         = $this->load->controller('common/footer');

		// Render with Inertia
		$output = $this->inertia->render('Home/Index', $data);

		$this->response->setOutput($output);
	}
}
