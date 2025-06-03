<template>
    <div class="row justify-content-center my-5">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form @submit.prevent="submitForm">
                        <div class="mb-3">
                            <label for="camping-name" class="form-label">Nombre</label>
                            <input v-model="camping.name" id="camping-name" type="text" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.name }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.name">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="camping-location" class="form-label">Ubicación</label>
                            <input v-model="camping.location" id="camping-location" type="text" class="form-control">
                            <div class="text-danger mt-1">
                                {{ errors.location }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.location">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="camping-description" class="form-label">Descripción</label>
                            <textarea v-model="camping.description" id="camping-description" class="form-control"></textarea>
                            <div class="text-danger mt-1">
                                {{ errors.description }}
                            </div>
                            <div class="text-danger mt-1">
                                <div v-for="message in validationErrors?.description">
                                    {{ message }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button :disabled="isLoading" class="btn btn-primary">
                                <span v-if="isLoading">Procesando...</span>
                                <span v-else>Guardar</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive } from "vue";
import useCampings from "@/composables/campings";

import { useForm, useField, defineRule } from "vee-validate";
import { required } from "@/validation/rules";
defineRule('required', required);

// Define esquema de validación
const schema = {
    name: 'required',
    location: 'required',
    // description es opcional
}

const { storeCamping, validationErrors, isLoading } = useCampings();

const { validate, errors } = useForm({ validationSchema: schema })
const { value: name } = useField('name', null, { initialValue: '' });
const { value: location } = useField('location', null, { initialValue: '' });
const { value: description } = useField('description', null, { initialValue: '' });

const camping = reactive({
    name,
    location,
    description,
})

function submitForm() {
    validate().then(form => { if (form.valid) storeCamping(camping) })
}
</script>