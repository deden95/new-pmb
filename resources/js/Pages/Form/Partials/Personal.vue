<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Combobox from "@/Components/Combobox.vue";
import DateInput from "@/Components/DateInput.vue";
import { Link, useForm, usePage, router } from "@inertiajs/vue3";

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const submitForm = () => {
    form.patch(route('form.update'), {
        onSuccess: () => {
            router.visit(route('form.edit', { id: 'address' }));
        }
    });
};
const user = usePage().props.auth.user;
const form_data = usePage().props.form;

const form = useForm({
    name: user.name || ``,
    email: user.email || ``,
    gender: form_data.gender || ``,
    religion: form_data.religion || ``,
    birth_date: form_data.birth_date || ``,
    birth_place_city: form_data.birth_place_city || ``,
    birth_place_province: form_data.birth_place_province || ``,
    birth_place_country: form_data.birth_place_country || ``,
    national_id: `${form_data.national_id}`,
});

const provinces = [
    { value: '', text: 'Pilih Provinsi' },
    { value: 'Aceh', text: 'Aceh' },
    { value: 'Sumatera Utara', text: 'Sumatera Utara' },
    { value: 'Sumatera Barat', text: 'Sumatera Barat' },
    { value: 'Riau', text: 'Riau' },
    { value: 'Jambi', text: 'Jambi' },
    { value: 'Sumatera Selatan', text: 'Sumatera Selatan' },
    { value: 'Bengkulu', text: 'Bengkulu' },
    { value: 'Lampung', text: 'Lampung' },
    { value: 'Kepulauan Bangka Belitung', text: 'Kepulauan Bangka Belitung' },
    { value: 'Kepulauan Riau', text: 'Kepulauan Riau' },
    { value: 'DKI Jakarta', text: 'DKI Jakarta' },
    { value: 'Jawa Barat', text: 'Jawa Barat' },
    { value: 'Jawa Tengah', text: 'Jawa Tengah' },
    { value: 'DI Yogyakarta', text: 'DI Yogyakarta' },
    { value: 'Jawa Timur', text: 'Jawa Timur' },
    { value: 'Banten', text: 'Banten' },
    { value: 'Bali', text: 'Bali' },
    { value: 'Nusa Tenggara Barat', text: 'Nusa Tenggara Barat' },
    { value: 'Nusa Tenggara Timur', text: 'Nusa Tenggara Timur' },
    { value: 'Kalimantan Barat', text: 'Kalimantan Barat' },
    { value: 'Kalimantan Tengah', text: 'Kalimantan Tengah' },
    { value: 'Kalimantan Selatan', text: 'Kalimantan Selatan' },
    { value: 'Kalimantan Timur', text: 'Kalimantan Timur' },
    { value: 'Kalimantan Utara', text: 'Kalimantan Utara' },
    { value: 'Sulawesi Utara', text: 'Sulawesi Utara' },
    { value: 'Sulawesi Tengah', text: 'Sulawesi Tengah' },
    { value: 'Sulawesi Selatan', text: 'Sulawesi Selatan' },
    { value: 'Sulawesi Tenggara', text: 'Sulawesi Tenggara' },
    { value: 'Gorontalo', text: 'Gorontalo' },
    { value: 'Sulawesi Barat', text: 'Sulawesi Barat' },
    { value: 'Maluku', text: 'Maluku' },
    { value: 'Maluku Utara', text: 'Maluku Utara' },
    { value: 'Papua', text: 'Papua' },
    { value: 'Papua Barat', text: 'Papua Barat' },
    { value: 'Papua Tengah', text: 'Papua Tengah' },
    { value: 'Papua Pegunungan', text: 'Papua Pegunungan' },
    { value: 'Papua Selatan', text: 'Papua Selatan' },
    { value: 'Papua Barat Daya', text: 'Papua Barat Daya' },
];

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Personal Information
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update data diri personal anda.
            </p>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="col-span-2">
                    <InputLabel for="name" value="Nama" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full hover:cursor-not-allowed"
                        v-model="form.name"
                        autofocus
                        disabled
                        autocomplete="name"
                    />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="col-span-2">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full hover:cursor-not-allowed"
                        v-model="form.email"
                        disabled
                        autocomplete="email"
                    />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="col-span-1">
                    <InputLabel for="gender" value="Jenis Kelamin" />

                    <Combobox
                        id="gender"
                        class="mt-1 block w-full"
                        v-model="form.gender"
                        autocomplete="sex"
                        :option-value="[
                            { value: 'Male', text: 'Laki-laki' },
                            { value: 'Female', text: 'Wanita' },
                            { value: '', text: 'Pilih Jenis Kelamin' },
                        ]"
                    />
                    <InputError class="mt-2" :message="form.errors.gender" />
                </div>
                <div class="col-span-1">
                    <InputLabel for="religion" value="Agama" />

                    <Combobox
                        id="religion"
                        class="mt-1 block w-full"
                        v-model="form.religion"
                        autocomplete="religion"
                        :option-value="[
                            { value: 'Islam', text: 'Islam' },
                            { value: 'Kristen', text: 'Kristen' },
                            { value: 'Hindu', text: 'Hindu' },
                            { value: 'Buddha', text: 'Buddha' },
                            { value: 'Khonghucu', text: 'Khonghucu' },
                            { value: '', text: 'Pilih Agama' },
                        ]"
                    />
                    <InputError class="mt-2" :message="form.errors.religion" />
                </div>

                <div class="col-span-1">
                    <InputLabel for="birth_date" value="Tanggal Lahir" />

                    <DateInput
                        id="birth_date"
                        class="mt-1 block w-full"
                        v-model="form.birth_date"
                        autocomplete="bday"
                    />
                    <InputError
                        class="mt-2"
                        :message="form.errors.birth_date"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="birth_place_city" value="Kota Kelahiran" />

                    <TextInput
                        id="birth_place_city"
                        class="mt-1 block w-full"
                        v-model="form.birth_place_city"
                        autocomplete="address-level2"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.birth_place_city"
                    />
                </div>

                <div class="col-span-1">
                    <InputLabel for="birth_place_province" value="Provinsi Kelahiran" />

                    <Combobox
                        id="birth_place_province"
                        class="mt-1 block w-full"
                        v-model="form.birth_place_province"
                        :option-value="provinces"
                    />

                    <InputError class="mt-2" :message="form.errors.birth_place_province" />
                </div>

                <div class="col-span-1">
                    <InputLabel
                        for="birth_place_country"
                        value="Negara Kelahiran"
                    />

                    <TextInput
                        id="birth_place_country"
                        class="mt-1 block w-full"
                        v-model="form.birth_place_country"
                        autocomplete="country"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.birth_place_country"
                    />
                </div>

                <div class="col-span-2">
                    <InputLabel for="national_id" value="Nomor KTP" />

                    <TextInput
                        id="national_id"
                        class="mt-1 block w-full [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                        type="number"
                        v-model="form.national_id"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.national_id"
                    />
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 font-medium text-sm text-green-600 dark:text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <PrimaryButton :disabled="form.processing">Simpan & Lanjutkan</PrimaryButton>
            </div>
        </form>
    </section>
</template>
