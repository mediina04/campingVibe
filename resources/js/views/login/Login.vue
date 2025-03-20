<template>
    <div class="flex h-screen" style="background-color: #00BF63;">
        <!-- Left Section: Logo and Form -->
        <div class="w-1/3 flex flex-col justify-center items-center text-white p-10">
            <!-- Logo -->
            <div class="logo-container">
                <img src="images/icon-logo-CampingVibe.png" alt="Camping Vibe Logo" class="logo" />
            </div>
            
            <!-- Form -->
            <div class="w-full max-w-xs">
                <form @submit.prevent="submitLogin" class="space-y-4">
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input v-model="loginForm.email" id="email" type="email" class="input-field" required autofocus autocomplete="username">
                        <div class="error-text" v-for="message in validationErrors?.email">{{ message }}</div>
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium">Contraseña</label>
                        <input v-model="loginForm.password" id="password" type="password" class="input-field" required autocomplete="current-password">
                        <div class="error-text" v-for="message in validationErrors?.password">{{ message }}</div>
                    </div>
                    
                    <!-- Forgot Password -->
                    <div class="text-right text-sm">
                        <router-link :to="{name: 'auth.forgot-password'}" class="text-white hover:underline">¿Contraseña Perdida?</router-link>
                    </div>
                    
                    <!-- Login Button -->
                    <button class="login-button" :class="{'opacity-50': processing}" :disabled="processing">
                        Iniciar Sesión
                    </button>
                </form>
                
                <!-- Register Link -->
                <div class="mt-4 text-sm text-center">
                    <router-link :to="{name: 'auth.register'}" class="text-white hover:underline">Crea tu cuenta</router-link>
                </div>
            </div>
        </div>
        
        <!-- Right Section: Images (To be implemented later) -->
        <div class="w-2/3 bg-cover bg-center" style="background-image: url('/background-image.jpg');">
            <!-- Aquí irán las imágenes -->
        </div>
    </div>
</template>

<script setup>
import useAuth from '@/composables/auth';
const { loginForm, validationErrors, processing, submitLogin } = useAuth();
</script>

<style scoped>
.logo-container { 
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

/* Ajusta el tamaño del logo */
.logo {
    height: 80px;
}

/* Estiliza los inputs */
.input-field {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    color: #333;
    outline: none;
    border: none;
    font-size: 14px;
    transition: box-shadow 0.3s ease;
}

.input-field:focus {
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

.error-text {
    color: #FF4D4D;
    font-size: 12px;
    margin-top: 4px;
}

.login-button {
    width: 100%;
    background-color: white;
    color: #00BF63;
    font-weight: bold;
    padding: 10px;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.login-button:hover {
    background-color: #f0f0f0;
}
</style>