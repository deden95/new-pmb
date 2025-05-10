<template>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <h2 class="font-bold text-left text-black text-2xl capitalize">
                Pembayaran formulir pendaftaran
            </h2>
            <p>
                Anda sudah mengajukan pendaftaran untuk tahun ajaran
                <span class="font-semibold">{{ wave.tahun_akademik }}</span>,
                silahkan melakukan pembayaran formulir untuk melanjutkan
                proses pendaftaran.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                <div class="shadow-md sm:shadow-lg p-4 sm:p-8">
                    <h3 class="font-semibold text-left text-black text-xl capitalize">
                        Informasi Pembayaran
                    </h3>

                    <p>
                        Lakukan pembayaran sebesar
                        <span class="font-semibold text-blue-700">
                            {{
                                new Intl.NumberFormat("id-ID", {
                                    style: "currency",
                                    currency: "IDR",
                                    minimumFractionDigits: 0,
                                    maximumFractionDigits: 0
                                }).format(amount)
                            }}
                        </span>
                    </p>

                    <!-- Payment Method Image -->
                    <div class="mt-4">
                        <img
                            src="https://ratapay.co.id/wp-content/uploads/2022/08/Ratapay-Bank-Logos.png"
                            alt="Metode Pembayaran"
                            class="w-full h-auto"
                        />
                    </div>

                    <div class="mt-4">
                        <p class="font-semibold text-lg">Pembayaran:</p>
                        <div class="inline-flex items-center gap-x-3">
                            <div
                                class="text-sm font-medium text-gray-800 dark:text-white"
                            >
                                Kode Pembayaran:
                            </div>
                            <span class="font-semibold text-blue-700">{{
                                code
                            }}</span>
                        </div>

                        <!-- Conditional Button -->
                        <div class="flex justify-end gap-4 mt-8" v-if="!hasPendingPayment">
                            <button @click="submitPayment">
                                <PrimaryButton>
                                    Lanjutkan Pembayaran
                                </PrimaryButton>
                            </button>
                        </div>
                        <div v-else>
                            <div class="flex justify-end gap-4 mt-8">
                            <Link
                                :href="route('form.payment')"
                                as="button"
                                type="button"
                            >
                                <PrimaryButton
                                    > Lanjutkan Pembayaran</PrimaryButton
                                >
                            </Link>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="shadow-md sm:shadow-lg p-4 sm:p-8">
                    <h3 class="font-semibold text-left text-black text-xl capitalize">
                        Catatan Sebelum melakukan pembayaran
                    </h3>

                    <div class="mt-4">
                        <ul
                            class="max-w-md space-y-1 text-gray-500 list-disc list-inside dark:text-gray-400"
                        >
                            <li>
                                Pastikan Anda memilih metode pembayaran yang
                                tepat sesuai dengan instruksi yang diberikan.
                            </li>
                            <li>
                                Jika Anda melakukan pembayaran melalui transfer
                                bank, pastikan untuk memasukkan kode pembayaran
                                yang tertera pada slip atau form pembayaran.
                            </li>
                            <li>
                                Pembayaran Anda akan diproses secara otomatis
                                setelah dikonfirmasi oleh sistem.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <h3 class="font-semibold text-left text-black text-xl capitalize">
                    Verifikasi Otomatis
                </h3>
                <p class="text-gray-800 dark:text-white">
                    Pembayaran Anda akan terverifikasi secara otomatis setelah
                    pembayaran.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Swal from "sweetalert2";

// Props
const props = defineProps({
    wave: Object,
    amount: Number,
    code: String,
});

const hasPendingPayment = ref(false);

const checkPaymentStatus = async () => {
    try {
        const response = await axios.get(route("form.payment.status"));
        if (response.status === 200 && response.data.redirect === true) {
            hasPendingPayment.value = true;
        }
    } catch (error) {
        console.error("Error checking payment status:", error);
    }
};

const submitPayment = async () => {
    try {
        const response = await axios.post(route("form.payment.store"), {
            amount: props.amount,
            code: props.code,
        });

        if (response.data.success) {
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: response.data.message,
                confirmButtonText: "OK",
                background: "#fff",
                color: "#000",
                confirmButtonColor: "#1D4ED8",
            }).then(() => {
                window.location.href = route("form.payment");
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Gagal",
                text: "Gagal melakukan pembayaran. Silakan coba lagi.",
                confirmButtonText: "OK",
                background: "#fff",
                color: "#000",
                confirmButtonColor: "#DC2626",
            });
        }
    } catch (error) {
        console.error("Error submitting payment:", error);
    }
};

onMounted(() => {
    checkPaymentStatus();   
});
</script>
