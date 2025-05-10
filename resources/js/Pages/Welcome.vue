<script setup>
import { Head, Link } from "@inertiajs/vue3";
import HomeLayout from "@/Layouts/HomeLayout.vue";

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
});

const download = async (name) => {
  try {
    const response = await fetch(`/assets/img/${name}`);
    const blob = await response.blob();
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    link.href = url;
    link.setAttribute("download", name);
    document.body.appendChild(link);
    link.click();
  } catch (error) {
    console.error(error);
  }
};
</script>

<template>
  <Head>
    <title>Penerimaan Mahasiswa Baru {{ $page.props.web_settings.short_name }}</title>
    <meta name="description" content="Penerimaan Mahasiswa Baru {{ $page.props.web_settings.institution_name }}" />
    <link rel="icon" type="image/x-icon" href="/images/htp.ico" />
  </Head>

  <HomeLayout>
    <!-- Hero Section Modern -->
    <section class="relative min-h-screen flex items-center bg-gradient-to-br from-blue-900 to-indigo-800 overflow-hidden">
      <div class="absolute inset-0 bg-black opacity-30"></div>
      <div class="absolute top-0 right-0 w-full h-full overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute top-1/4 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-indigo-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>
      </div>
      
      <div class="container mx-auto px-6 lg:px-12 py-16 grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative z-10">
        <!-- Text Content -->
        <div class="text-white">
          <div class="inline-block px-4 py-2 bg-white bg-opacity-20 rounded-full mb-6">
            <span class="text-sm font-semibold">TAHUN AJARAN 2025/2026</span>
          </div>
          <h1 class="text-4xl md:text-6xl font-extrabold leading-tight mb-4">
            Raih Masa Depan Gemilang di <span class="text-yellow-400">{{ $page.props.web_settings.short_name }}</span>
          </h1>
          <p class="text-xl md:text-2xl font-light text-gray-200 mb-8">
            Bergabunglah dengan komunitas akademik yang inspiratif dan wujudkan impian Anda.
          </p>
          <div class="flex flex-wrap gap-4">
            <Link
              :href="route('register')"
              class="px-8 py-4 bg-yellow-500 hover:bg-yellow-600 text-gray-900 text-lg font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex items-center"
            >
              <i class="fa-solid fa-user-graduate mr-3"></i> Daftar Sekarang
            </Link>
            <a href="#program-studi" class="px-8 py-4 bg-transparent border-2 border-white text-white text-lg font-bold rounded-lg hover:bg-white hover:bg-opacity-10 transition-all duration-300">
              <i class="fa-solid fa-magnifying-glass mr-3"></i> Explore Program
            </a>
          </div>
          
          <div class="mt-12 flex items-center space-x-6">
            <div class="flex -space-x-2">
              <!-- <img class="w-10 h-10 rounded-full border-2 border-white" src="/images/students/student1.jpg" alt="Student">
              <img class="w-10 h-10 rounded-full border-2 border-white" src="/images/students/student2.jpg" alt="Student">
              <img class="w-10 h-10 rounded-full border-2 border-white" src="/images/students/student3.jpg" alt="Student"> -->
            </div>
            <div>
              <p class="text-gray-300">Bergabung dengan <span class="font-bold">500+</span> mahasiswa baru</p>
              <div class="flex items-center mt-1">
                <i class="fa-solid fa-star text-yellow-400 mr-1"></i>
                <span class="text-white font-medium">4.9/5.0</span>
                <span class="text-gray-300 ml-2">(1,024 reviews)</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Image -->
        <div class="hidden lg:block relative">
          <div class="absolute -top-10 -right-10 w-64 h-64 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-blob"></div>
          <div class="relative">
            <img
              class="w-full rounded-2xl shadow-2xl border-8 border-white transform rotate-2 hover:rotate-0 transition-transform duration-500"
              src="/images/coverpmb.png"
              alt="Penerimaan Mahasiswa Baru"
            />
            <div class="absolute -bottom-8 -left-8 bg-white p-4 rounded-xl shadow-lg">
              <div class="text-blue-900 font-bold text-lg">Pendaftaran Dibuka!</div>
              <div class="text-gray-600 text-sm">Gelombang I hingga gelombang 3</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- University Stats -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-center">
            <div class="text-4xl font-bold text-blue-900 mb-2">50+</div>
            <div class="text-gray-600 font-medium">Program Studi</div>
          </div>
          <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-center">
            <div class="text-4xl font-bold text-blue-900 mb-2">98%</div>
            <div class="text-gray-600 font-medium">Tingkat Kelulusan</div>
          </div>
          <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-center">
            <div class="text-4xl font-bold text-blue-900 mb-2">500+</div>
            <div class="text-gray-600 font-medium">Dosen Berpengalaman</div>
          </div>
          <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 text-center">
            <div class="text-4xl font-bold text-blue-900 mb-2">#1</div>
            <div class="text-gray-600 font-medium">Peringkat Nasional</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Program Studi Section -->
    <section id="program-studi" class="py-20 bg-gray-50">
      <div class="container mx-auto px-6 lg:px-12">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Program Studi Unggulan</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Temukan program studi yang sesuai dengan passion dan bakat Anda
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
          <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="h-48 bg-blue-600 flex items-center justify-center">
              <i class="fa-solid fa-laptop-code text-white text-6xl"></i>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-2">Ilmu Pemerintahan</h3>
              <p class="text-gray-600 mb-4">Akreditasi B | Gelar S.IP</p>
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-blue-600">Quota Pendaftaran Dibuka</span>
                <Link :href="route('register')" class="text-blue-600 hover:text-blue-800 font-medium">
                  Daftar <i class="fa-solid fa-arrow-right ml-1"></i>
                </Link>
              </div>
            </div>
          </div>
          
          <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="h-48 bg-green-600 flex items-center justify-center">
              <i class="fa-solid fa-briefcase-medical text-white text-6xl"></i>
            </div>
            <div class="p-6">
              <h3 class="text-xl font-bold text-gray-900 mb-2">Ilmu Pemerintahan</h3>
              <p class="text-gray-600 mb-4">Akreditasi B | Gelar S.I.Kom</p>
              <div class="flex justify-between items-center">
                <span class="text-sm font-medium text-green-600">Quota Pendaftaran Dibuka</span>
                <Link :href="route('register')" class="text-green-600 hover:text-green-800 font-medium">
                  Daftar <i class="fa-solid fa-arrow-right ml-1"></i>
                </Link>
              </div>
            </div>
          </div>          

        </div>
        
        <div class="text-center mt-12">
          <Link 
            :href="route('register')" 
            class="inline-block px-8 py-3 bg-gray-900 text-white font-bold rounded-lg hover:bg-gray-800 transition-colors duration-300"
          >
            Lihat Semua Program Studi <i class="fa-solid fa-arrow-right ml-2"></i>
          </Link>
        </div>
      </div>
    </section>

    <!-- Panduan Section Modern --> 
    <section class="py-20 bg-white" id="alur-pendaftaran">
      <div class="container mx-auto px-6 lg:px-12">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Proses Pendaftaran Mudah</h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Hanya 4 langkah sederhana untuk menjadi bagian dari {{ $page.props.web_settings.short_name }}
          </p>
        </div>
        
        <div class="relative">
          <!-- Timeline Bar -->
          <div class="hidden md:block absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 h-2 w-full bg-gray-200"></div>
          
          <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
            <!-- Langkah 1 -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 relative md:text-center">
              <div class="absolute -top-6 -left-6 md:left-1/2 md:-translate-x-1/2 md:-top-10 w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-md">
                1
              </div>
              <div class="md:mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Buat Akun</h3>
                <p class="text-gray-600">
                  Daftar akun PMB dengan email dan data pribadi Anda.
                </p>
                <div class="mt-4">
                  <i class="fa-solid fa-user-plus text-blue-500 text-2xl"></i>
                </div>
              </div>
            </div>
            
            <!-- Langkah 2 -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 relative md:text-center">
              <div class="absolute -top-6 -left-6 md:left-1/2 md:-translate-x-1/2 md:-top-10 w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-md">
                2
              </div>
              <div class="md:mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Pilih Program</h3>
                <p class="text-gray-600">
                  Pilih program studi dan lengkapi formulir pendaftaran.
                </p>
                <div class="mt-4">
                  <i class="fa-solid fa-list-check text-green-500 text-2xl"></i>
                </div>
              </div>
            </div>
            
            <!-- Langkah 3 -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 relative md:text-center">
              <div class="absolute -top-6 -left-6 md:left-1/2 md:-translate-x-1/2 md:-top-10 w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-md">
                3
              </div>
              <div class="md:mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Upload Dokumen</h3>
                <p class="text-gray-600">
                  Upload dokumen persyaratan dan lakukan pembayaran.
                </p>
                <div class="mt-4">
                  <i class="fa-solid fa-file-upload text-yellow-500 text-2xl"></i>
                </div>
              </div>
            </div>
            
            <!-- Langkah 4 -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 relative md:text-center">
              <div class="absolute -top-6 -left-6 md:left-1/2 md:-translate-x-1/2 md:-top-10 w-12 h-12 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-md">
                4
              </div>
              <div class="md:mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-3">Pengumuman</h3>
                <p class="text-gray-600">
                  Cek hasil seleksi dan lakukan registrasi ulang.
                </p>
                <div class="mt-4">
                  <i class="fa-solid fa-trophy text-purple-500 text-2xl"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimoni Section -->
    <!-- <section class="py-20 bg-gray-900 text-white">
      <div class="container mx-auto px-6 lg:px-12">
        <div class="text-center mb-16">
          <h2 class="text-3xl md:text-4xl font-extrabold mb-4">Apa Kata Mereka?</h2>
          <p class="text-xl text-gray-300 max-w-3xl mx-auto">
            Testimoni dari mahasiswa yang telah bergabung dengan kami
          </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="bg-gray-800 p-8 rounded-xl">
            <div class="flex items-center mb-4">
              <img src="/images/testimoni/testi1.jpg" alt="Student" class="w-12 h-12 rounded-full mr-4">
              <div>
                <h4 class="font-bold">Rina Anggraeni</h4>
                <p class="text-gray-400 text-sm">Teknik Informatika, 2023</p>
              </div>
            </div>
            <p class="text-gray-300 italic">
              "Proses pendaftaran sangat mudah dan cepat. Dosen-dosen sangat kompeten dan fasilitas kampus lengkap."
            </p>
            <div class="mt-4 text-yellow-400">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
            </div>
          </div>
          
          <div class="bg-gray-800 p-8 rounded-xl">
            <div class="flex items-center mb-4">
              <img src="/images/testimoni/testi2.jpg" alt="Student" class="w-12 h-12 rounded-full mr-4">
              <div>
                <h4 class="font-bold">Andi Pratama</h4>
                <p class="text-gray-400 text-sm">Kedokteran, 2022</p>
              </div>
            </div>
            <p class="text-gray-300 italic">
              "Kurikulum yang up-to-date dan metode pembelajaran yang interaktif membuat saya cepat memahami materi."
            </p>
            <div class="mt-4 text-yellow-400">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star-half-stroke"></i>
            </div>
          </div>
          
          <div class="bg-gray-800 p-8 rounded-xl">
            <div class="flex items-center mb-4">
              <img src="/images/testimoni/testi3.jpg" alt="Student" class="w-12 h-12 rounded-full mr-4">
              <div>
                <h4 class="font-bold">Siti Nurhaliza</h4>
                <p class="text-gray-400 text-sm">Hukum, 2024</p>
              </div>
            </div>
            <p class="text-gray-300 italic">
              "Lingkungan kampus yang nyaman dan komunitas yang suportif membantu saya berkembang dengan optimal."
            </p>
            <div class="mt-4 text-yellow-400">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
            </div>
          </div>
        </div>
      </div>
    </section> -->

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-600 to-indigo-700 text-white">
      <div class="container mx-auto px-6 lg:px-12 text-center">
        <h2 class="text-3xl md:text-4xl font-extrabold mb-6">Siap Memulai Perjalanan Akademik Anda?</h2>
        <p class="text-xl mb-8 max-w-3xl mx-auto">
          Daftar sekarang dan dapatkan kesempatan beasiswa hingga 50% untuk pendaftar gelombang pertama.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
          <Link
            :href="route('register')"
            class="px-8 py-4 bg-yellow-500 hover:bg-yellow-600 text-gray-900 text-lg font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1"
          >
            <i class="fa-solid fa-user-graduate mr-3"></i> Daftar Sekarang
          </Link>
          <a
            :href="`https://wa.me/${$page.props.web_settings.contact_whatsapp}`"
            class="px-8 py-4 bg-white hover:bg-gray-100 text-blue-900 text-lg font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300"
          >
            <i class="fa-brands fa-whatsapp mr-3"></i> Konsultasi via WhatsApp
          </a>
        </div>
      </div>
    </section>

    <!-- Info Section Modern -->
    <section class="py-20 bg-gray-50">
      <div class="container mx-auto px-6 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <!-- Pertanyaan -->
          <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">
              Butuh Bantuan?
            </h3>
            <p class="text-gray-600 mb-6">
              Tim PMB kami siap membantu Anda dari Senin-Jumat, pukul 08.00-16.00 WIB.
            </p>
            <div class="space-y-4">
              <div class="flex items-start">
                <div class="bg-blue-100 p-3 rounded-full mr-4">
                  <i class="fa-solid fa-phone text-blue-600"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900">Telepon</h4>
                  <a href="tel:+62215567890" class="text-blue-600 hover:underline">{{ $page.props.web_settings.contact_whatsapp }}</a>
                </div>
              </div>
              <div class="flex items-start">
                <div class="bg-green-100 p-3 rounded-full mr-4">
                  <i class="fa-brands fa-whatsapp text-green-600"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900">WhatsApp</h4>
                  <a :href="`https://wa.me/${$page.props.web_settings.contact_whatsapp}`" class="text-green-600 hover:underline">{{ $page.props.web_settings.contact_whatsapp }}</a>
                </div>
              </div>
              <div class="flex items-start">
                <div class="bg-red-100 p-3 rounded-full mr-4">
                  <i class="fa-solid fa-envelope text-red-600"></i>
                </div>
                <div>
                  <h4 class="font-semibold text-gray-900">Email</h4>
                  <a href="mailto:pmb@univ.ac.id" class="text-red-600 hover:underline">{{ $page.props.web_settings.contact_email}}</a>
                </div>
              </div>
            </div>
          </div>

          <!-- Brosur -->
          <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Download Brosur</h3>
            <p class="text-gray-600 mb-6">
              Dapatkan informasi lengkap tentang program studi, biaya pendidikan, dan fasilitas kampus.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <button
                @click="download('brosur.jpg')"
                class="flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-lg border border-blue-200 transition-colors duration-300"
              >
                <div class="flex items-center">
                  <div class="bg-blue-100 p-3 rounded-full mr-4">
                    <i class="fa-solid fa-file-pdf text-blue-600"></i>
                  </div>
                  <div>
                    <h4 class="font-semibold text-gray-900">Brosur PMB</h4>
                    <p class="text-sm text-gray-500">PDF, 2.4 MB</p>
                  </div>
                </div>
                <i class="fa-solid fa-download text-blue-600"></i>
              </button>
              <button
                @click="download('rincian-biaya.jpg')"
                class="flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-lg border border-green-200 transition-colors duration-300"
              >
                <div class="flex items-center">
                  <div class="bg-green-100 p-3 rounded-full mr-4">
                    <i class="fa-solid fa-file-excel text-green-600"></i>
                  </div>
                  <div>
                    <h4 class="font-semibold text-gray-900">Rincian Biaya</h4>
                    <p class="text-sm text-gray-500">XLS, 1.8 MB</p>
                  </div>
                </div>
                <i class="fa-solid fa-download text-green-600"></i>
              </button>
              <!-- <button
                @click="download('jadwal.jpg')"
                class="flex items-center justify-between p-4 bg-purple-50 hover:bg-purple-100 rounded-lg border border-purple-200 transition-colors duration-300"
              >
                <div class="flex items-center">
                  <div class="bg-purple-100 p-3 rounded-full mr-4">
                    <i class="fa-solid fa-calendar-days text-purple-600"></i>
                  </div>
                  <div>
                    <h4 class="font-semibold text-gray-900">Jadwal PMB</h4>
                    <p class="text-sm text-gray-500">PDF, 1.2 MB</p>
                  </div>
                </div>
                <i class="fa-solid fa-download text-purple-600"></i>
              </button>
              <button
                @click="download('beasiswa.jpg')"
                class="flex items-center justify-between p-4 bg-yellow-50 hover:bg-yellow-100 rounded-lg border border-yellow-200 transition-colors duration-300"
              >
                <div class="flex items-center">
                  <div class="bg-yellow-100 p-3 rounded-full mr-4">
                    <i class="fa-solid fa-award text-yellow-600"></i>
                  </div>
                  <div>
                    <h4 class="font-semibold text-gray-900">Info Beasiswa</h4>
                    <p class="text-sm text-gray-500">PDF, 1.5 MB</p>
                  </div>
                </div>
                <i class="fa-solid fa-download text-yellow-600"></i>
              </button> -->
            </div>
          </div>
        </div>
      </div>
    </section>

  </HomeLayout>
</template>

<style>
@keyframes blob {
  0% {
    transform: translate(0px, 0px) scale(1);
  }
  33% {
    transform: translate(30px, -50px) scale(1.1);
  }
  66% {
    transform: translate(-20px, 20px) scale(0.9);
  }
  100% {
    transform: translate(0px, 0px) scale(1);
  }
}

.animate-blob {
  animation: blob 7s infinite;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}

.text-gradient {
  background: linear-gradient(90deg, #f6d365 0%, #fda085 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

/* FAQ Animation */
.faq-content {
  transition: all 0.3s ease;
}

.faq-toggle.active .fa-plus {
  display: none;
}

.faq-toggle.active .fa-minus {
  display: block;
}

.faq-toggle .fa-minus {
  display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const faqToggles = document.querySelectorAll('.faq-toggle');
  
  faqToggles.forEach(toggle => {
    toggle.addEventListener('click', function() {
      this.classList.toggle('active');
      const content = this.nextElementSibling;
      const icon = this.querySelector('i');
      
      if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.replace('fa-plus', 'fa-minus');
      } else {
        content.classList.add('hidden');
        icon.classList.replace('fa-minus', 'fa-plus');
      }
    });
  });
});
</script>