<template>
	<div class="min-h-screen flex flex-col bg-gray-50">
		<!-- Header -->
		<header class="bg-white shadow-sm sticky top-0 z-50">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex justify-between items-center h-16">
					<!-- Logo -->
					<div class="flex items-center">
						<a href="/" class="text-2xl font-bold text-gray-900">
							{{ storeName }}
						</a>
					</div>

					<!-- Search Bar -->
					<div class="hidden md:flex flex-1 max-w-2xl mx-8">
						<div class="w-full">
							<input
								type="text"
								placeholder="Търсене на продукти..."
								class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
							/>
						</div>
					</div>

					<!-- Nav Icons -->
					<div class="flex items-center space-x-4">
						<button class="p-2 text-gray-600 hover:text-gray-900 relative">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
							</svg>
						</button>
						<button class="p-2 text-gray-600 hover:text-gray-900 relative">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
							</svg>
						</button>
						<button class="p-2 text-gray-600 hover:text-gray-900 relative">
							<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
							</svg>
							<span class="absolute -top-1 -right-1 bg-blue-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                0
              </span>
						</button>
					</div>
				</div>

				<!-- Mobile Search -->
				<div class="md:hidden pb-3">
					<input
						type="text"
						placeholder="Търсене..."
						class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
					/>
				</div>
			</div>
		</header>

		<!-- Navigation -->
		<nav class="bg-white border-b">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex space-x-8 h-12 items-center overflow-x-auto">
					<a href="#" class="text-gray-700 hover:text-blue-600 whitespace-nowrap font-medium">Начало</a>
					<a href="#" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Електроника</a>
					<a href="#" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Компютри</a>
					<a href="#" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Телефони</a>
					<a href="#" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Камери</a>
					<a href="#" class="text-gray-700 hover:text-blue-600 whitespace-nowrap">Аксесоари</a>
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
							<li><a href="#" class="hover:text-white">Контакти</a></li>
							<li><a href="#" class="hover:text-white">Доставка</a></li>
							<li><a href="#" class="hover:text-white">Връщане</a></li>
						</ul>
					</div>

					<!-- Customer Service -->
					<div>
						<h3 class="text-white text-lg font-semibold mb-4">Обслужване</h3>
						<ul class="space-y-2 text-sm">
							<li><a href="#" class="hover:text-white">Моят акаунт</a></li>
							<li><a href="#" class="hover:text-white">История на поръчки</a></li>
							<li><a href="#" class="hover:text-white">Списък желания</a></li>
							<li><a href="#" class="hover:text-white">Новини</a></li>
						</ul>
					</div>

					<!-- Newsletter -->
					<div>
						<h3 class="text-white text-lg font-semibold mb-4">Бюлетин</h3>
						<p class="text-sm text-gray-400 mb-4">
							Абонирайте се за нашия бюлетин и получавайте специални оферти.
						</p>
						<div class="flex">
							<input
								type="email"
								placeholder="Вашият email"
								class="flex-1 px-4 py-2 rounded-l-lg text-gray-900 focus:outline-none"
							/>
							<button class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-r-lg text-white">
								Абонирай
							</button>
						</div>
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
defineProps({
	storeName: {
		type: String,
		default: 'OpenCart'
	}
});
</script>
