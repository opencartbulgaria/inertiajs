<template>
	<div class="min-h-screen flex flex-col bg-gray-50">
		<!-- Header -->
		<header class="bg-white shadow-sm sticky top-0 z-50">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between items-center h-16">
					<!-- Logo -->
					<div class="flex items-center space-x-8">
						<Link :href="safeUrls.home" class="flex items-center">
							<img
								v-if="logo"
								:src="logo"
								:alt="storeName"
								class="h-10 w-auto"
							/>
							<span v-else class="text-2xl font-bold text-gray-900 hover:text-blue-600 transition">
                {{ storeName }}
              </span>
						</Link>
					</div>

					<!-- Search Bar - Desktop -->
					<div class="hidden md:flex flex-1 max-w-2xl mx-8">
						<form @submit.prevent="handleSearch" class="w-full">
							<div class="relative">
								<input
									v-model="searchQuery"
									type="text"
									placeholder="Търсене на продукти..."
									class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
								/>
								<button
									type="submit"
									class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-blue-600 transition"
								>
									<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
									</svg>
								</button>
							</div>
						</form>
					</div>

					<!-- Nav Icons -->
					<div class="flex items-center space-x-2">
						<!-- Language Switcher -->
						<LanguageSwitcher
							v-if="languages && languages.length > 1"
							:languages="languages"
							:current-language-code="currentLanguage"
						/>

						<!-- Account Dropdown -->
						<div class="relative" ref="accountDropdown">
							<button
								@click="isAccountOpen = !isAccountOpen"
								class="p-2 text-gray-600 hover:text-gray-900 relative rounded-lg hover:bg-gray-100 transition"
							>
								<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
								</svg>
							</button>

							<!-- Account Dropdown Menu -->
							<transition
								enter-active-class="transition duration-200 ease-out"
								enter-from-class="opacity-0 translate-y-1"
								enter-to-class="opacity-100 translate-y-0"
								leave-active-class="transition duration-150 ease-in"
								leave-from-class="opacity-100 translate-y-0"
								leave-to-class="opacity-0 translate-y-1"
							>
								<div
									v-if="isAccountOpen"
									class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50"
								>
									<template v-if="user.logged">
										<div class="px-4 py-2 border-b border-gray-200">
											<p class="text-sm font-semibold text-gray-900">{{ user.name }}</p>
											<p class="text-xs text-gray-500">{{ user.email }}</p>
										</div>
										<Link :href="safeUrls.account" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
											Моят акаунт
										</Link>
										<Link :href="safeUrls.orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
											Моите поръчки
										</Link>
										<Link :href="safeUrls.logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50 border-t border-gray-200">
											Изход
										</Link>
									</template>
									<template v-else>
										<Link :href="safeUrls.login" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
											Вход
										</Link>
										<Link :href="safeUrls.register" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
											Регистрация
										</Link>
									</template>
								</div>
							</transition>
						</div>

						<!-- Wishlist -->
						<Link :href="safeUrls.wishlist" class="p-2 text-gray-600 hover:text-gray-900 relative rounded-lg hover:bg-gray-100 transition">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
							</svg>
							<span v-if="wishlistCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                {{ wishlistCount }}
              </span>
						</Link>

						<!-- Cart -->
						<Link :href="safeUrls.cart" class="p-2 text-gray-600 hover:text-gray-900 relative rounded-lg hover:bg-gray-100 transition">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
							</svg>
							<span v-if="cartCount > 0" class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                {{ cartCount }}
              </span>
						</Link>
					</div>
				</div>

				<!-- Mobile Search -->
				<div class="md:hidden pb-3">
					<form @submit.prevent="handleSearch">
						<div class="relative">
							<input
								v-model="searchQuery"
								type="text"
								placeholder="Търсене..."
								class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
							/>
							<button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2">
								<svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
								</svg>
							</button>
						</div>
					</form>
				</div>
			</div>
		</header>

		<!-- Navigation -->
		<nav class="bg-white border-b">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex space-x-8 h-12 items-center overflow-x-auto">
					<Link
						v-for="category in categories"
						:key="category.id"
						:href="category.href"
						class="text-gray-700 hover:text-blue-600 whitespace-nowrap transition font-medium"
						:class="{ 'text-blue-600': category.active }"
					>
						{{ category.name }}
					</Link>
				</div>
			</div>
		</nav>

		<!-- Main Content -->
		<main class="flex-1">
			<slot />
		</main>

		<!-- Footer -->
		<footer class="bg-gray-900 text-gray-300 mt-12">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
				<div class="grid grid-cols-1 md:grid-cols-4 gap-8">
					<!-- About -->
					<div>
						<h3 class="text-white text-lg font-semibold mb-4">{{ storeName }}</h3>
						<p class="text-sm text-gray-400">
							Вашият надежден онлайн магазин за електроника и технология.
						</p>
					</div>

					<!-- Quick Links -->
					<div>
						<h3 class="text-white text-lg font-semibold mb-4">Бързи връзки</h3>
						<ul class="space-y-2 text-sm">
							<li><a href="#" class="hover:text-white">За нас</a></li>
							<li><Link :href="safeUrls.contact" class="hover:text-white">Контакти</Link></li>
							<li><a href="#" class="hover:text-white">Доставка</a></li>
							<li><a href="#" class="hover:text-white">Връщане</a></li>
						</ul>
					</div>

					<!-- Customer Service -->
					<div>
						<h3 class="text-white text-lg font-semibold mb-4">Обслужване</h3>
						<ul class="space-y-2 text-sm">
							<li><Link :href="safeUrls.account" class="hover:text-white">Моят акаунт</Link></li>
							<li><Link :href="safeUrls.orders" class="hover:text-white" v-if="user.logged">История на поръчки</Link></li>
							<li><Link :href="safeUrls.wishlist" class="hover:text-white">Списък желания</Link></li>
						</ul>
					</div>

					<!-- Newsletter -->
					<div>
						<h3 class="text-white text-lg font-semibold mb-4">Бюлетин</h3>
						<p class="text-sm text-gray-400 mb-4">
							Абонирайте се за нашия бюлетин и получавайте специални оферти.
						</p>
						<form @submit.prevent="handleNewsletter" class="flex">
							<input
								v-model="newsletterEmail"
								type="email"
								placeholder="Вашият email"
								class="flex-1 px-4 py-2 rounded-l-lg text-gray-900 focus:outline-none"
								required
							/>
							<button type="submit" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-r-lg text-white transition">
								Абонирай
							</button>
						</form>
					</div>
				</div>

				<div class="border-t border-gray-800 mt-8 pt-8 text-sm text-center text-gray-400">
					<p>&copy; 2026 {{ storeName }}. Всички права запазени.</p>
				</div>
			</div>
		</footer>
	</div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import LanguageSwitcher from '../Components/LanguageSwitcher.vue';

