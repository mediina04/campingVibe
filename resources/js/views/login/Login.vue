<template>
    <div class="flex h-screen bg-[#00C853]">
        <!-- Sección Izquierda - Formulario -->
        <div class="w-1/3 flex flex-col justify-center items-center px-10">
            <div class="text-white text-4xl font-bold mb-8 flex items-center">
                <img src="/images/icon-logo-CampingVibe.png" alt="Logo" class="h-12 mr-3" />
                <span>Camping <span class="text-green-200">VIBE</span></span>
            </div>
            <form @submit.prevent="submitLogin" class="w-full space-y-5">
                <div class="relative">
                    <input v-model="loginForm.email" id="email" type="email" required 
                           class="w-full pl-12 px-4 py-3 rounded-lg bg-white text-gray-800 focus:outline-none shadow-md"
                           placeholder="Email" />
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-green-600">
                        <i class="fas fa-user"></i>
                    </span>
                    <div v-if="validationErrors?.email" class="text-red-500 text-sm mt-1">
                        <div v-for="message in validationErrors.email">{{ message }}</div>
                    </div>
                </div>
                <div class="relative">
                    <input v-model="loginForm.password" id="password" type="password" required 
                           class="w-full pl-12 px-4 py-3 rounded-lg bg-white text-gray-800 focus:outline-none shadow-md"
                           placeholder="Contraseña" />
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-green-600">
                        <i class="fas fa-lock"></i>
                    </span>
                    <div v-if="validationErrors?.password" class="text-red-500 text-sm mt-1">
                        <div v-for="message in validationErrors.password">{{ message }}</div>
                    </div>
                </div>
                <div class="text-white text-sm text-left">
                    <router-link :to="{name: 'auth.forgot-password'}" class="underline">¿Contraseña Perdida?</router-link>
                </div>
                <button type="submit" class="w-full bg-white text-[#00C853] py-3 rounded-lg font-bold shadow-lg hover:bg-green-100 transition">
                    LOG IN
                </button>
                <div class="text-white text-sm text-center mt-3">
                    <router-link :to="{name: 'auth.register'}" class="underline">Crea tu cuenta</router-link>
                </div>
            </form>
        </div>
        
        <!-- Sección Derecha - Imágenes -->
        <div class="w-2/3 grid grid-cols-2 gap-4 p-10">
            <img src="/images/img1-login.png" class="rounded-lg w-full h-40 object-cover shadow-lg" />
            <img src="/images/img2-login.png" class="rounded-lg w-full h-40 object-cover shadow-lg" />
            <img src="/images/img3-login.png" class="rounded-lg w-full h-40 object-cover shadow-lg" />
            <img src="/images/img4-login.png" class="rounded-lg w-full h-40 object-cover shadow-lg" />
        </div>
    </div>
</template>

<script setup>
import useAuth from '@/composables/auth';
const { loginForm, validationErrors, submitLogin } = useAuth();
</script>

<style scoped>
.shadow-md {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}
.shadow-lg {
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}
.transition {
    transition: background-color 0.3s ease;
}

/* Ajuste del tamaño de las imágenes */
.grid img {
    height: 10rem; /* Reduce la altura de las imágenes */
    object-fit: cover;
}
</style>
