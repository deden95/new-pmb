<script setup>
import { ref, watch, onMounted } from "vue";
import { useForm, usePage, router } from "@inertiajs/vue3";

import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import Combobox from "@/Components/Combobox.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NumberInput from "@/Components/NumberInput.vue";

const form_data = usePage().props.form;

const form = useForm({
  address: form_data.address || "",
  province: form_data.province || "",
  city: form_data.city || "",
  subdistrict: form_data.subdistrict || "",
  district: form_data.district || "",
  country: form_data.country || "",
  postal_code: form_data.postal_code || "",
  rt: form_data.rt || "",
  rw: form_data.rw || "",
  phone_number: form_data.phone_number || "",
  phone_number_alt: form_data.phone_number_alt || "",
});

const provinces = ref([]);
const cities = ref([]);
const districts = ref([]);
const villages = ref([]);

const selectedProvinceId = ref(null);
const selectedCityId = ref(null);
const selectedDistrictId = ref(null);

const fetchProvinces = async () => {
  const res = await fetch("https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json");
  provinces.value = await res.json();
};

const fetchCities = async (provinceId) => {
  const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${provinceId}.json`);
  cities.value = await res.json();
};

const fetchDistricts = async (cityId) => {
  const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${cityId}.json`);
  districts.value = await res.json();
};

const fetchVillages = async (districtId) => {
  const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${districtId}.json`);
  villages.value = await res.json();
};

watch(() => selectedProvinceId.value, async (newId) => {
  form.province = provinces.value.find(p => p.id === newId)?.name || "";
  cities.value = [];
  districts.value = [];
  villages.value = [];
  selectedCityId.value = null;
  selectedDistrictId.value = null;
  if (newId) await fetchCities(newId);
});

watch(() => selectedCityId.value, async (newId) => {
  form.city = cities.value.find(c => c.id === newId)?.name || "";
  districts.value = [];
  villages.value = [];
  selectedDistrictId.value = null;
  if (newId) await fetchDistricts(newId);
});

watch(() => selectedDistrictId.value, async (newId) => {
  form.subdistrict = districts.value.find(d => d.id === newId)?.name || "";
  villages.value = [];
  if (newId) await fetchVillages(newId);
});

onMounted(async () => {
  await fetchProvinces();

  // Jika ada provinsi yang sudah disimpan, cari ID-nya
  if (form.province) {
    const selectedProv = provinces.value.find(p => p.name === form.province);
    if (selectedProv) {
      selectedProvinceId.value = selectedProv.id;
      await fetchCities(selectedProv.id);

      if (form.city) {
        const selectedCity = cities.value.find(c => c.name === form.city);
        if (selectedCity) {
          selectedCityId.value = selectedCity.id;
          await fetchDistricts(selectedCity.id);

          if (form.subdistrict) {
            const selectedDistrict = districts.value.find(d => d.name === form.subdistrict);
            if (selectedDistrict) {
              selectedDistrictId.value = selectedDistrict.id;
              await fetchVillages(selectedDistrict.id);
            }
          }
        }
      }
    }
  }
});


const updateDisability = () => {
  form.patch(route("form.update"), {
    preserveScroll: true,
    onSuccess: () => {
      router.visit(route("form.edit", { id: "disability" }));
    },
  });
};
</script>


<template>
  <section>
    <header>
      <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Alamat</h2>
      <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Isi alamat sesuai dengan KTP anda.</p>
    </header>

    <form @submit.prevent="updateDisability" class="mt-6 space-y-6">
      <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
          <InputLabel for="address" value="Alamat" />
          <TextareaInput id="address" class="mt-1 block w-full" v-model="form.address" />
          <InputError class="mt-2" :message="form.errors.address" />
        </div>

        <div>
          <InputLabel for="province" value="Provinsi" />
          <select v-model="selectedProvinceId" class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">Pilih Provinsi</option>
            <option v-for="p in provinces" :key="p.id" :value="p.id">{{ p.name }}</option>
          </select>
          <InputError class="mt-2" :message="form.errors.province" />
        </div>

        <div>
          <InputLabel for="city" value="Kota/Kabupaten" />
          <select v-model="selectedCityId" class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">Pilih Kota/Kabupaten</option>
            <option v-for="c in cities" :key="c.id" :value="c.id">{{ c.name }}</option>
          </select>
          <InputError class="mt-2" :message="form.errors.city" />
        </div>

        <div>
          <InputLabel for="subdistrict" value="Kecamatan" />
          <select v-model="selectedDistrictId" class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">Pilih Kecamatan</option>
            <option v-for="d in districts" :key="d.id" :value="d.id">{{ d.name }}</option>
          </select>
          <InputError class="mt-2" :message="form.errors.subdistrict" />
        </div>

        <div>
          <InputLabel for="district" value="Kelurahan/Desa" />
          <select v-model="form.district" class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="">Pilih Kelurahan/Desa</option>
            <option v-for="v in villages" :key="v.id" :value="v.name">{{ v.name }}</option>
          </select>
          <InputError class="mt-2" :message="form.errors.district" />
        </div>

        <div>
          <InputLabel for="country" value="Negara" />
          <TextInput id="country" class="mt-1 block w-full" v-model="form.country" />
          <InputError class="mt-2" :message="form.errors.country" />
        </div>

        <div>
          <InputLabel for="postal_code" value="Kode Pos" />
          <NumberInput id="postal_code" class="mt-1 block w-full" v-model="form.postal_code" />
          <InputError class="mt-2" :message="form.errors.postal_code" />
        </div>

        <div>
          <InputLabel for="rt" value="RT" />
          <TextInput id="rt" class="mt-1 block w-full" v-model="form.rt" />
          <InputError class="mt-2" :message="form.errors.rt" />
        </div>

        <div>
          <InputLabel for="rw" value="RW" />
          <TextInput id="rw" class="mt-1 block w-full" v-model="form.rw" />
          <InputError class="mt-2" :message="form.errors.rw" />
        </div>

        <div>
          <InputLabel for="phone_number" value="Nomor Telepon" />
          <TextInput id="phone_number" class="mt-1 block w-full" v-model="form.phone_number" />
          <InputError class="mt-2" :message="form.errors.phone_number" />
        </div>

        <div>
          <InputLabel for="phone_number_alt" value="Nomor Telepon Alternatif" />
          <TextInput id="phone_number_alt" class="mt-1 block w-full" v-model="form.phone_number_alt" />
          <InputError class="mt-2" :message="form.errors.phone_number_alt" />
        </div>
      </div>

      <div class="flex justify-end gap-4">
        <PrimaryButton :disabled="form.processing">Simpan & Lanjutkan</PrimaryButton>
      </div>
    </form>
  </section>
</template>
