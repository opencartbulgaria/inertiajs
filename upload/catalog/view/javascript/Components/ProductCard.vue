<template>
	<div
		class="bg-white rounded-lg shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group transform hover:-translate-y-1"
		@mouseenter="isHovered = true"
		@mouseleave="isHovered = false"
	>
		<!-- Product Image -->
		<div class="relative aspect-square bg-gray-100 overflow-hidden">
			<!-- Placeholder Image -->
			<div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
				<svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
				</svg>
			</div>

			<!-- Badges -->
			<div class="absolute top-2 left-2 flex flex-col space-y-2">
        <span v-if="product.is_new" class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">
          НОВО
        </span>
				<span v-if="product.discount" class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
          -{{ product.discount }}%
        </span>
			</div>

			<!-- Quick Actions -->
			<transition
				enter-active-class="transition duration-200 ease-out"
				enter-from-class="opacity-0 translate-x-2"
				enter-to-class="opacity-100 translate-x-0"
				leave-active-class="transition duration-150 ease-in"
				leave-from-class="opacity-100 translate-x-0"
				leave-to-class="opacity-0 translate-x-2"
			>
				<div v-if="isHovered" class="absolute top-2 right-2 flex flex-col space-y-2">
					<button
						@click="toggleWishlist"
						class="bg-white p-2 rounded-full shadow-md hover:bg-red-50 transition-colors group/wishlist"
						:class="{ 'bg-red-50': isInWishlist }"
					>
						<svg
							class="w-5 h-5 transition-colors"
							:class="isInWishlist ? 'text-red-500 fill-current' : 'text-gray-600 group-hover/wishlist:text-red-500'"
							fill="none"
							stroke="currentColor"
							viewBox="0 0 24 24"
						>
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
						</svg>
					</button>
					<button
						@click="quickView"
						class="bg-white p-2 rounded-full shadow-md hover:bg-blue-50 transition-colors group/view"
					>
						<svg class="w-5 h-5 text-gray-600 group-hover/view:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
						</svg>
					</button>
					<button
						@click="compare"
						class="bg-white p-2 rounded-full shadow-md hover:bg-purple-50 transition-colors group/compare"
					>
						<svg class="w-5 h-5 text-gray-600 group-hover/compare:text-purple-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
						</svg>
					</button>
				</div>
			</transition>
		</div>

		<!-- Product Info -->
		<div class="p-4">
			<Link :href="`/index.php?route=product/product&product_id=${product.product_id}`" class="block">
				<h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2 hover:text-blue-600 transition-colors">
					{{ product.name }}
				</h3>
			</Link>

			<!-- Rating -->
			<div class="flex items-center mb-3">
				<div class="flex items-center">
					<svg
						v-for="star in 5"
						:key="star"
						class="w-4 h-4"
						:class="star <= Math.floor(product.rating || 4.5) ? 'text-yellow-400 fill-current' : 'text-gray-300 fill-current'"
						viewBox="0 0 20 20"
					>
						<path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
					</svg>
				</div>
				<span class="ml-2 text-sm text-gray-500">({{ product.reviews || 0 }})</span>
			</div>

			<!-- Price -->
			<div class="flex items-center justify-between mb-4">
				<div>
          <span v-if="product.old_price" class="text-sm text-gray-400 line-through mr-2">
            {{ product.old_price }}
          </span>
					<span class="text-2xl font-bold text-blue-600">
            {{ product.price }}
          </span>
				</div>
				<div v-if="product.stock > 0" class="flex items-center text-green-600 text-sm">
					<svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
					</svg>
					В наличност
				</div>
				<div v-else class="text-red-600 text-sm">
					Изчерпан
				</div>
			</div>

			<!-- Add to Cart Button -->
			<Button
				variant="primary"
				full-width
				:loading="isAddingToCart"
				:disabled="product.stock <= 0"
				@click="addToCart"
			>
				<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
				</svg>
				<span v-if="product.stock > 0">Добави в количка</span>
				<span v-else>Изчерпан</span>
			</Button>
		</div>
	</div>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Button from './Button.vue';

const props = defineProps({
	product: {
		type: Object,
		required: true
	}
});

const isHovered = ref(false);
const isInWishlist = ref(false);
const isAddingToCart = ref(false);

const toggleWishlist = () => {
	isInWishlist.value = !isInWishlist.value;
	console.log('Wishlist toggled:', isInWishlist.value);
};

const quickView = () => {
	console.log('Quick view:', props.product.product_id);
};

const compare = () => {
	console.log('Compare:', props.product.product_id);
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
				quantity: 1
			})
		});

		const data = await response.json();

		if (data.success) {
			// Refresh page to update cart count
			router.reload({ only: ['cart_count'] });
		}
	} catch (error) {
		console.error('Error adding to cart:', error);
	} finally {
		isAddingToCart.value = false;
	}
};
</script>