const props = defineProps({
	storeName: {
		type: String,
		default: 'OpenCart'
	},
	logo: {
		type: String,
		default: ''
	},
	cartCount: {
		type: Number,
		default: 0
	},
	wishlistCount: {
		type: Number,
		default: 0
	},
	categories: {
		type: Array,
		default: () => []
	},
	languages: {
		type: Array,
		default: () => []
	},
	currentLanguage: {
		type: String,
		default: 'bg'
	},
	user: {
		type: Object,
		default: () => ({ logged: false })
	},
	safeUrls: {
		type: Object,
		default: () => ({
			home: '/',
			cart: '/index.php?route=checkout/cart',
			checkout: '/index.php?route=checkout/checkout',
			search: '/index.php?route=product/search',
			contact: '/index.php?route=information/contact',
			login: '/index.php?route=account/login',
			register: '/index.php?route=account/register',
			wishlist: '/index.php?route=account/wishlist',
			account: '/index.php?route=account/account',
			orders: '/index.php?route=account/order',
			logout: '/index.php?route=account/logout',
		})
	},
});

const searchQuery = ref('');
const newsletterEmail = ref('');
const isAccountOpen = ref(false);
const accountDropdown = ref(null);

const handleSearch = () => {
	if (searchQuery.value.trim()) {
		router.visit(props.safeUrls.search + '&search=' + encodeURIComponent(searchQuery.value));
	}
};

const handleNewsletter = () => {
	if (newsletterEmail.value) {
		console.log('Newsletter subscription:', newsletterEmail.value);
		newsletterEmail.value = '';
	}
};

// Close account dropdown when clicking outside
const handleClickOutside = (event) => {
	if (accountDropdown.value && !accountDropdown.value.contains(event.target)) {
		isAccountOpen.value = false;
	}
};

onMounted(() => {
	document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
	document.removeEventListener('click', handleClickOutside);
});
</script>
