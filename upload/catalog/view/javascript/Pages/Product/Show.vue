<template>
	<MainLayout
		:store-name="store_name"
		:cart-count="cart_count"
		:wishlist-count="wishlist_count"
	>
		<!-- Breadcrumbs -->
		<div class="bg-white border-b">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
				<nav class="flex items-center space-x-2 text-sm text-gray-600">
					<Link href="/" class="hover:text-blue-600">Начало</Link>
					<span>/</span>
					<Link :href="`/category/${product.category_id}`" class="hover:text-blue-600">
						{{ product.category_name }}
					</Link>
					<span>/</span>
					<span class="text-gray-900">{{ product.name }}</span>
				</nav>
			</div>
		</div>

		<!-- Product Content -->
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
				<!-- Left: Image Gallery -->
				<div class="space-y-4">
					<!-- Main Image -->
					<div class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg overflow-hidden border-2 border-gray-200">
						<div class="w-full h-full flex items-center justify-center">
							<img
								v-if="selectedImage"
								:src="selectedImage"
								:alt="product.name"
								class="w-full h-full object-contain"
							/>
							<svg v-else class="w-48 h-48 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
							</svg>
						</div>

						<!-- Badges -->
						<div class="absolute top-4 left-4 flex flex-col space-y-2">
              <span v-if="product.is_new" class="bg-green-500 text-white text-sm font-bold px-3 py-1 rounded">
                НОВО
              </span>
							<span v-if="product.discount" class="bg-red-500 text-white text-sm font-bold px-3 py-1 rounded">
                -{{ product.discount }}%
              </span>
						</div>
					</div>

					<!-- Thumbnail Gallery -->
					<div class="grid grid-cols-4 gap-2">
						<button
							v-for="(image, index) in product.images"
							:key="index"
							@click="selectedImage = image"
							class="aspect-square rounded-lg overflow-hidden border-2 transition-all"
							:class="selectedImage === image ? 'border-blue-600' : 'border-gray-200 hover:border-gray-300'"
						>
							<img :src="image" :alt="`${product.name} ${index + 1}`" class="w-full h-full object-cover" />
						</button>
					</div>
				</div>

				<!-- Right: Product Info -->
				<div class="space-y-6">
					<!-- Title & Rating -->
					<div>
						<h1 class="text-3xl font-bold text-gray-900 mb-3">
							{{ product.name }}
						</h1>

						<div class="flex items-center space-x-4">
							<div class="flex items-center">
								<svg
									v-for="star in 5"
									:key="star"
									class="w-5 h-5"
									:class="star <= Math.floor(product.rating) ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current'"
									viewBox="0 0 20 20"
								>
									<path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
								</svg>
							</div>
							<span class="text-gray-600">{{ product.rating }} ({{ product.reviews }} отзива)</span>
						</div>
					</div>

					<!-- Price -->
					<div class="border-t border-b border-gray-200 py-6">
						<div class="flex items-center space-x-4">
              <span v-if="product.old_price" class="text-2xl text-gray-400 line-through">
                {{ product.old_price }}
              </span>
							<span class="text-4xl font-bold text-blue-600">
                {{ product.price }}
              </span>
						</div>
						<div v-if="product.discount" class="mt-2 text-green-600 font-medium">
							Спестявате {{ product.old_price_value - product.price_value }} лв ({{ product.discount }}%)
						</div>
					</div>

					<!-- Stock Status -->
					<div class="flex items-center space-x-2">
						<div
							class="flex items-center px-4 py-2 rounded-lg"
							:class="product.stock > 0 ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'"
						>
							<svg
								class="w-5 h-5 mr-2"
								fill="currentColor"
								viewBox="0 0 20 20"
							>
								<path v-if="product.stock > 0" fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
								<path v-else fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
							</svg>
							<span class="font-medium">
                {{ product.stock > 0 ? `В наличност (${product.stock} бр.)` : 'Изчерпан' }}
              </span>
						</div>
					</div>

					<!-- Quantity & Actions -->
					<div class="space-y-4">
						<div class="flex items-center space-x-4">
							<label class="text-gray-700 font-medium">Количество:</label>
							<div class="flex items-center border border-gray-300 rounded-lg">
								<button
									@click="decreaseQuantity"
									class="px-4 py-2 hover:bg-gray-100 transition"
									:disabled="quantity <= 1"
								>
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
									</svg>
								</button>
								<input
									v-model.number="quantity"
									type="number"
									min="1"
									:max="product.stock"
									class="w-16 text-center border-x border-gray-300 py-2 focus:outline-none"
								/>
								<button
									@click="increaseQuantity"
									class="px-4 py-2 hover:bg-gray-100 transition"
									:disabled="quantity >= product.stock"
								>
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
									</svg>
								</button>
							</div>
						</div>

						<!-- Action Buttons -->
						<div class="flex space-x-3">
							<Button
								variant="primary"
								size="lg"
								class="flex-1"
								:loading="isAddingToCart"
								:disabled="product.stock <= 0"
								@click="addToCart"
							>
								<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
								</svg>
								Добави в количка
							</Button>

							<Button
								variant="outline"
								size="lg"
								@click="toggleWishlist"
							>
								<svg
									class="w-6 h-6"
									:class="isInWishlist ? 'fill-current text-red-500' : ''"
									fill="none"
									stroke="currentColor"
									viewBox="0 0 24 24"
								>
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
								</svg>
							</Button>
						</div>

						<!-- Buy Now -->
						<Button
							variant="secondary"
							size="lg"
							full-width
							:disabled="product.stock <= 0"
							@click="buyNow"
						>
							Купи сега
						</Button>
					</div>

					<!-- Features -->
					<div class="border-t pt-6 space-y-3">
						<div class="flex items-center text-gray-700">
							<svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
							</svg>
							Безплатна доставка при поръчка над 100 лв
						</div>
						<div class="flex items-center text-gray-700">
							<svg class="w-5 h-5 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
							</svg>
							14 дни право на връщане
						</div>
						<div class="flex items-center text-gray-700">
							<svg class="w-5 h-5 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
							</svg>
							Официална гаранция 2 години
						</div>
					</div>
				</div>
			</div>

			<!-- Tabs Section -->
			<div class="mt-12">
				<div class="border-b border-gray-200">
					<nav class="flex space-x-8">
						<button
							v-for="tab in tabs"
							:key="tab.id"
							@click="activeTab = tab.id"
							class="py-4 px-1 border-b-2 font-medium text-sm transition-colors"
							:class="activeTab === tab.id
                ? 'border-blue-600 text-blue-600'
                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
						>
							{{ tab.name }}
						</button>
					</nav>
				</div>

				<div class="py-8">
					<!-- Description Tab -->
					<div v-if="activeTab === 'description'" class="prose max-w-none">
						<h3 class="text-xl font-semibold mb-4">Описание на продукта</h3>
						<div v-html="product.description"></div>
					</div>

					<!-- Specifications Tab -->
					<div v-if="activeTab === 'specifications'" class="space-y-4">
						<h3 class="text-xl font-semibold mb-4">Технически характеристики</h3>
						<table class="w-full">
							<tbody>
							<tr
								v-for="(spec, index) in product.specifications"
								:key="index"
								class="border-b"
								:class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
							>
								<td class="py-3 px-4 font-medium text-gray-700">{{ spec.label }}</td>
								<td class="py-3 px-4 text-gray-900">{{ spec.value }}</td>
							</tr>
							</tbody>
						</table>
					</div>

					<!-- Reviews Tab -->
					<div v-if="activeTab === 'reviews'">
						<h3 class="text-xl font-semibold mb-4">Отзиви от клиенти</h3>
						<div class="text-gray-600">
							Все още няма отзиви за този продукт.
						</div>
					</div>
				</div>
			</div>

			<!-- Related Products -->
			<div class="mt-12">
				<h2 class="text-2xl font-bold text-gray-900 mb-6">Свързани продукти</h2>
				<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
					<ProductCard
						v-for="relatedProduct in related_products"
						:key="relatedProduct.product_id"
						:product="relatedProduct"
					/>
				</div>
			</div>
		</div>
	</MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import MainLayout from '../../Layouts/MainLayout.vue';
