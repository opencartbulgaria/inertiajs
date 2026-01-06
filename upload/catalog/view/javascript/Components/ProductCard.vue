<template>
	<div class="bg-white rounded-lg shadow-sm hover:shadow-lg transition-shadow overflow-hidden group">
		<!-- Product Image -->
		<div class="relative aspect-square bg-gray-100 overflow-hidden">
			<div class="w-full h-full flex items-center justify-center">
				<svg class="w-24 h-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
				</svg>
			</div>

			<!-- Quick Actions -->
			<div class="absolute top-2 right-2 flex flex-col space-y-2 opacity-0 group-hover:opacity-100 transition-opacity">
				<button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-50">
					<svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
					</svg>
				</button>
				<button class="bg-white p-2 rounded-full shadow-md hover:bg-gray-50">
					<svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
					</svg>
				</button>
			</div>
		</div>

		<!-- Product Info -->
		<div class="p-4">
			<h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
				{{ product.name }}
			</h3>

			<div class="flex items-center justify-between mb-3">
        <span class="text-2xl font-bold text-blue-600">
          {{ product.price }}
        </span>
				<div class="flex items-center text-sm text-gray-500">
					<svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
						<path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
					</svg>
					<span class="ml-1">4.5</span>
				</div>
			</div>

			<button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg font-medium transition flex items-center justify-center space-x-2">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
				</svg>
				<span>Добави в количка</span>
			</button>
		</div>
	</div>
</template>

<script setup>
defineProps({
	product: {
		type: Object,
		required: true
	}
});
</script>
