<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <Head title="Login | PMB System" />
    
    <!-- Main Card Container -->
    <div class="w-full max-w-md">
      <!-- Logo Header -->
      <div class="text-center mb-8">
        <ApplicationLogo class="mx-auto w-24 h-24 flex items-center justify-center mb-4"/>          
        <h1 class="text-3xl font-bold text-gray-800 mb-1">PMB Login</h1>
        <p class="text-gray-600">Penerimaan Mahasiswa Baru</p>
        <p class="text-gray-500 text-sm mt-1">{{ $page.props.web_settings.institution_name }}</p>
      </div>

      <!-- Login Form Card -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
          <h2 class="text-lg font-semibold text-center text-white">Masuk ke Akun Anda</h2>
        </div>

        <!-- Form Content -->
        <div class="px-8 py-6">
          <form @submit.prevent="submit" class="space-y-5">
            <!-- Email Field -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                  </svg>
                </div>
                <input
                  v-model="form.email"
                  type="email"
                  required
                  autofocus
                  class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md transition duration-150"
                  placeholder="email@example.com"
                >
              </div>
              <InputError class="mt-2" :message="form.errors.email" />
            </div>          

            <!-- Password Field -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input
                  v-model="form.password"
                  type="password"
                  required
                  class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md transition duration-150"
                  placeholder="••••••••"
                >
              </div>
              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input
                  v-model="form.remember"
                  id="remember-me"
                  name="remember-me"
                  type="checkbox"
                  class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                >
                <label for="remember-me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
              </div>

              <div class="text-sm">
                <Link
                  :href="route('password.request')"
                  class="font-medium text-blue-600 hover:text-blue-500"
                >
                  Lupa password?
                </Link>
              </div>
            </div>

            <!-- Submit Button -->
            <div>
              <button
                type="submit"
                :disabled="form.processing"
                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
              >
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                  <svg
                    class="h-5 w-5 text-blue-300 group-hover:text-blue-200 transition"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20"
                    fill="currentColor"
                    aria-hidden="true"
                  >
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </span>
                <span v-if="!form.processing">Masuk</span>
                <span v-else class="flex items-center justify-center">
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Memproses...
                </span>
              </button>
            </div>
          </form>

          <div class="mt-6">
            <div class="relative">
              <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
              </div>
              <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">Belum punya akun?</span>
              </div>
            </div>

            <div class="mt-6">
              <Link
                :href="route('register')"
                class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition"
              >
                Daftar sebagai mahasiswa baru
              </Link>
            </div>
          </div>
        </div>
      </div>

      <!-- Footer Links -->
      <div class="mt-8 text-center text-sm text-gray-500">
        <Link :href="route('welcome')" class="hover:text-gray-700">Kembali ke beranda</Link>
        <span class="mx-2">•</span>
        <Link href="#" class="hover:text-gray-700">Bantuan</Link>
        <span class="mx-2">•</span>
        <Link href="#" class="hover:text-gray-700">Kontak</Link>
      </div>
    </div>
  </div>
</template>

<style>
/* Custom animations */
.transition {
  transition-property: background-color, border-color, color, fill, stroke, opacity, box-shadow, transform;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Focus styles */
.focus\:ring-2:focus {
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
}

/* Animation for the spinner */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}
.animate-spin {
  animation: spin 1s linear infinite;
}

/* Hover effects */
.hover\:bg-blue-700:hover {
  background-color: #1d4ed8;
}
</style>