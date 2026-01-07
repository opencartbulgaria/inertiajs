<template>
	<MainLayout
		:store-name="store_name"
		:cart-count="cart_items.length"
		:wishlist-count="wishlist_count"
	>
		<!-- Breadcrumbs -->
		<div class="bg-white border-b">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
				<nav class="flex items-center space-x-2 text-sm text-gray-600">
					<Link href="/" class="hover:text-blue-600">Начало</Link>
					<span>/</span>
					<span class="text-gray-900">Количка</span>
				</nav>
			</div>
		</div>

		<!-- Notification -->
		<transition
			enter-active-class="transition duration-300 ease-out"
			enter-from-class="opacity-0 translate-y-2"
			enter-to-class="opacity-100 translate-y-0"
			leave-active-class="transition duration-200 ease-in"
			leave-from-class="opacity-100"
			leave-to-class="opacity-0 translate-y-2"
		>
			<div v-if="notification" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
				<div
					class="p-4 rounded-lg flex items-center justify-between"
					:class="notification.type === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'"
				>
					<div class="flex items-center">
						<svg v-if="notification.type === 'success'" class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
						</svg>
						<svg v-else class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
						</svg>
						<span>{{ notification.text }}</span>
					</div>
					<button @click="notification = null" class="ml-4">
						<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
						</svg>
					</button>
				</div>
			</div>
		</transition>

		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			<!-- Empty Cart -->
			<div v-if="cart_items.length === 0" class="text-center py-16">
				<svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
				</svg>
				<h2 class="text-2xl font-bold text-gray-900 mb-2">Вашата количка е празна</h2>
				<p class="text-gray-600 mb-6">Добавете продукти, за да продължите с поръчката</p>
				<Link href="/">
					<Button variant="primary" size="lg">
						Разгледай продукти
					</Button>
				</Link>
			</div>

			<!-- Cart with Items -->
			<div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
				<!-- Cart Items -->
				<div class="lg:col-span-2 space-y-4">
					<div class="flex items-center justify-between mb-4">
						<h1 class="text-2xl font-bold text-gray-900">
							Количка ({{ cart_items.length }} {{ cart_items.length === 1 ? 'продукт' : 'продукта' }})
						</h1>
						<button
							@click="clearCart"
							class="text-red-600 hover:text-red-700 text-sm font-medium"
						>
							Изчисти количката
						</button>
					</div>

					<!-- Cart Item Card -->
					<div
						v-for="item in cart_items"
						:key="item.cart_id"
						class="bg-white rounded-lg shadow-sm p-4 md:p-6"
					>
						<div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
							<!-- Product Image -->
							<Link :href="`/index.php?route=product/product&product_id=${item.product_id}`" class="flex-shrink-0">
								<div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden">
									<img
										v-if="item.image"
										:src="item.image"
										:alt="item.name"
										class="w-full h-full object-cover"
									/>
									<div v-else class="w-full h-full flex items-center justify-center">
										<svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
										</svg>
									</div>
								</div>
							</Link>

							<!-- Product Info -->
							<div class="flex-1 min-w-0">
								<Link :href="`/index.php?route=product/product&product_id=${item.product_id}`">
									<h3 class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition">
										{{ item.name }}
									</h3>
								</Link>
								<p v-if="item.model" class="text-sm text-gray-500 mt-1">
									Модел: {{ item.model }}
								</p>
								<p class="text-lg font-bold text-blue-600 mt-2">
									{{ item.price }} × {{ item.quantity }}
								</p>
							</div>

							<!-- Quantity Controls -->
							<div class="flex items-center space-x-4">
								<div class="flex items-center border border-gray-300 rounded-lg">
									<button
										@click="updateQuantity(item.cart_id, Number(item.quantity) - 1)"
										class="px-3 py-2 hover:bg-gray-100 transition disabled:opacity-50"
										:disabled="item.quantity <= 1"
									>
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
										</svg>
									</button>
									<span class="px-4 py-2 text-center min-w-12 font-medium">
                    {{ item.quantity }}
                  </span>
									<button
										@click="updateQuantity(item.cart_id, Number(item.quantity) + 1)"
										class="px-3 py-2 hover:bg-gray-100 transition"
									>
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
										</svg>
									</button>
								</div>

								<!-- Total Price -->
								<div class="text-right min-w-24">
									<p class="text-xl font-bold text-gray-900">
										{{ item.total }}
									</p>
								</div>

								<!-- Remove Button -->
								<button
									@click="removeItem(item.cart_id)"
									class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
								>
									<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
									</svg>
								</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Order Summary -->
				<div class="lg:col-span-1">
					<div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
						<h2 class="text-xl font-bold text-gray-900 mb-4">Обобщение на поръчката</h2>

						<div class="space-y-3 mb-4">
							<div class="flex justify-between text-gray-600">
								<span>Междинна сума:</span>
								<span class="font-medium">{{ totals.subtotal }}</span>
							</div>

							<div v-if="totals.discount" class="flex justify-between text-green-600">
								<span>Отстъпка:</span>
								<span class="font-medium">-{{ totals.discount }}</span>
							</div>

							<div class="flex justify-between text-gray-600">
								<span>Доставка:</span>
								<span class="font-medium">{{ totals.shipping || 'Безплатна' }}</span>
							</div>

							<div v-if="totals.tax" class="flex justify-between text-gray-600">
								<span>ДДС (20%):</span>
								<span class="font-medium">{{ totals.tax }}</span>
							</div>
						</div>

						<div class="border-t border-gray-200 pt-4 mb-6">
							<div class="flex justify-between items-center">
								<span class="text-lg font-semibold text-gray-900">Общо:</span>
								<span class="text-2xl font-bold text-blue-600">{{ totals.total }}</span>
							</div>
						</div>

						<!-- Coupon Code -->
						<div class="mb-4">
							<form @submit.prevent="applyCoupon">
								<div class="flex space-x-2">
									<input
										v-model="couponCode"
										type="text"
										placeholder="Промо код (DISCOUNT10)"
										:disabled="coupon_applied"
										class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-100"
									/>
									<Button
										v-if="!coupon_applied"
										variant="outline"
										type="submit"
										:loading="applyingCoupon"
									>
										Приложи
									</Button>
									<span v-else class="flex items-center text-green-600 font-medium px-3">
                    ✓ Приложен
                  </span>
								</div>
							</form>
						</div>

						<!-- Checkout Button -->
						<Button
							variant="primary"
							size="lg"
							full-width
							@click="checkout"
						>
							Продължи към плащане
						</Button>

						<!-- Continue Shopping -->
						<Link href="/" class="block mt-4">
							<Button
								variant="ghost"
								size="lg"
								full-width
							>
								Продължи пазаруването
							</Button>
						</Link>

						<!-- Trust Badges -->
						<div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
							<div class="flex items-center text-sm text-gray-600">
								<svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
								</svg>
								Сигурно плащане
							</div>
							<div class="flex items-center text-sm text-gray-600">
								<svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
								</svg>
								Безплатна доставка над 100 лв
							</div>
							<div class="flex items-center text-sm text-gray-600">
								<svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
								</svg>
								14 дни право на връщане
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</MainLayout>
</template>