import Button from '../../Components/Button.vue';
import ProductCard from '../../Components/ProductCard.vue';

const props = defineProps({
	store_name: String,
	cart_count: Number,
	wishlist_count: Number,
	product: Object,
	related_products: Array,
});

const quantity = ref(1);
const selectedImage = ref(props.product.images?.[0] || null);
const isInWishlist = ref(false);
const isAddingToCart = ref(false);
const activeTab = ref('description');

const tabs = [
	{ id: 'description', name: 'Описание' },
	{ id: 'specifications', name: 'Спецификации' },
	{ id: 'reviews', name: 'Отзиви' },
];

const increaseQuantity = () => {
	if (quantity.value < props.product.stock) {
		quantity.value++;
	}
};

const decreaseQuantity = () => {
	if (quantity.value > 1) {
		quantity.value--;
	}
};

const addToCart = async () => {
	isAddingToCart.value = true;

	try {
		const response = await fetch('/index.php?route=checkout/cart.add', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded',
			},
			body: new URLSearchParams({
				product_id: props.product.product_id,
				quantity: quantity.value
			})
		});

		const data = await response.json();

		if (data.success) {
			// Optionally show success message
			alert('Продуктът е добавен в количката!');

			// Refresh to update cart count
			router.reload({ only: ['cart_count'] });
		}
	} catch (error) {
		console.error('Error adding to cart:', error);
	} finally {
		isAddingToCart.value = false;
	}
};

const buyNow = async () => {
	await addToCart();
	router.visit('/index.php?route=checkout/cart');
};

const toggleWishlist = () => {
	isInWishlist.value = !isInWishlist.value;
	console.log('Wishlist toggled');
};
</script>
