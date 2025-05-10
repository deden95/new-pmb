<template>
    <Head title="Invoice" />
    <AuthenticatedLayout>
      <div class="bg-gray-100 min-h-screen py-10">
        <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-8">
          <div class="border-b pb-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Invoice Pembayaran</h1>
            <p class="text-gray-600">Berikut adalah detail tagihan Anda.</p>
          </div>
  
          <div class="space-y-4">
            <div class="flex justify-between">
              <span class="text-gray-600">Nama Pemilik Akun:</span>
              <span class="font-semibold text-gray-800">{{ payment.account_name }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Nomor Telepon:</span>
              <span class="font-semibold text-gray-800">{{ payment.account_number }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Tanggal Pembayaran:</span>
              <span class="font-semibold text-gray-800">{{ payment.date }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Kode Pembayaran:</span>
              <span class="font-semibold text-blue-600">{{ payment.code }}</span>
            </div>
            <div class="flex justify-between border-t pt-4">
              <span class="text-lg font-semibold text-gray-800">Total:</span>
              <span class="text-lg font-bold text-blue-600">Rp {{ payment.amount.toLocaleString() }}</span>
            </div>
          </div>
  
          <div class="mt-8 text-center">
            <button
              id="payment-button"
              class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold shadow-md"
              @click="handlePayment(token)"
            >
              Bayar Sekarang
            </button>
          </div>
  
          <div class="mt-6 text-sm text-gray-600 text-center">
            <p>Pastikan Anda menyelesaikan pembayaran sebelum tanggal jatuh tempo.</p>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { Head } from "@inertiajs/vue3";
  import Swal from "sweetalert2";
  
  // Props diterima dari backend
  defineProps({
    token: String, // Snap token untuk Midtrans
    payment: Object, // Data pembayaran
    transaction: Object, // Data transaksi jika diperlukan
  });  

  function handlePayment(token) {
  window.snap.pay(token, {
    onSuccess: (result) => {
      console.log(result);
      // Langsung arahkan ke halaman tanpa tombol konfirmasi
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
  