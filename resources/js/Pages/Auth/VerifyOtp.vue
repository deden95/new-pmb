<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const form = useForm({
  otp: '',
});

const submit = () => {
  form.post(route('verification.verify'), {
    onFinish: () => form.reset('otp'),
  });
};

const resendOtp = () => {
  form.post(route('verification.resend'));
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <Head title="Verifikasi OTP | PMB System" />
    
    <div class="w-full max-w-md">
      <!-- Logo Header -->
      <div class="text-center mb-8">
        <ApplicationLogo class="mx-auto w-24 h-24 flex items-center justify-center mb-4"/>      
        <p class="text-gray-500 text-sm mt-1">{{ $page.props.web_settings.institution_name }}</p>
      </div>

      <!-- OTP Form Card -->
      <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
          <h2 class="text-lg text-center font-semibold text-white">Verifikasi Nomor HP</h2>
        </div>

        <!-- Form Content -->
        <div class="px-8 py-6">
          <div class="mb-4 text-sm text-gray-600">
            Kami telah mengirim kode OTP ke nomor HP Anda. Silakan masukkan kode yang Anda terima.
          </div>

          <form @submit.prevent="submit" class="space-y-5">
            <!-- OTP Field -->
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Kode OTP</label>
              <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                  </svg>
                </div>
                <input
                  v-model="form.otp"
                  type="text"
                  inputmode="numeric"
                  pattern="[0-9]*"
                  maxlength="6"
                  required
                  autofocus
                  class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-md transition duration-150"
                  placeholder="123456"
                >
              </div>
              <InputError class="mt-1 text-sm text-red-600" :message="form.errors.otp" />
            </div>

            <!-- Submit Button -->
            <div>
              <button
                type="submit"
                :disabled="form.processing"
                class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200"
              >
                <span v-if="!form.processing">Verifikasi</span>
                <span v-else class="flex items-center justify-center">
                  <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Memverifikasi...
                </span>
              </button>
            </div>
          </form>

          <div class="mt-6 text-center text-sm">
            <button 
              @click="resendOtp"
              class="text-blue-600 hover:text-blue-500 focus:outline-none"
            >
              Tidak menerima kode? Kirim ulang OTP
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>