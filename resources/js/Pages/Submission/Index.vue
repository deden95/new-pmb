<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, Link, usePage } from "@inertiajs/vue3";

// Partials
import ChooseStudyProgram from "./Partials/ChooseStudyProgram.vue";

import Guide from "./Partials/Guide.vue";
import Submitted from "./Partials/Submitted.vue";
import ApprovedForm from "./Partials/ApprovedForm.vue";
import Determination from "./Partials/Determination.vue";

defineProps({
    form: {
        default: null,
        type: Object,
    },
    percent: Object,
});
</script>

<template>
    <Head title="Pendaftaran" />
    <AuthenticatedLayout>
        <div class="w-full">
            <!-- Pilih Program Studi dan Gelombang -->
            <ChooseStudyProgram v-if="!form.prodi && !form.wave" />

            <!-- Pembayaran, ditampilkan hanya jika status formulir sudah ada, dan pengguna belum membayar -->
     

            <!-- Panduan setelah pembayaran atau status tertentu -->
            <Guide
                v-else-if="form.status && (form.status == 'waiting' || form.status == 'rejected') "
                :wave="form.wave"
                :percent="percent"
                :status="form.status"
                :note="form.note"
                :is_paid="form.is_paid_registration"
            />

            <!-- Form yang sudah diajukan -->
            <Submitted v-else-if="form.status == 'submitted'" :wave="form.wave" />

            <!-- Formulir disetujui, tapi menunggu proses akhir -->
            <ApprovedForm v-else-if="form.status == 'approved' && form.end_status == 'pending'" :form="form" />

            <!-- Penentuan akhirnya, jika status selesai -->
            <Determination v-else-if="form.end_status !== 'pending'" :form="form" />
        </div>
    </AuthenticatedLayout>
</template>
