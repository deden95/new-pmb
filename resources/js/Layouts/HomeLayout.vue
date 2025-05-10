<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount } from "vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

// State untuk scroll dan mobile menu
const scrollY = ref(0);
const showingNavigationDropdown = ref(false);
const isLoading = ref(true);

// Handle scroll event
const handleScroll = () => {
  scrollY.value = window.scrollY;
};

// Lifecycle hooks
onMounted(() => {
  window.addEventListener("scroll", handleScroll);
  
  // Simulasikan loading selama 2 detik
  setTimeout(() => {
    isLoading.value = false;
  }, 2000);
});

onBeforeUnmount(() => {
  window.removeEventListener("scroll", handleScroll);
});
</script>

<template>
  <div class="flex flex-col min-h-screen bg-gray-50">
    <!-- Loading Overlay -->
    <div 
      v-if="isLoading"
      class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-500"
    >
      <div class="text-center">
        <!-- Animated Logo -->
        <div class="relative w-24 h-24 mx-auto mb-6">
          <div class="absolute inset-0 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>
          <ApplicationLogo class="w-full h-full p-4 text-blue-600" />
        </div>
        
        <!-- Loading Text -->
        <h3 class="text-xl font-bold text-gray-800 mb-2">
          {{ $page.props.web_settings.short_name }} 
        </h3>
        <p class="text-gray-600">Memuat sistem pendaftaran...</p>
        
        <!-- Progress Bar -->
        <div class="w-48 h-1.5 bg-gray-200 rounded-full overflow-hidden mt-4 mx-auto">
          <div 
            class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 animate-progress"
            style="width: 0%"
          ></div>
        </div>
      </div>
    </div>

    <!-- Modern Header -->
    <header 
      class="fixed w-full z-40 transition-all duration-500"
      :class="{
        'bg-white shadow-lg py-2': scrollY > 50,
        'bg-white/90 backdrop-blur-sm py-4': scrollY <= 50,
        'opacity-0': isLoading
      }"
    >
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
          <!-- Logo Section -->
          <div class="flex-shrink-0 flex items-center">
            <Link href="/" class="flex items-center group">
              <ApplicationLogo class="h-10 w-auto transition-transform group-hover:scale-105" />
              <span class="ml-3 text-xl font-bold text-gray-900 hidden sm:block">
                {{ $page.props.web_settings.short_name }}
                <span class="text-blue-600"></span>
              </span>
            </Link>
          </div>

          <!-- Desktop Navigation -->
          <nav class="hidden md:flex items-center space-x-8">
            <Link 
              href="/#program-studi" 
              class="text-gray-700 hover:text-blue-600 font-medium transition-colors flex items-center group"
            >
              <i class="fa-solid fa-graduation-cap mr-2 text-blue-500 group-hover:text-blue-600"></i>
              Program Studi
            </Link>
            <Link 
              href="/#alur-pendaftaran" 
              class="text-gray-700 hover:text-blue-600 font-medium transition-colors flex items-center group"
            >
              <i class="fa-solid fa-list-check mr-2 text-blue-500 group-hover:text-blue-600"></i>
              Alur Pendaftaran
            </Link>
            <Link 
              href="/#beasiswa" 
              class="text-gray-700 hover:text-blue-600 font-medium transition-colors flex items-center group"
            >
              <i class="fa-solid fa-award mr-2 text-blue-500 group-hover:text-blue-600"></i>
              Beasiswa
            </Link>
            <Link 
              href="/#faq" 
              class="text-gray-700 hover:text-blue-600 font-medium transition-colors flex items-center group"
            >
              <i class="fa-solid fa-circle-question mr-2 text-blue-500 group-hover:text-blue-600"></i>
              FAQ
            </Link>
            
            <div class="flex items-center space-x-4 ml-6">
              <Link
                v-if="!$page.props.auth.user"
                :href="route('login')"
                class="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors"
              >
                <i class="fa-solid fa-right-to-bracket mr-2"></i>
                Masuk
              </Link>
              <Link
                v-if="!$page.props.auth.user"
                :href="route('register')"
                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-full shadow-lg hover:shadow-xl transition-all hover:from-blue-700 hover:to-indigo-800 flex items-center"
              >
                <i class="fa-solid fa-user-plus mr-2"></i>
                Daftar Sekarang
              </Link>
              <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-full shadow-lg hover:shadow-xl transition-all hover:from-blue-700 hover:to-indigo-800 flex items-center"
              >
                <i class="fa-solid fa-gauge-high mr-2"></i>
                Dashboard
              </Link>
            </div>
          </nav>

          <!-- Mobile menu button -->
          <div class="md:hidden flex items-center">
            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-600 focus:outline-none transition-colors"
            >
              <i 
                class="fa-solid fa-bars text-xl"
                :class="{ 'hidden': showingNavigationDropdown, 'block': !showingNavigationDropdown }"
              ></i>
              <i 
                class="fa-solid fa-xmark text-xl"
                :class="{ 'hidden': !showingNavigationDropdown, 'block': showingNavigationDropdown }"
              ></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Navigation -->
      <div
        class="md:hidden transition-all duration-300 overflow-hidden bg-white"
        :class="{
          'max-h-0': !showingNavigationDropdown,
          'max-h-screen shadow-lg py-4': showingNavigationDropdown
        }"
      >
        <div class="container mx-auto px-4 sm:px-6">
          <div class="space-y-4">
            <ResponsiveNavLink 
              href="/#program-studi"
              @click="showingNavigationDropdown = false"
              class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors"
            >
              <i class="fa-solid fa-graduation-cap mr-3 text-blue-500"></i>
              Program Studi
            </ResponsiveNavLink>
            <ResponsiveNavLink 
              href="/#alur-pendaftaran"
              @click="showingNavigationDropdown = false"
              class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors"
            >
              <i class="fa-solid fa-list-check mr-3 text-blue-500"></i>
              Alur Pendaftaran
            </ResponsiveNavLink>
            <ResponsiveNavLink 
              href="/#beasiswa"
              @click="showingNavigationDropdown = false"
              class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors"
            >
              <i class="fa-solid fa-award mr-3 text-blue-500"></i>
              Beasiswa
            </ResponsiveNavLink>
            <ResponsiveNavLink 
              href="/#faq"
              @click="showingNavigationDropdown = false"
              class="block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors"
            >
              <i class="fa-solid fa-circle-question mr-3 text-blue-500"></i>
              FAQ
            </ResponsiveNavLink>
            
            <div class="pt-4 border-t border-gray-200">
              <div v-if="$page.props.auth.user" class="space-y-3">
                <ResponsiveNavLink 
                  :href="route('dashboard')"
                  class="block w-full px-4 py-3 text-center text-white bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg hover:from-blue-700 hover:to-indigo-800 font-medium"
                >
                  <i class="fa-solid fa-gauge-high mr-2"></i>
                  Dashboard
                </ResponsiveNavLink>
              </div>
              <div v-else class="grid grid-cols-2 gap-3">
                <ResponsiveNavLink 
                  :href="route('login')"
                  class="block w-full px-4 py-3 text-center text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50 font-medium"
                >
                  <i class="fa-solid fa-right-to-bracket mr-2"></i>
                  Masuk
                </ResponsiveNavLink>
                <ResponsiveNavLink 
                  :href="route('register')"
                  class="block w-full px-4 py-3 text-center text-white bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg hover:from-blue-700 hover:to-indigo-800 font-medium"
                >
                  <i class="fa-solid fa-user-plus mr-2"></i>
                  Daftar
                </ResponsiveNavLink>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main 
      class="flex-grow w-full pt-24 transition-opacity duration-500"
      :class="{
        'opacity-0': isLoading,
        'opacity-100': !isLoading
      }"
    >
      <slot />
    </main>

    <!-- Modern Footer -->
    <footer 
      class="bg-gray-900 text-white pt-16 pb-8 transition-opacity duration-500"
      :class="{
        'opacity-0': isLoading,
        'opacity-100': !isLoading
      }"
    >
      <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10">
          <!-- About Section -->
          <div class="md:col-span-4">
            <div class="flex items-center mb-6">
              <ApplicationLogo class="h-10 w-auto mr-3" />
              <h3 class="text-xl font-bold">
                {{ $page.props.web_settings.short_name }}
                <span class="text-blue-400"></span>
              </h3>
            </div>
            <p class="text-gray-400 mb-6">
              Sistem Penerimaan Mahasiswa Baru {{ $page.props.web_settings.institution_name }} Tahun Akademik 2025/2026.
            </p>
            <div class="space-y-3">
              <div class="flex items-start">
                <i class="fa-solid fa-location-dot text-blue-400 mt-1 mr-3"></i>
                <p class="text-gray-400">{{ $page.props.web_settings.contact_address }}</p>
              </div>
              <div class="flex items-center">
                <i class="fa-solid fa-envelope text-blue-400 mr-3"></i>
                <a :href="`mailto:${$page.props.web_settings.contact_email}`" class="text-gray-400 hover:text-white transition-colors">
                  {{ $page.props.web_settings.contact_email }}
                </a>
              </div>
              <div class="flex items-center">
                <i class="fa-solid fa-phone text-blue-400 mr-3"></i>
                <a :href="`tel:${$page.props.web_settings.contact_whatsapp}`" class="text-gray-400 hover:text-white transition-colors">
                  {{ $page.props.web_settings.contact_whatsapp }}
                </a>
              </div>
            </div>
          </div>

          <!-- Quick Links -->
          <div class="md:col-span-2">
            <h4 class="text-lg font-bold mb-6">Tautan Cepat</h4>
            <ul class="space-y-3">
              <li>
                <Link href="/#program-studi" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  Program Studi
                </Link>
              </li>
              <li>
                <Link href="/#alur-pendaftaran" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  Alur Pendaftaran
                </Link>
              </li>
              <li>
                <Link href="/#beasiswa" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  Beasiswa
                </Link>
              </li>
              <li>
                <Link href="/#faq" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  FAQ
                </Link>
              </li>
              <li>
                <Link :href="route('login')" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  Login
                </Link>
              </li>
            </ul>
          </div>

          <!-- Academic Systems -->
          <div class="md:col-span-3">
            <h4 class="text-lg font-bold mb-6">Sistem Akademik</h4>
            <ul class="space-y-3">
              <li>
                <a href="#" target="_blank" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  Sistem Informasi Akademik
                </a>
              </li>
              <li>
                <a href="#" target="_blank" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  Pendaftaran Mahasiswa Baru
                </a>
              </li>
              <li>
                <a href="#" target="_blank" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  Tracer Study
                </a>
              </li>
              <li>
                <a href="#" target="_blank" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  Survey Kepuasan
                </a>
              </li>
              <li>
                <a href="#" target="_blank" class="text-gray-400 hover:text-white transition-colors flex items-center">
                  <i class="fa-solid fa-chevron-right text-xs text-blue-400 mr-2"></i>
                  Perpustakaan Digital
                </a>
              </li>
            </ul>
          </div>

          <!-- Contact & Map -->
          <div class="md:col-span-3">
            <h4 class="text-lg font-bold mb-6">Lokasi Kampus</h4>
            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-lg">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126629.55794229299!2d107.05024036286089!3d-7.3343821974525945!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e687bb9215de647%3A0xd85887191fce72bf!2sSTISIP%20GUNA%20NUSANTARA!5e0!3m2!1sid!2sid!4v1736785358504!5m2!1sid!2sid"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                class="min-h-[200px]"
              ></iframe>
            </div>
            <div class="mt-4 flex space-x-4">
              <a 
                v-if="$page.props.web_settings.contact_facebook"
                :href="$page.props.web_settings.contact_facebook"
                target="_blank"
                class="w-10 h-10 flex items-center justify-center bg-gray-800 hover:bg-blue-600 rounded-full transition-colors"
              >
                <i class="fa-brands fa-facebook-f text-white"></i>
              </a>
              <a 
                v-if="$page.props.web_settings.contact_instagram"
                :href="$page.props.web_settings.contact_instagram"
                target="_blank"
                class="w-10 h-10 flex items-center justify-center bg-gray-800 hover:bg-pink-600 rounded-full transition-colors"
              >
                <i class="fa-brands fa-instagram text-white"></i>
              </a>
              <a 
                v-if="$page.props.web_settings.contact_youtube"
                :href="$page.props.web_settings.contact_youtube"
                target="_blank"
                class="w-10 h-10 flex items-center justify-center bg-gray-800 hover:bg-red-600 rounded-full transition-colors"
              >
                <i class="fa-brands fa-youtube text-white"></i>
              </a>
              <a 
                v-if="$page.props.web_settings.contact_twitter"
                :href="$page.props.web_settings.contact_twitter"
                target="_blank"
                class="w-10 h-10 flex items-center justify-center bg-gray-800 hover:bg-blue-400 rounded-full transition-colors"
              >
                <i class="fa-brands fa-twitter text-white"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-gray-800 mt-12 pt-8">
          <div class="flex flex-col md:flex-row justify-between items-center">
            <p class="text-gray-500 text-sm">
              <span v-html="$page.props.web_settings.footer" />
            </p>
            <div class="mt-4 md:mt-0">
              <Link 
                href="/privacy-policy" 
                class="text-gray-500 hover:text-white text-sm mr-4 transition-colors"
              >
                Kebijakan Privasi
              </Link>
              <Link 
                href="/terms" 
                class="text-gray-500 hover:text-white text-sm transition-colors"
              >
                Syarat & Ketentuan
              </Link>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<style scoped>
/* Smooth transitions */
.transition-all {
  transition-property: all;
}

.duration-300 {
  transition-duration: 300ms;
}

.duration-500 {
  transition-duration: 500ms;
}

/* Mobile menu animation */
.max-h-0 {
  max-height: 0;
}

.max-h-screen {
  max-height: 100vh;
}

/* Backdrop blur effect */
.backdrop-blur-sm {
  backdrop-filter: blur(4px);
}

/* Loading animation */
@keyframes spin {
  to { transform: rotate(360deg); }
}
.animate-spin {
  animation: spin 1s linear infinite;
}

@keyframes progress {
  0% { width: 0%; }
  100% { width: 100%; }
}
.animate-progress {
  animation: progress 2s ease-out forwards;
}
</style>