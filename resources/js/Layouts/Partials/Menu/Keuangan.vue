<script setup>
import ResponsiveSideBar from "@/Components/ResponsiveSideBar.vue";
</script>

<template>
    <div class="mb-8">
        <header
            class="px-3 mb-4 text-xs font-semibold tracking-wider text-gray-500 uppercase dark:text-gray-400"
        >
            Keuangan
        </header>
        <ul
            class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-200 dark:border-gray-700"
        >
        <li>
                <ResponsiveSideBar
                    :href="route('admin.item-payment')"
                    :active="route().current('admin.item-payment')"
                    icon="fa-solid fa-money-bill"
                >
                    Item Pembayaran
                </ResponsiveSideBar>
            </li>
            <li>
                <ResponsiveSideBar
                    :href="route('admin.payment')"
                    :active="route().current('admin.payment')"
                    icon="fa-solid fa-money-bill"
                >
                    Data Pembayaran
                </ResponsiveSideBar>
            </li>
        </ul>
    </div>
</template>
