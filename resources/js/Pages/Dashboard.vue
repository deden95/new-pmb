<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                Dashboard
            </h2>
        </template>
    <div class="col-12 mx-auto px-2  py-6 space-y-6 ">
            <!-- Welcome Message -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <h1 class="text-2xl font-bold mb-2">
                    Selamat Datang, {{ user.name }} 👋
                </h1>
                <p v-if="page.props.auth.form.status == 'waiting' || page.props.auth.form.status == 'rejected' "
                class="text-gray-600 dark:text-gray-300">
                    {{
                        formAlready
                            ? "Silakan lanjut mengisi formulir pendaftaran."
                            : "Apakah Anda akan mendaftar sebagai mahasiswa baru? Klik tombol di bawah."
                    }}
                </p>
                <PrimaryButton  v-if="page.props.auth.form.status == 'waiting' || page.props.auth.form.status == 'rejected' "
                 class="mt-4" @click="goToForm">
                    {{ formAlready ? "Lanjut" : "Pendaftaran" }}
                </PrimaryButton>
            </div>
         </div>
        <!-- GRID MENU MOBILE -->
        <div class="grid grid-cols-3 px-2 gap-4 mb-6 md:hidden">
            <MenuGridItem
                icon="fa-solid fa-house"
                label="Dashboard"
                :href="route('dashboard')"
                :active="route().current('dashboard')"
            />
            <MenuGridItem
                v-if="check"
                icon="fa-solid fa-file-invoice"
                label="Pendaftaran"
                :href="route('form.submission')"
                :active="route().current('form.submission')"
            />
            <MenuGridItem
                v-if="page.props.auth.form.status == 'waiting' || page.props.auth.form.status == 'rejected' ||  page.props.auth.form.status == 'pending' "
                icon="fa-solid fa-address-card"
                label="Data Diri"
                :href="route('form.edit', { id: 'personal' })"
                :active="route().current('form.edit')"
            />
            <MenuGridItem
             v-if="page.props.auth.form.status == 'waiting' || page.props.auth.form.status == 'rejected' || page.props.auth.form.status == 'submitted' || page.props.auth.form.status == 'pending' || page.props.auth.form.status == 'approved'"
                icon="fa-solid fa-money-bill"
                label="Pembayaran"
                :href="route('form.payment')"
                :active="route().current('form.payment')"
            />
        </div>

        <!-- Dashboard Content -->
    <div class="col-12 mx-auto px-2 py-6 space-y-6">

            <!-- Panduan -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold mb-4">Panduan Pengisian</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div v-for="(step, index) in steps" :key="index" 
                         class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-blue-500">
                        <div class="flex items-start">
                            <span class="bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full px-3 py-1 text-sm font-medium mr-3">
                                Langkah {{ index + 1 }}
                            </span>
                        </div>
                        <h3 class="font-semibold text-gray-800 dark:text-white mt-3 mb-2">
                            {{ step.title }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300" v-html="step.content" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head, usePage, router } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MenuGridItem from "@/Layouts/Partials/Menu/MenuGridItem.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
const page = usePage();
const user = page.props.auth.user;
const formAlready = page.props.auth.form.already;
const check = page.props.auth.check ?? true;

const goToForm = () => {
    if (formAlready) {
        router.visit(route("form.edit", { id: "personal" }));
    } else {
        router.visit(route("form.submission"));
    }
};

const steps = [
    {
        title: "Ajukan Formulir",
        content:
            'Pilih gelombang dan jurusan yang Anda inginkan di menu <a class="text-blue-600 underline" href="' +
            route("form.submission") +
            '">pendaftaran</a>.',
    },
    {
        title: "Isi Setiap Formulir",
        content:
            'Isi data dengan benar sesuai identitas diri Anda di menu data diri.',
    },
    {
        title: "Ikuti Tes Seleksi",
        content:
            "Tes dilakukan Offline/online di Kampus. Pastikan koneksi internet Anda stabil.",
    },
    {
        title: "Tunggu Pengumuman",
        content:
            'Hasil seleksi akan diumumkan di menu <a class="text-blue-600 underline" href="' +
            route("form.submission") +
            '">pendaftaran</a>.',
    },
];
</script>