<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import MainLayout from '../../Layouts/MainLayout.vue';
import Button from '../../Components/Button.vue';

const props = defineProps({
	store_name: String,
	wishlist_count: Number,
	cart_items: Array,
	totals: Object,
	coupon_applied: Boolean,
	coupon_message: Object,
});

const couponCode = ref('');
const applyingCoupon = ref(false);
const notification = ref(props.coupon_message);

if (notification.value) {
	setTimeout(() => {
		notification.value = null;
	}, 5000);
}

const updateQuantity = async (cartId, newQuantity) => {
	newQuantity = Number.parseInt(newQuantity, 10);
	if (Number.isNaN(newQuantity)) return;
	if (newQuantity < 1) return;

	try {
		const formData = new FormData();
		formData.append('cart_id', cartId);
		formData.append('quantity', newQuantity);

		const response = await fetch('/index.php?route=checkout/cart.update', {
			method: 'POST',
			body: formData
		});

		const data = await response.json();

		if (data.success) {
			// Reload cart data
			router.reload({ only: ['cart_items', 'totals'] });
		}
	} catch (error) {
		console.error('Error updating quantity:', error);
	}
};

const removeItem = async (cartId) => {
	if (!confirm('Сигурни ли сте, че искате да премахнете този продукт?')) {
		return;
	}

	try {
		const formData = new FormData();
		formData.append('cart_id', cartId);

		const response = await fetch('/index.php?route=checkout/cart.remove', {
			method: 'POST',
			body: formData
		});

		const data = await response.json();

		if (data.success) {
			notification.value = {
				type: 'success',
				text: data.message
			};

			// Reload cart data
			router.reload({ only: ['cart_items', 'totals'] });

			setTimeout(() => {
				notification.value = null;
			}, 3000);
		}
	} catch (error) {
		console.error('Error removing item:', error);
	}
};

const clearCart = () => {
	if (confirm('Сигурни ли сте, че искате да изчистите цялата количка?')) {
		router.visit('/index.php?route=checkout/cart.clear');
	}
};

const applyCoupon = () => {
	if (!couponCode.value.trim()) return;

	// За coupon ще използваме стандартния OpenCart начин
	router.visit('/index.php?route=checkout/cart', {
		method: 'post',
		data: {
			coupon: couponCode.value
		}
	});
};

const checkout = () => {
	router.visit('/index.php?route=checkout/checkout');
};
</script>
