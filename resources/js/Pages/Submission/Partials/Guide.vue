<script setup>
import { ref, onMounted } from "vue";
import { Link, useForm, router } from "@inertiajs/vue3";

import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import Card from "@/Components/Card.vue";

// Props
const props = defineProps({
    is_paid: {
        default: null,
        type: [Boolean, String],
    },
    wave: {
        default: null,
    },
    percent: Object,
    status: {
        default: null,
        type: String,
    },
    note: {
        default: null,
        type: String,
    },
});

const modal = ref(false);
const form = useForm({});

const progressName = {
    personal: "Data Diri",
    address: "Alamat Rumah",
    education: "Pendidikan",
    parent: "Orang Tua",
    document: "Dokumen",
};

// Navigasi
const goToForm = () => router.visit(route("form.edit", { id: "personal" }));
const goToHome = () => router.visit(route("dashboard"));

// Verifikasi
const verification = () => {
    // Jika belum membayar, redirect ke halaman pembayaran
    if (!props.is_paid || props.is_paid === false || props.is_paid === "false") {
        router.visit(route("form.payment"));
        return; // Hentikan proses validasi
    }

    // Jika sudah membayar, kirim form
    form.post(route("form.validation"), {
        preserveScroll: true,
        onFinish: () => (modal.value = false),
    });
};


// 🔁 Redirect otomatis jika belum bayar saat komponen dimounting
onMounted(() => {
   
});
</script>



<template>
    <div class="col-12 mx-auto px-4 py-6 space-y-6">

        <!-- ✏️ Card: Pendaftaran -->
        <Card
            class="mb-6"
            title="Pendaftaran"
            description="Anda sudah mendapatkan akses form pendaftaran tahun ajaran, silahkan melakukan pendaftaran dengan mengisi form pendaftaran."
        >
        <div class="grid grid-cols-2 gap-4 mt-4">
            <PrimaryButton class="w-full" @click="goToForm">
                Isi Data Diri
            </PrimaryButton>
            <PrimaryButton class="w-auto px-4 flex items-center justify-center gap-2" @click="goToHome">
                <i class="fa-solid fa-house text-sm"></i>
                <span>Beranda</span>
            </PrimaryButton>
        </div>
        </Card>

        <!-- 📊 Card: Progres Pendaftaran -->
        <Card
            class="mb-6"
            title="Progres Pendaftaran"
            description="Jika anda sudah mengisi semua data yang dibutuhkan untuk pendaftaran, silahkan mengajukan verifikasi dengan mengklik tombol dibawah ini."
        >
            <!-- ⚠️ Notifikasi jika ditolak -->
            <div
                v-if="status === 'rejected' && note"
                class="bg-yellow-50 dark:bg-yellow-800 border-l-4 border-yellow-400 p-4 rounded-lg my-4"
            >
                <h4 class="flex items-center text-lg font-semibold text-yellow-600 dark:text-yellow-400">
                    <i class="fa-solid fa-exclamation-triangle text-yellow-400"></i>
                    <span class="ml-2">Perhatian</span>
                </h4>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    {{ note }}
                </p>
            </div>

            <!-- 📈 Progress Bar -->
            <div class="pt-6 space-y-4">
                <div
                    v-for="(value, key) in percent"
                    :key="key"
                >
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-200 capitalize">
                            {{ progressName[key] }}
                        </span>
                        <span class="text-sm text-gray-600 dark:text-gray-300">
                            {{ value.toFixed(0) }}%
                        </span>
                    </div>
                    <div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                        <div
                            class="h-full bg-teal-600 dark:bg-teal-500 transition-all duration-500"
                            :style="{ width: `${value}%` }"
                        />
                    </div>
                </div>
            </div>

            <!-- 🔒 Tombol Ajukan -->
            <div class="flex justify-end mt-8">
                <PrimaryButton @click="modal = true">Ajukan Verifikasi</PrimaryButton>
            </div>
        </Card>

        <!-- ✅ Modal Konfirmasi -->
        <Modal :show="modal" @close="modal = false">
            <div class="p-6 space-y-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Ajukan Verifikasi
                </h3>
                <p class="text-gray-700 dark:text-gray-300">
                    Sebelum mengajukan verifikasi, pastikan bahwa data yang Anda isi sudah benar dan sesuai dengan data diri Anda. Jika sudah yakin, silakan klik tombol di bawah ini.
                </p>
                <p class="text-sm text-red-600 dark:text-red-400 font-semibold">
                    Harap dicatat bahwa setelah Anda mengumpulkan, Anda tidak akan dapat mengganti data yang sudah diserahkan.
                </p>
                <div class="flex justify-end gap-4 mt-6">
                    <SecondaryButton @click="modal = false">Tutup</SecondaryButton>
                    <PrimaryButton @click="verification">Ajukan Verifikasi</PrimaryButton>
                </div>
            </div>
        </Modal>
    </div>
</template>
