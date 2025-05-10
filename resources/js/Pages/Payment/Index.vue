<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";
import MakePayment from "./Partials/MakePayment.vue";

// Mendefinisikan props
defineProps({
    form: {
        type: Object,
        default: () => null, // Pastikan null jika tidak ada data
    },
    percent: Object, // Percent bisa dihapus jika tidak digunakan
    payment_id: Number,
});
</script>

<template>
    <Head title="Payment" />

    <AuthenticatedLayout>
        <div class="flex flex-col gap-3">
            <!-- Render komponen MakePayment hanya jika form ada dan kondisi status dan is_paid_registration sesuai -->
            <MakePayment
                v-if="form && form.status && !form.is_paid_registration"
                :wave="form.wave" 
                :amount="form.wave.price_reg" 
                :code="form.code"     
                :payment-id="payment_id"                       
              
            />
        </div>
    </AuthenticatedLayout>
</template>
