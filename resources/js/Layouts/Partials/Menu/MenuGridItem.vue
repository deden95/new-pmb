<template>
    <Link
        :href="href"
        class="flex flex-col items-center justify-center p-4 rounded-lg text-center shadow transition hover:bg-gray-100 dark:hover:bg-gray-700"
        :class="{ 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200': active }"
    >
        <i :class="[icon, 'text-2xl mb-2']"></i>
        <span class="text-sm font-medium">{{ label }}</span>
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    icon: String,
    label: String,
    href: String,
    active: Boolean,
});
</script>
