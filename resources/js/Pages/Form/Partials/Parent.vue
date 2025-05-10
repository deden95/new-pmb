<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
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

const user = usePage().props.auth.user;
const form_data = usePage().props.form;

const form = useForm({
    familyMembers: [
        {
            role: "Ayah",
            name: form_data.father_name || "",
            birth_date: form_data.father_birth_date || "",
            place: form_data.father_place || "",
            last_education: form_data.father_last_education || "",
            job: form_data.father_job || "",
            phone: form_data.father_phone || "",          
        },
        {
            role: "Ibu",
            name: form_data.mother_name || "",
            birth_date: form_data.mother_birth_date || "",
            place: form_data.mother_place || "",
            last_education: form_data.mother_last_education || "",
            job: form_data.mother_job || "",
            phone: form_data.mother_phone || "", 
        },
    ],
    }).transform((data) => {
        const transformedData = {};
        data.familyMembers.forEach((person) => {
            // Tentukan prefix berdasarkan role dengan jelas
            const prefix = person.role === "Ayah" ? "father" : person.role === "Ibu" ? "mother" : person.role.toLowerCase();
            
            Object.keys(person).forEach((key) => {
                if (key !== "role" && person[key]) {
                    const newKey = `${prefix}_${key}`; 
                    transformedData[newKey] = person[key];
                }
            });
        });
        console.log("Transformed Data:", transformedData);

        return transformedData;
    });


const memberFields = {
    name: "Nama",
    birth_date: "Tanggal Lahir",
    place: "Tempat Lahir",
    last_education: "Pendidikan Terakhir",
    job: "Pekerjaan",
    phone: "Nomor Telepon",
  
};

const updateFormValue = (role, field, value) => {
    const memberIndex = form.familyMembers.findIndex(
        (member) => member.role === role
    );
    // form.familyMembers[memberIndex][field] = value;
};

const getFieldId = (role, field) => {
    return `${role}_${field}`;
};

const capitalize = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
};

const submitForm = () => {
    form.patch(route('form.update'), {
        onSuccess: () => {
            router.visit(route('documents.index'));
        }
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Orang Tua / Wali
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update data orang tua / wali.
            </p>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div v-for="member in form.familyMembers" :key="member.role">
                <h3 class="text-black dark:text-white font-bold text-1xl">
                    {{
                        member.role.charAt(0).toUpperCase() +
                        member.role.slice(1)
                    }}
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div
                        class="col-span-2"
                        v-for="field in Object.keys(memberFields)"
                        :key="field"
                    >
                        <InputLabel
                            for="getFieldId(member.role, field)"
                            :value="capitalize(memberFields[field])"
                        />

                        <DateInput
                            v-if="field === 'birth_date'"
                            :id="getFieldId(member.role, field)"
                            class="mt-1 block w-full"
                            v-model="member[field]"
                        />

                        <TextInput
                            v-else-if="field === 'phone'"
                            :id="getFieldId(member.role, field)"
                            type="number"
                            class="mt-1 block w-full [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none"
                            v-model="member[field]"
                        />

          

                        <TextInput
                            v-else
                            :id="getFieldId(member.role, field)"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="member[field]"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors[field]"
                        />
                    </div>

                </div>
            </div>

            <div class="flex justify-end gap-4">
                <PrimaryButton :disabled="form.processing">Simpan & Lanjutkan</PrimaryButton>
            </div>
        </form>
    </section>
</template>
