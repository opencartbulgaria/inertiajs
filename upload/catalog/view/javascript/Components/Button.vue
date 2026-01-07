<template>
	<component
		:is="tag"
		:type="type"
		:class="buttonClasses"
		:disabled="disabled || loading"
		@click="handleClick"
	>
    <span v-if="loading" class="inline-block animate-spin mr-2">
      <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
    </span>
		<slot />
	</component>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
	variant: {
		type: String,
		default: 'primary', // primary, secondary, outline, ghost, danger
	},
	size: {
		type: String,
		default: 'md', // sm, md, lg
	},
	tag: {
		type: String,
		default: 'button',
	},
	type: {
		type: String,
		default: 'button',
	},
	disabled: {
		type: Boolean,
		default: false,
	},
	loading: {
		type: Boolean,
		default: false,
	},
	fullWidth: {
		type: Boolean,
		default: false,
	},
});

const emit = defineEmits(['click']);

const buttonClasses = computed(() => {
	const base = 'inline-flex items-center justify-center font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

	const variants = {
		primary: 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
		secondary: 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500',
		outline: 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
		ghost: 'text-gray-700 hover:bg-gray-100 focus:ring-gray-500',
		danger: 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
	};

	const sizes = {
		sm: 'px-3 py-1.5 text-sm rounded-md',
		md: 'px-4 py-2 text-base rounded-lg',
		lg: 'px-6 py-3 text-lg rounded-lg',
	};

	const width = props.fullWidth ? 'w-full' : '';

	return `${base} ${variants[props.variant]} ${sizes[props.size]} ${width}`;
});

const handleClick = (event) => {
	if (!props.disabled && !props.loading) {
		emit('click', event);
	}
};
</script>
