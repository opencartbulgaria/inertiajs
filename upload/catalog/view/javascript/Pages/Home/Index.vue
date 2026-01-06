<template>
	<MainLayout :store-name="store_name">
		<!-- Hero Section -->
		<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
				<div class="text-center">
					<h1 class="text-4xl md:text-5xl font-bold mb-4">
						Добре дошли в {{ store_name }}
					</h1>
					<p class="text-xl text-blue-100 mb-8">
						Открийте най-добрите технологични продукти на най-добри цени
					</p>
					<button class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
						Разгледай продукти
					</button>
				</div>
			</div>
		</section>

		<!-- Stats Section -->
		<section class="bg-white border-b">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
				<div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
					<div>
						<div class="text-3xl font-bold text-blue-600">{{ product_count }}+</div>
						<div class="text-gray-600 mt-1">Продукта</div>
					</div>
					<div>
						<div class="text-3xl font-bold text-blue-600">10K+</div>
						<div class="text-gray-600 mt-1">Клиенти</div>
					</div>
					<div>
						<div class="text-3xl font-bold text-blue-600">24/7</div>
						<div class="text-gray-600 mt-1">Поддръжка</div>
					</div>
					<div>
						<div class="text-3xl font-bold text-blue-600">100%</div>
						<div class="text-gray-600 mt-1">Гаранция</div>
					</div>
				</div>
			</div>
		</section>

		<!-- Featured Products -->
		<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
			<div class="flex justify-between items-center mb-8">
				<h2 class="text-3xl font-bold text-gray-900">Популярни продукти</h2>
				<a href="#" class="text-blue-600 hover:text-blue-700 font-medium">
					Виж всички →
				</a>
			</div>

			<!-- Products Grid -->
			<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
				<ProductCard
					v-for="product in products"
					:key="product.product_id"
					:product="product"
				/>
			</div>
		</section>

		<!-- Features Section -->
		<section class="bg-gray-100 py-12">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
					<!-- Free Shipping -->
					<div class="bg-white p-6 rounded-lg shadow-sm text-center">
						<div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
							<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
							</svg>
						</div>
						<h3 class="text-lg font-semibold mb-2">Безплатна доставка</h3>
						<p class="text-gray-600 text-sm">При поръчка над 100 лв</p>
					</div>

					<!-- Secure Payment -->
					<div class="bg-white p-6 rounded-lg shadow-sm text-center">
						<div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
							<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
							</svg>
						</div>
						<h3 class="text-lg font-semibold mb-2">Сигурно плащане</h3>
						<p class="text-gray-600 text-sm">100% защитени транзакции</p>
					</div>

					<!-- Support -->
					<div class="bg-white p-6 rounded-lg shadow-sm text-center">
						<div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
							<svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
							</svg>
						</div>
						<h3 class="text-lg font-semibold mb-2">Поддръжка 24/7</h3>
						<p class="text-gray-600 text-sm">Винаги на разположение</p>
					</div>
				</div>
			</div>
		</section>
	</MainLayout>
</template>

<script setup>
import MainLayout from '../../Layouts/MainLayout.vue';
import ProductCard from '../../Components/ProductCard.vue';

defineProps({
	store_name: String,
	product_count: Number,
	products: Array
});
</script>
