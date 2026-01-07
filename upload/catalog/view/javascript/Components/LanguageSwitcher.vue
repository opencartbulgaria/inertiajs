<template>
	<div class="relative" ref="dropdown">
		<!-- Current Language Button -->
		<button
			@click="isOpen = !isOpen"
			class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition"
		>
			<img
				v-if="currentLanguage.image"
				:src="`/image/${currentLanguage.image}`"
				:alt="currentLanguage.name"
				class="w-5 h-5 rounded"
			/>
			<span class="text-sm font-medium text-gray-700">
        {{ currentLanguage.code.toUpperCase() }}
      </span>
			<svg
				class="w-4 h-4 text-gray-500 transition-transform"
				:class="{ 'rotate-180': isOpen }"
				fill="none"
				stroke="currentColor"
				viewBox="0 0 24 24"
			>
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
			</svg>
		</button>

		<!-- Dropdown Menu -->
		<transition
			enter-active-class="transition duration-200 ease-out"
			enter-from-class="opacity-0 translate-y-1"
			enter-to-class="opacity-100 translate-y-0"
			leave-active-class="transition duration-150 ease-in"
			leave-from-class="opacity-100 translate-y-0"
			leave-to-class="opacity-0 translate-y-1"
		>
			<div
				v-if="isOpen"
				class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50"
			>
				<button
					v-for="language in languages"
					:key="language.code"
					@click="changeLanguage(language.code)"
					class="w-full flex items-center space-x-3 px-4 py-2 hover:bg-gray-50 transition"
					:class="{ 'bg-blue-50': language.active }"
				>
					<img
						v-if="language.image"
						:src="`/image/${language.image}`"
						:alt="language.name"
						class="w-5 h-5 rounded"
					/>
					<span class="flex-1 text-left text-sm" :class="language.active ? 'font-semibold text-blue-600' : 'text-gray-700'">
            {{ language.name }}
          </span>
					<svg
						v-if="language.active"
						class="w-4 h-4 text-blue-600"
						fill="currentColor"
						viewBox="0 0 20 20"
					>
						<path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
					</svg>
				</button>
			</div>
		</transition>
	</div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
	languages: {
		type: Array,
		required: true
	},
	currentLanguageCode: {
		type: String,
		default: ''
	}
});

const isOpen = ref(false);
const dropdown = ref(null);

const currentLanguage = computed(() => {
	// Try exact match first
	let found = props.languages.find(lang => lang.code === props.currentLanguageCode);

	// If not found, try finding active language
	if (!found) {
		found = props.languages.find(lang => lang.active);
	}

	// Fallback to first language
	return found || props.languages[0] || { code: 'en', name: 'English' };
});

const changeLanguage = (code) => {
	isOpen.value = false;

	// Get current URL
	const url = new URL(window.location.href);

	// Update language parameter
	url.searchParams.set('language', code);

	// Navigate with Inertia
	router.visit(url.toString(), {
		preserveState: false,
		preserveScroll: false,
	});
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
	if (dropdown.value && !dropdown.value.contains(event.target)) {
		isOpen.value = false;
	}
};

onMounted(() => {
	document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
	document.removeEventListener('click', handleClickOutside);
});
</script>
