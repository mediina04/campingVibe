<template>
  <div class="register-root">
    <button class="back-home-btn" @click="$router.push('/')">
      INICIO &gt;
    </button>
    <!-- Imágenes a la izquierda -->
    <div class="register-right">
      <div class="image-grid">
        <div class="img-horizontal">
          <img src="/images/horizontal1.png" alt="Horizontal 1" />
        </div>
        <div class="img-vertical">
          <img src="/images/vertical1.png" alt="Vertical 1" />
        </div>
        <div class="img-vertical">
          <img src="/images/vertical2.png" alt="Vertical 2" />
        </div>
        <div class="img-horizontal">
          <img src="/images/horizontal2.png" alt="Horizontal 2" />
        </div>
      </div>
    </div>
    <!-- Formulario a la derecha -->
    <div class="register-left">
      <div class="logo-container">
        <img src="images/icon-logo-CampingVibe.png" alt="Camping Vibe Logo" class="logo" />
      </div>
      <form @submit.prevent="submitRegister" class="register-form">
        <input v-model="registerForm.name" type="text" class="input-field" placeholder="Nombre" required autofocus autocomplete="name">
        <div v-if="validationErrors.name" class="error">{{ validationErrors.name[0] }}</div>

        <input v-model="registerForm.surname1" type="text" class="input-field" placeholder="Primer apellido" required autocomplete="family-name">
        <div v-if="validationErrors.surname1" class="error">{{ validationErrors.surname1[0] }}</div>

        <input v-model="registerForm.email" type="email" class="input-field" placeholder="Email" required autocomplete="username">
        <div v-if="validationErrors.email" class="error">{{ validationErrors.email[0] }}</div>

        <input v-model="registerForm.password" type="password" class="input-field" placeholder="Contraseña" required autocomplete="new-password">
        <div v-if="validationErrors.password" class="error">{{ validationErrors.password[0] }}</div>

        <input v-model="registerForm.password_confirmation" type="password" class="input-field" placeholder="Repite la contraseña" required autocomplete="new-password">
        <div v-if="validationErrors.password_confirmation" class="error">{{ validationErrors.password_confirmation[0] }}</div>

        <button class="register-button" :class="{'opacity-50': processing}" :disabled="processing">
          SIGN UP
        </button>
        <hr class="register-divider" />
        <router-link :to="{name: 'auth.login'}" class="register-link">Inicia sesión</router-link>
      </form>
    </div>
  </div>
</template>

<script setup>
import useAuth from '@/composables/auth'
const { registerForm, validationErrors, processing, submitRegister } = useAuth();
</script>

<style scoped>
.register-root {
  display: flex;
  height: 100vh;
  background: #00BF63;
  position: relative;
}

.back-home-btn {
  position: absolute;
  top: 32px;
  right: 32px;
  background: transparent;
  color: #fff;
  border: none;
  font-size: 22px;
  font-weight: bold;
  cursor: pointer;
  z-index: 10;
  letter-spacing: 1px;
  transition: opacity 0.2s;
  opacity: 0.95;
}
.back-home-btn:hover {
  opacity: 1;
  text-decoration: underline;
}

.register-left {
  width: 35%;
  min-width: 340px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #fff;
  padding: 0 40px;
  position: relative;
}

.logo-container {
  display: flex;
  justify-content: center;
  margin-bottom: 32px;
}

.logo {
  height: 90px;
}

.register-form {
  width: 100%;
  max-width: 320px;
  display: flex;
  flex-direction: column;
  gap: 22px;
  align-items: center;
}

.input-field {
  width: 100%;
  padding: 16px 18px;
  border-radius: 12px;
  color: #333;
  outline: none;
  border: none;
  font-size: 17px;
  background: #fff;
  margin-bottom: 0;
}

.input-field::placeholder {
  color: #00BF63;
  font-size: 16px;
}

.register-button {
  width: 60%;
  align-self: flex-end;
  background: #fff;
  color: #00BF63;
  font-weight: bold;
  border: none;
  padding: 14px 0;
  border-radius: 12px;
  cursor: pointer;
  font-size: 18px;
  transition: background 0.3s, color 0.3s;
  margin-top: 10px;
  margin-bottom: 10px;
}
.register-button:hover {
  background: #e6ffe6;
  color: #00994d;
}

.register-divider {
  border: none;
  border-top: 1.5px solid #fff;
  margin: 24px 0 0 0;
  opacity: 0.5;
  width: 100%;
}

.register-link {
  display: block;
  color: #fff;
  text-align: center;
  margin-top: 18px;
  font-size: 16px;
  text-decoration: underline;
  opacity: 0.85;
  transition: opacity 0.2s;
}
.register-link:hover {
  opacity: 1;
}

.register-right {
  width: 65%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: transparent;
}

.image-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: 1fr 1fr;
  gap: 18px;
  width: 440px;
  height: 440px;
}

.img-horizontal img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  aspect-ratio: 4/3;
  border-radius: 18px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.10);
}

.img-vertical img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  aspect-ratio: 3/4;
  border-radius: 18px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.10);
}
</style>
