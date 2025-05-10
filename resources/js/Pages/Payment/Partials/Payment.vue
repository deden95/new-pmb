<template>
    <Head title="Data Pembayaran" />
  
    <AuthenticatedLayout>
      <div class="max-w-7xl mx-auto bg-white shadow-md sm:shadow-lg p-4 sm:p-8">
        <div class="flex flex-col sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-4">
          <header class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            Data Pembayaran
          </header>
        </div>
  
        <div class="relative overflow-x-auto">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3">Bank</th>
                <th scope="col" class="px-6 py-3">Nama</th>
                <th scope="col" class="px-6 py-3">Nomor Hp</th>
                <th scope="col" class="px-6 py-3">Jumlah</th>
                <th scope="col" class="px-6 py-3">Tanggal</th>
                <th scope="col" class="px-6 py-3">Jenis</th>
                <th scope="col" class="px-6 py-3">Status</th>
                <th scope="col" class="px-6 py-3">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="item in payment"
                :key="item.id"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
              >
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{ item.bank }}
                </th>
                <td class="px-6 py-4 truncate">{{ item.account_name }}</td>
                <td class="px-6 py-4">{{ item.account_number }}</td>
                <td class="px-6 py-4">
                  {{
                    item.amount === "-"
                      ? "-"
                      : new Intl.NumberFormat("id-ID", {
                          style: "currency",
                          currency: "IDR",
                          minimumFractionDigits: 0,
                          maximumFractionDigits: 0,
                        }).format(item.amount)
                  }}
                </td>
                <td class="px-6 py-4 truncate">{{ item.date }}</td>
                <td class="px-6 py-4 truncate">
                  <span v-if="item.type_payment !== '-'">
                    {{ item.type_payment === "form" ? "Formulir" : "Pendaftaran" }}
                  </span>
                  <span v-else>-</span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center justify-center">
                    <i
                      v-if="item.status !== '-'"
                      class="fas fa-circle"
                      :class="{
                        'text-green-500': item.status === 'approved',
                        'text-yellow-500': item.status === 'pending',
                        'text-red-500': item.status === 'rejected',
                      }"
                    ></i>
                    <span v-else>-</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div v-if="item.bank !== '-'" class="flex gap-2">
                    <!-- Tombol menuju halaman Invoice -->
                    <button
                      v-if="item.status === 'pending'"
                      @click="redirectToInvoice(item.id)"
                      class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                    >
                      Lihat Invoice
                    </button>
                  </div>
                  <span v-else>-</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { defineProps } from "vue";
  import { Head, router } from "@inertiajs/vue3";
  
  // Menerima props dari backend
  defineProps({
    payment: Object,
  });
  
  // Fungsi untuk redirect ke halaman Invoice
  function redirectToInvoice(paymentId) {
    router.visit(`/payment/invoice/${paymentId}`);
  }
  </script>
  