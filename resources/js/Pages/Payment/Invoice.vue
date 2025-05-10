<template>
  <Head title="Invoice" />
  <AuthenticatedLayout>
    <div class="bg-gray-50 min-h-screen py-10 px-4">
      <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-5 mb-6 flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-800">🧾 Invoice Pembayaran</h1>
            <p class="text-gray-500 text-sm">Berikut adalah rincian tagihan Anda.</p>
          </div>
          <span class="text-sm text-gray-400">{{ payment.date }}</span>
        </div>

        <!-- Invoice details -->
        <div class="grid grid-cols-1 gap-4 text-sm text-gray-700">
          <div class="flex justify-between items-center">
            <span class="text-gray-500">👤 Nama Pemilik Akun:</span>
            <span class="font-medium">{{ payment.account_name }}</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-gray-500">📞 Nomor Telepon:</span>
            <span class="font-medium">{{ payment.account_number }}</span>
          </div>
          <div class="flex justify-between items-center">
            <span class="text-gray-500">🧾 Kode Pembayaran:</span>
            <span class="font-semibold text-blue-600">{{ payment.code }}</span>
          </div>
        </div>

        <!-- Divider -->
        <div class="my-6 border-t border-dashed border-gray-300"></div>

        <!-- Total -->
        <div class="flex justify-between items-center text-lg">
          <span class="font-semibold text-gray-700">Total Pembayaran</span>
          <span class="font-bold text-blue-700">Rp {{ payment.amount.toLocaleString() }}</span>
        </div>

        <!-- Action Button -->
        <div class="mt-8">
          <button
            id="payment-button"
            class="w-full bg-blue-600 hover:bg-blue-700 transition-all duration-200 text-white py-3 rounded-xl font-semibold shadow-md"
            @click="handlePayment(token)"
          >
            💳 Bayar Sekarang
          </button>
        </div>

        <!-- Note -->
        <div class="mt-6 text-center text-xs text-gray-500">
          Pastikan Anda menyelesaikan pembayaran sebelum tanggal jatuh tempo.
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { Head } from "@inertiajs/vue3";
  import Swal from "sweetalert2";
  
  defineProps({
    token: String,
    payment: Object, 
    transaction: Object, 
  });  

  function handlePayment(token) {
  window.snap.pay(token, {
    onSuccess: (result) => {
      console.log(result);
      window.location.href = route("form.submission");
    },
    onPending: (result) => {
      console.log(result);
      Swal.fire({
        title: "Pending",
        text: "Waiting for your payment!",
        icon: "warning",
        confirmButtonText: "Close",
      });
    },
    onError: (result) => {
      console.log(result);
      Swal.fire({
        title: "Error",
        text: "Payment failed!",
        icon: "error",
        confirmButtonText: "Close",
      });
    },
    onClose: () => {
      Swal.fire({
        title: "Info",
        text: "You closed the popup without finishing the payment.",
        icon: "info",
        confirmButtonText: "Close",
      });
    },
  });
}

  </script>
  