import { ref } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";

const campings = ref([]);
const camping = ref({});
const validationErrors = ref({});
const isLoading = ref(false);

export default function useCampings() {
    const router = useRouter();

    // Listar campings
    const getCampings = async () => {
        isLoading.value = true;
        try {
            const response = await axios.get('/api/campings');
            campings.value = response.data.data;
        } finally {
            isLoading.value = false;
        }
    };

    // Obtener un camping por id
    const getCamping = async (id) => {
        isLoading.value = true;
        try {
            const response = await axios.get(`/api/campings/${id}`);
            camping.value = response.data.data;
        } finally {
            isLoading.value = false;
        }
    };

    // Crear camping
    const storeCamping = async (data) => {
        isLoading.value = true;
        validationErrors.value = {};
        try {
            await axios.post('/api/campings', {
                name: data.name,
                location: data.location,
                description: data.description,
            });
            router.push({ name: 'campings.index' });
        } catch (error) {
            if (error.response && error.response.status === 422) {
                validationErrors.value = error.response.data.errors;
            }
        } finally {
            isLoading.value = false;
        }
    };

    // Actualizar camping
    const updateCamping = async (id, data) => {
        isLoading.value = true;
        validationErrors.value = {};
        try {
            await axios.put(`/api/campings/${id}`, {
                name: data.name,
                location: data.location,
                description: data.description,
            });
            router.push({ name: 'campings.index' });
        } catch (error) {
            if (error.response && error.response.status === 422) {
                validationErrors.value = error.response.data.errors;
            }
        } finally {
            isLoading.value = false;
        }
    };

    // Eliminar camping
    const deleteCamping = async (id) => {
        isLoading.value = true;
        try {
            await axios.delete(`/api/campings/${id}`);
            // Opcional: recargar la lista después de borrar
            await getCampings();
        } finally {
            isLoading.value = false;
        }
    };

    return {
        campings,
        camping,
        validationErrors,
        isLoading,
        getCampings,
        getCamping,
        storeCamping,
        updateCamping,
        deleteCamping,
    };
}