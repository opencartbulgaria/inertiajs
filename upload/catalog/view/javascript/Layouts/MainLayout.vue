<template>
	<div class="min-h-screen flex flex-col bg-gray-50">
		<!-- Header -->
		<header class="bg-white shadow-sm sticky top-0 z-50">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between items-center h-16">
					<!-- Logo -->
					<div class="flex items-center">
						<Link href="/" class="text-2xl font-bold text-gray-900 hover:text-blue-600 transition">
							<img :src="header.logo" :alt="header.name" />
						</Link>
					</div>

					<!-- Search Bar -->
					<div class="hidden md:flex flex-1 max-w-2xl mx-8">
						<form @submit.prevent="handleSearch" class="w-full">
							<div class="relative">
								<input
									v-model="searchQuery"
									type="text"
									placeholder="Търсене на продукти..."
									class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
								/>
								<button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
									<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
									</svg>
								</button>
							</div>
						</form>
					</div>

					<!-- Nav Icons -->
					<div class="flex items-center space-x-4">
						<Link :href="header.login" class="p-2 text-gray-600 hover:text-gray-900 relative">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
							</svg>
						</Link>
						<button @click="toggleWishlist" class="p-2 text-gray-600 hover:text-gray-900 relative">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
							</svg>
							<span v-if="wishlistCount > 0" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                {{ wishlistCount }}
              </span>
						</button>
						<Link href="/cart" class="p-2 text-gray-600 hover:text-gray-900 relative">
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
						<input
							v-model="searchQuery"
							type="text"
							placeholder="Търсене..."
							class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
						/>
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
						class="text-gray-700 hover:text-blue-600 whitespace-nowrap transition"
						:class="{ 'font-bold text-blue-600': category.active }"
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
						<h3 class="text-white text-lg font-semibold mb-4">{{ header.name }}</h3>
						<p class="text-sm text-gray-400">
							Вашият надежден онлайн магазин за електроника и технология.
						</p>
						<div class="flex space-x-4 mt-4">
							<a href="#" class="text-gray-400 hover:text-white">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
									<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
								</svg>
							</a>
							<a href="#" class="text-gray-400 hover:text-white">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
									<path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
								</svg>
							</a>
							<a href="#" class="text-gray-400 hover:text-white">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
									<path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
								</svg>
							</a>
						</div>
					</div>

					<!-- Quick Links -->
					<div>
						<h3 class="text-white text-lg font-semibold mb-4">Бързи връзки</h3>
						<ul class="space-y-2 text-sm">
							<li><Link href="/about" class="hover:text-white">За нас</Link></li>
							<li><Link href="/contact" class="hover:text-white">Контакти</Link></li>
							<li><Link href="/delivery" class="hover:text-white">Доставка</Link></li>
							<li><Link href="/returns" class="hover:text-white">Връщане</Link></li>
						</ul>
					</div>

					<!-- Customer Service -->
					<div>
						<h3 class="text-white text-lg font-semibold mb-4">Обслужване</h3>
						<ul class="space-y-2 text-sm">
							<li><Link href="/account" class="hover:text-white">Моят акаунт</Link></li>
							<li><Link href="/orders" class="hover:text-white">История на поръчки</Link></li>
							<li><Link href="/wishlist" class="hover:text-white">Списък желания</Link></li>
							<li><Link href="/newsletter" class="hover:text-white">Новини</Link></li>
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
					<p>&copy; 2026 {{ header.name }}. Всички права запазени.</p>
				</div>
			</div>
		</footer>
	</div>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
	header: {
		type: Array,
		default: []
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
		default: () => [
			{ id: 1, name: 'Начало', href: '/', active: true },
			{ id: 2, name: 'Електроника', href: '/category/electronics', active: false },
			{ id: 3, name: 'Компютри', href: '/category/computers', active: false },
			{ id: 4, name: 'Телефони', href: '/category/phones', active: false },
			{ id: 5, name: 'Камери', href: '/category/cameras', active: false },
		]
	}
});

const searchQuery = ref('');
const newsletterEmail = ref('');

const handleSearch = () => {
	if (searchQuery.value.trim()) {
		// Inertia visit to search page
		console.log('Searching for:', searchQuery.value);
	}
};

const handleNewsletter = () => {
	if (newsletterEmail.value) {
		console.log('Newsletter subscription:', newsletterEmail.value);
		newsletterEmail.value = '';
	}
};

const toggleWishlist = () => {
	console.log('Toggle wishlist');
};
</script>
