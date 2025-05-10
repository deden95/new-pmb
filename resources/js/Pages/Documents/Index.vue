<template>
    <Head title="Dashboard Admin" />
    <AuthenticatedLayout>
      <div class="col-12 mx-auto p-6">
        <div class="bg-white shadow-md rounded-lg p-6">
          <header class="flex flex-wrap justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Dokumen Pendaftaran</h2>
          </header>
  
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div
              v-for="(document, index) in form_type"
              :key="index"
              class="bg-gray-50 rounded-lg shadow p-4"
            >
              <header class="mb-4">
                <h3 class="text-lg font-medium text-gray-700 capitalize">
                  {{ document.replace("_", " ") }}
                </h3>
              </header>
  
              <button
                class="w-full h-40 rounded-lg overflow-hidden border border-dashed border-gray-300 hover:border-gray-400 focus:outline-none"
                @click="open(1, document)"
              >
                <img
                  v-if="$page.props[document]"
                  :src="$page.props[document]"
                  :alt="document"
                  class="object-cover w-full h-full"
                />
                <div
                  v-else
                  class="flex items-center justify-center h-full text-gray-500 text-sm"
                >
                  Belum ada {{ document.replace("_", " ") }} yang diunggah
                </div>
              </button>
            </div>
          </div>
  
          <p class="mt-6 text-sm text-gray-600">
            Untuk Ijazah, isi keterangan lulus. Jika belum ada, keduanya dapat dikosongkan.
          </p>
          <div class="flex justify-end mt-4 gap-4">
            <PrimaryButton  @click="goToForm">
                    Verifikasi
                </PrimaryButton>
                </div>
        </div>
  
        <!-- Modal -->
        <Modal :show="dialog" @close="close()">
                <div class="p-6">
                    <h2
                        class="text-lg font-semibold text-gray-900 dark:text-gray-100 capitalize"
                    >
                        Edit {{ dialogItem.replace("_", " ") }}
                    </h2>
                    <div class="mt-6 grid grid-cols-1 gap-4">
                        <div>
                            <InputLabel class="capitalize" for="name">{{
                                dialogItem.replace("_", " ")
                            }}</InputLabel>
                            <div
                                class="flex items-center justify-center w-full"
                            >
                                <label
                                    for="dropzone-file"
                                    class="flex flex-col items-center justify-center w-full h-auto border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600"
                                >
                                    <div
                                        class="flex flex-col items-center justify-center pt-5 pb-6"
                                        v-if="!url"
                                    >
                                        <i
                                            class="fa-solid fa-cloud-arrow-up text-lg"
                                        ></i>
                                        <p
                                            class="mb-2 text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            <span class="font-semibold"
                                                >Click to upload</span
                                            >
                                            or drag and drop
                                        </p>
                                        <p
                                            class="text-xs text-gray-500 dark:text-gray-400"
                                        >
                                            PNG, JPG (MAX. 800x400px)
                                        </p>
                                    </div>
                                    <div
                                        class="flex flex-col items-center justify-center pt-5 pb-6"
                                        v-else
                                    >
                                        <img
                                            :src="url"
                                            :alt="dialogItem"
                                            class="object-contain w-full h-full"
                                        />
                                    </div>
                                    <input
                                        id="dropzone-file"
                                        type="file"
                                        class="hidden"
                                        accept="image/*"
                                        @change="onFileChange"
                                    />
                                </label>
                            </div>
                            <InputError
                                :message="form.errors[dialogItem]"
                                class="mt-2"
                            />
                        </div>
                    </div>
                    <div class="mt-6">
                        <div class="flex justify-end">
                            <SecondaryButton @click="close()">
                                Cancel
                            </SecondaryButton>
                            <PrimaryButton class="ml-2" @click="save()">
                                save
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </Modal>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { Head, useForm, router } from "@inertiajs/vue3";
  import { ref } from "vue";
  import PrimaryButton from "@/Components/PrimaryButton.vue";
  import Modal from "@/Components/Modal.vue";
  import SecondaryButton from "@/Components/SecondaryButton.vue";
  import InputLabel from "@/Components/InputLabel.vue";
  import InputError from "@/Components/InputError.vue";
  
  defineProps({
    ktp: String,
    kk: String,
    foto: String,
    ijazah: String,
  });
  
  const form = useForm({
    ktp: null,
    kk: null,
    foto: null,
    ijazah: null,
  });
  
  const file = ref(null);
  const url = ref(null);
  
  const form_type = ["ktp", "kk", "foto", "ijazah"];
  
  const dialog = ref(false);
  const dialogItem = ref(null);
  
  const onFileChange = (e) => {
    file.value = e.target.files[0];
    form[dialogItem.value] = e.target.files[0];
    url.value = file.value ? URL.createObjectURL(file.value) : null;
  };
  
  const open = (type, item = null) => {
    dialogItem.value = item;
    dialog.value = true;
  };
  
  const close = () => {
    dialog.value = false;
    dialogItem.value = null;
    url.value = null;
    file.value = null;
    form.reset();
  };
  const goToForm = () => {
    router.visit(route("form.submission"));
};
  const save = () => {
    form.post(route("documents.update"), {
      onSuccess: close,
    });
  };
  </script>
  