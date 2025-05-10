<script setup>
import { ref, watch, onMounted } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";

import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

// Form setup
const from_data = usePage().props.form;
const form = useForm({
  last_education: from_data.last_education || "",
  education_number: from_data.education_number || "",
  education_name: from_data.education_name || "",
  education_city: from_data.education_city || "",
  education_province: from_data.education_province || "",
  education_subdistrict: from_data.education_subdistrict || "",
  education_country: from_data.education_country || "",
  education_postal_code: `${from_data.education_postal_code || ""}`,
  education_graduation_year: from_data.education_graduation_year || "",
  education_major: from_data.education_major || "",
});

// Dropdown data
const education_province = ref([]);
const education_city = ref([]);
const education_subdistrict = ref([]);

// Selected IDs
const selectedProvinceId = ref(null);
const selectedCityId = ref(null);
const selectedDistrictId = ref(null);

// Fetch API
const fetchProvinces = async () => {
  const res = await fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json");
  education_province.value = await res.json();
};

const fetchCities = async (provinceId) => {
  const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`);
  education_city.value = await res.json();
};

const fetchDistricts = async (cityId) => {
  const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`);
  education_subdistrict.value = await res.json();
};

// Watchers untuk mengisi nama otomatis berdasarkan ID
watch(selectedProvinceId, async (newId) => {
  form.education_province = education_province.value.find(p => p.id === newId)?.name || "";
  education_city.value = [];
  education_subdistrict.value = [];
  selectedCityId.value = null;
  selectedDistrictId.value = null;
  if (newId) await fetchCities(newId);
});

watch(selectedCityId, async (newId) => {
  form.education_city = education_city.value.find(c => c.id === newId)?.name || "";
  education_subdistrict.value = [];
  selectedDistrictId.value = null;
  if (newId) await fetchDistricts(newId);
});

watch(selectedDistrictId, (newId) => {
  form.education_subdistrict = education_subdistrict.value.find(d => d.id === newId)?.name || "";
});

// On mounted, auto set selected ID jika form sudah terisi
onMounted(async () => {
  await fetchProvinces();

  if (form.education_province) {
    const selectedProv = education_province.value.find(p => p.name === form.education_province);
    if (selectedProv) {
      selectedProvinceId.value = selectedProv.id;
      await fetchCities(selectedProv.id);

      if (form.education_city) {
        const selectedCity = education_city.value.find(c => c.name === form.education_city);
        if (selectedCity) {
          selectedCityId.value = selectedCity.id;
          await fetchDistricts(selectedCity.id);

          if (form.education_subdistrict) {
            const selectedDistrict = education_subdistrict.value.find(d => d.name === form.education_subdistrict);
            if (selectedDistrict) {
              selectedDistrictId.value = selectedDistrict.id;
            }
          }
        }
      }
    }
  }
});

const submitForm = () => {
    form.patch(route('form.update'), {
        onSuccess: () => {
            router.visit(route('form.edit', { id: 'parent' }));
        }
    });
};

</script>

<template>
    <section>
      <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Pendidikan</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Update data pendidikan anda.</p>
      </header>  

      <form @submit.prevent="submitForm" class="mt-6 space-y-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <!-- Pendidikan Terakhir -->
          <div>
            <InputLabel for="last_education" value="Pendidikan Terakhir" />
            <TextInput id="last_education" type="text" class="mt-1 block w-full" v-model="form.last_education" />
            <InputError class="mt-2" :message="form.errors.last_education" />
          </div>
  
          <!-- Nomor Edukasi -->
          <div>
            <InputLabel for="education_number" value="Nomor Edukasi (NIS/NIM)" />
            <TextInput id="education_number" type="text" class="mt-1 block w-full" v-model="form.education_number" />
            <InputError class="mt-2" :message="form.errors.education_number" />
          </div>
  
          <!-- Nama Tempat Pendidikan -->
          <div>
            <InputLabel for="education_name" value="Nama Asal Sekolah" />
            <TextInput id="education_name" type="text" class="mt-1 block w-full" v-model="form.education_name" />
            <InputError class="mt-2" :message="form.errors.education_name" />
          </div>
  
          <!-- Provinsi -->
          <div>
            <InputLabel for="province" value="Provinsi" />
            <select v-model="selectedProvinceId" class="mt-1 block w-full border-gray-300 rounded-md">
              <option value="">Pilih Provinsi</option>
              <option v-for="p in education_province" :key="p.id" :value="p.id">{{ p.name }}</option>
            </select>
            <InputError class="mt-2" :message="form.errors.education_province" />
          </div>
  
          <!-- Kota -->
          <div>
            <InputLabel for="city" value="Kota" />
            <select v-model="selectedCityId" class="mt-1 block w-full border-gray-300 rounded-md">
              <option value="">Pilih Kota</option>
              <option v-for="c in education_city" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
            <InputError class="mt-2" :message="form.errors.education_city" />
          </div>
  
          <!-- Kecamatan -->
          <div>
            <InputLabel for="subdistrict" value="Kecamatan" />
            <select v-model="selectedDistrictId" class="mt-1 block w-full border-gray-300 rounded-md">
              <option value="">Pilih Kecamatan</option>
              <option v-for="d in education_subdistrict" :key="d.id" :value="d.id">{{ d.name }}</option>
            </select>
            <InputError class="mt-2" :message="form.errors.education_subdistrict" />
          </div>
  
          <!-- Negara -->
          <div>
            <InputLabel for="education_country" value="Negara" />
            <TextInput id="education_country" type="text" class="mt-1 block w-full" v-model="form.education_country" />
            <InputError class="mt-2" :message="form.errors.education_country" />
          </div>
  
          <!-- Kode Pos -->
          <div>
            <InputLabel for="education_postal_code" value="Nomor Pos" />
            <TextInput id="education_postal_code" type="number" class="mt-1 block w-full" v-model="form.education_postal_code" />
            <InputError class="mt-2" :message="form.errors.education_postal_code" />
          </div>
  
          <!-- Jurusan -->
          <div>
            <InputLabel for="education_major" value="Jurusan" />
            <TextInput id="education_major" type="text" class="mt-1 block w-full" v-model="form.education_major" />
            <InputError class="mt-2" :message="form.errors.education_major" />
          </div>
  
          <!-- Tahun Kelulusan -->
          <div>
            <InputLabel for="education_graduation_year" value="Tahun Kelulusan" />
            <TextInput id="education_graduation_year" type="text" class="mt-1 block w-full" v-model="form.education_graduation_year" />
            <InputError class="mt-2" :message="form.errors.education_graduation_year" />
          </div>
        </div>
  
        <div class="flex justify-end gap-4">
          <PrimaryButton :disabled="form.processing">Simpan & Lanjutkan</PrimaryButton>
        </div>
      </form>
    </section>
  </template>
  