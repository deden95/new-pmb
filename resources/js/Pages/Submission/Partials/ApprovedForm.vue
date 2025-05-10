<template>
  <Container>
    <!-- Card untuk Pendaftaran -->
    <Card
      title="Pendaftaran"
      :description="`Data anda sudah di finalisasi pada pendaftaran tahun ajaran ${form.wave.tahun_akademik}, silahkan melanjutkan ke tahap selanjutnya.`"
    >
      <div class="grid grid-cols-3 gap-2">
        <!-- Foto -->
        <div class="col-span-3 md:col-span-1 flex justify-center">
          <img :src="form.foto" alt="Foto" class="w-60 h-80 rounded-lg" />
        </div>

        <!-- Informasi Pendaftaran -->
        <div class="col-span-3 md:col-span-2 flex flex-col gap-4">
          <div class="font-bold text-lg text-gray-500 dark:text-gray-300">
            No Ujian: <span>{{ form.no_exam }}</span>
          </div>
          <div class="font-bold text-lg text-gray-500 dark:text-gray-300">
            <div>Nama: <span>{{ form.name }}</span></div>
            <div>NISN: <span>{{ form.education_number }}</span></div>
          </div>
          <div class="font-bold text-lg text-gray-500 dark:text-gray-300">
            Tempat, Tanggal Lahir: 
            <span>{{ form.birth_place_city }}, {{ formatDate(form.birth_date) }}</span>
          </div>
          <div class="font-bold text-lg text-gray-500 dark:text-gray-300">
            Pilihan Program Studi: <span>{{ form.prodi }}</span>
          </div>
          <div class="font-bold text-lg text-gray-500 dark:text-gray-300">
            Gelombang: <span>{{ form.wave.code }}</span>
          </div>
          <div class="font-bold text-lg text-gray-500 dark:text-gray-300">
            Tanggal Tes: <span>{{ formatDate(form.wave.tes_tulis) }}</span>
          </div>
          <div>
            <PrimaryButton @click="print">Cetak Kartu Tes</PrimaryButton>
          </div>
        </div>
      </div>
    </Card>

    <!-- Card untuk Tahap Selanjutnya -->
    <Card title="Tahap Selanjutnya" description="Silahkan melanjutkan ke tahap selanjutnya.">
      <ol class="relative border-s border-gray-200 dark:border-gray-700">
        <!-- Tes Pengetahuan -->
        <li v-if="$page.props.auth.exams.knowledge" class="mb-10 ms-4">
          <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700" />
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tes Pengetahuan</h3>
          <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
            Tes pengetahuan akan dilaksanakan secara online dengan waktu yang telah ditentukan. Silahkan melanjutkan ke menu
            <Link :href="route('exams.knowledge')" class="text-blue-600 hover:underline">Tes Pengetahuan</Link>.
          </p>
        </li>

        <!-- Tes Kesehatan -->
        <li v-if="$page.props.auth.exams.health" class="mb-10 ms-4">
          <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700" />
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tes Kesehatan</h3>
          <p class="text-base font-normal text-gray-500 dark:text-gray-400">
            Tes kesehatan akan dilaksanakan secara online, isi semua form yang ada di menu
            <Link class="text-blue-600 hover:underline" :href="route('exams.health')">Tes Kesehatan</Link>.
          </p>
        </li>

        <!-- Wawancara -->
        <li v-if="$page.props.auth.exams.interview" class="mb-10 ms-4">
          <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700" />
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Wawancara</h3>
          <p class="text-base font-normal text-gray-500 dark:text-gray-800">
            Wawancara akan dilaksanakan secara online, silahkan melanjutkan ke menu
            <Link class="text-blue-600 hover:underline" :href="route('exams.interview')">wawancara</Link>.
          </p>
        </li>

        <!-- Akhir -->
        <li class="mb-10 ms-4">
          <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700" />
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Akhir</h3>
          <p class="text-base font-normal text-gray-500 dark:text-gray-800">
            Jika sudah mengikuti semua tes, silahkan mengajukan pengumpulan formulir di tombol dibawah.
          </p>
        </li>
      </ol>

      <div class="flex justify-end mt-4">
        <PrimaryButton @click="useForm({}).post(route('form.submission.final'))">Ajukan Pengumpulan</PrimaryButton>
      </div>
    </Card>
  </Container>
</template>

<script setup>
import Card from "@/Components/Card.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Container from "@/Components/Container.vue";
import { Link, useForm } from "@inertiajs/vue3";

// Mendefinisikan props form yang diterima
defineProps({
  form: {
    default: null,
    type: Object,
  },
});

// Fungsi untuk memformat tanggal
function formatDate(date) {
  if (!date) return ""; // Pastikan tanggal ada
  const months = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
    "September", "Oktober", "November", "Desember"
  ];
  const [year, month, day] = date.split("-"); // Pisahkan tahun, bulan, dan hari
  return `${parseInt(day)} ${months[parseInt(month) - 1]} ${year}`; // Format tanggal
}
const print = async () => {
    try {
        const response = await fetch(route("form.print-kartu"), {
            method: "GET",
        });

        const pdfBlob = await response.blob();
        const url = window.URL.createObjectURL(pdfBlob);
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "kartu-tes.pdf");
        document.body.appendChild(link);
        link.click();
    } catch (error) {
        console.log(error);
    }
};
</script>