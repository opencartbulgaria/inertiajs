<?php
namespace Opencart\System\Library\Inertia;

class SharedProvider
{
	private $registry;
	private $header_data = null;

	public function __construct($registry)
	{
		$this->registry = $registry;
		$this->loadHeaderData();
	}

	/**
	 * Load header data from OpenCart header controller
	 */
	private function loadHeaderData(): void
	{
		try {
			$loader = $this->registry->get('load');
			$this->header_data = $loader->controller('common/header');
		} catch (\Exception $e) {
			error_log('Failed to load header data: ' . $e->getMessage());
			$this->header_data = [];
		}
	}

	/**
	 * Get all shared data
	 */
	public function getData(): array
	{
		return [
			// From header controller
			'store_name' => $this->header_data['name'] ?? $this->getStoreName(),
			'logo' => $this->header_data['logo'] ?? '',
			'icon' => $this->header_data['icon'] ?? '',

			// Cart & Wishlist
			'cart_count' => $this->getCartCount(),
			'wishlist_count' => $this->getWishlistCount(),

			// Navigation
			'categories' => $this->getMenuCategories(),

			// Languages & Currency
			'languages' => $this->getLanguages(),
			'current_language' => $this->getCurrentLanguage(),
			'currency' => $this->getCurrency(),
			'language' => $this->getLanguageInfo(),

			// User
			'user' => $this->getUserInfo(),
			'urls' => $this->getUrls(),
		];
	}

	/**
	 * Get store name
	 */
	private function getStoreName(): string
	{
		return $this->registry->get('config')->get('config_name');
	}

	/**
	 * Get cart count
	 */
	private function getCartCount(): int
	{
		if (!$this->registry->has('cart')) {
			return 0;
		}

		$cart = $this->registry->get('cart');

		if ($cart && method_exists($cart, 'countProducts')) {
			return $cart->countProducts();
		}

		return 0;
	}

	/**
	 * Get wishlist count from header data
	 */
	private function getWishlistCount(): int
	{
		if (isset($this->header_data['text_wishlist'])) {
			// Extract number from "Wishlist (5)" format
			preg_match('/\((\d+)\)/', $this->header_data['text_wishlist'], $matches);
			if (isset($matches[1])) {
				return (int)$matches[1];
			}
		}

		return 0;
	}

	/**
	 * Get menu categories from OpenCart menu controller
	 */
	private function getMenuCategories(): array
	{
		try {
			$loader = $this->registry->get('load');
			$menu_data = $loader->controller('common/menu');

			// Parse menu data to extract categories
			if (isset($menu_data['categories'])) {
				$categories = [];

				foreach ($menu_data['categories'] as $category) {
					$categories[] = [
						'id' => $category['category_id'] ?? 0,
						'name' => $category['name'] ?? '',
						'href' => $category['href'] ?? '#',
						'active' => false,
					];
				}

				return array_slice($categories, 0, 6);
			}
		} catch (\Exception $e) {
			error_log('Failed to load menu: ' . $e->getMessage());
		}

		return [];
	}

	/**
	 * Get available languages from header
	 */
	private function getLanguages(): array
	{
		$languages = [];

		try {
			$loader = $this->registry->get('load');
			$language_data = $loader->controller('common/language');

			if (isset($language_data['languages'])) {
				$current_language = $this->getCurrentLanguage();

				foreach ($language_data['languages'] as $lang) {
					$languages[] = [
						'code' => $lang['code'] ?? '',
						'name' => $lang['name'] ?? '',
						'image' => $lang['image'] ?? '',
						'active' => ($lang['code'] ?? '') === $current_language,
					];
				}
			}
		} catch (\Exception $e) {
			error_log('Failed to load languages: ' . $e->getMessage());
		}

		return $languages;
	}

	/**
	 * Get current language code
	 */
	private function getCurrentLanguage(): string
	{
		return $this->registry->get('config')->get('config_language');
	}

	/**
	 * Get currency info
	 */
	private function getCurrency(): array
	{
		$session = $this->registry->get('session');

		return [
			'code' => $session->data['currency'] ?? 'BGN',
		];
	}

	/**
	 * Get language info
	 */
	private function getLanguageInfo(): array
	{
		return [
			'code' => $this->getCurrentLanguage(),
			'direction' => $this->header_data['direction'] ?? 'ltr',
		];
	}

	/**
	 * Get user info from header
	 */
	private function getUserInfo(): array
	{
		$logged = $this->header_data['logged'] ?? false;

		if (!$logged) {
			return [
				'logged' => false,
			];
		}

		// Get customer info if logged
		if ($this->registry->has('customer')) {
			$customer = $this->registry->get('customer');

			if ($customer && $customer->isLogged()) {
				return [
					'logged' => true,
					'name' => $customer->getFirstName() . ' ' . $customer->getLastName(),
					'email' => $customer->getEmail(),
				];
			}
		}

		return [
			'logged' => false,
		];
	}

	/**
	 * Get URLs from header
	 */
	private function getUrls(): array
	{
		return [
			'home' => $this->header_data['home'] ?? '/',
			'cart' => $this->header_data['shopping_cart'] ?? '/index.php?route=checkout/cart',
			'checkout' => $this->header_data['checkout'] ?? '/index.php?route=checkout/checkout',
			'search' => '/index.php?route=product/search',
			'contact' => $this->header_data['contact'] ?? '/index.php?route=information/contact',
			'wishlist' => $this->header_data['wishlist'] ?? '/index.php?route=account/wishlist',
			'login' => $this->header_data['login'] ?? '/index.php?route=account/login',
			'register' => $this->header_data['register'] ?? '/index.php?route=account/register',
			'account' => $this->header_data['account'] ?? '/index.php?route=account/account',
			'orders' => $this->header_data['order'] ?? '/index.php?route=account/order',
			'logout' => $this->header_data['logout'] ?? '/index.php?route=account/logout',
		];
	}
}
