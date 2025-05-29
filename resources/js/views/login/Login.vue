<template>
  <div class="login-root">
    <button class="back-home-btn" @click="$router.push('/')">
      &lt; INICIO
    </button>
    <!-- Left Section: Logo and Form -->
    <div class="login-left">
      <div class="logo-container">
        <img src="images/icon-logo-CampingVibe.png" alt="Camping Vibe Logo" class="logo" />
      </div>
      <form @submit.prevent="submitLogin" class="login-form">
        <input v-model="loginForm.email" id="email" type="email" class="input-field" placeholder="Email" required autofocus autocomplete="username">
        <div class="error-text" v-for="message in validationErrors?.email" :key="message">{{ message }}</div>
        <input v-model="loginForm.password" id="password" type="password" class="input-field" placeholder="Contraseña" required autocomplete="current-password">
        <div class="error-text" v-for="message in validationErrors?.password" :key="message">{{ message }}</div>
        <div class="login-links">
          <router-link :to="{name: 'auth.forgot-password'}" class="forgot-link">¿Contraseña Perdida?</router-link>
          <button class="login-button" :class="{'opacity-50': processing}" :disabled="processing">
            LOG IN
          </button>
        </div>
        <hr class="login-divider" />
        <router-link :to="{name: 'auth.register'}" class="register-link">Crea tu cuenta</router-link>
      </form>
    </div>
    <!-- Right Section: Images -->
    <div class="login-right">
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
  </div>
</template>

<script setup>
import useAuth from '@/composables/auth';
const { loginForm, validationErrors, processing, submitLogin } = useAuth();
</script>

<style scoped>
.login-root {
  display: flex;
  height: 100vh;
  background: #00BF63;
}

.back-home-btn {
  position: absolute;
  top: 20px;
  left: 20px;
  background: transparent;
  color: #fff;
  border: none;
  font-size: 16px;
  cursor: pointer;
  transition: color 0.3s;
}

.back-home-btn:hover {
  color: #e6ffe6;
}

.login-left {
  width: 35%;
  min-width: 340px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  color: #fff;
  padding: 0 40px;
}

.logo-container {
  display: flex;
  justify-content: center;
  margin-bottom: 32px;
}

.logo {
  height: 90px;
}

.login-form {
  width: 100%;
  max-width: 320px;
  display: flex;
  flex-direction: column;
  gap: 18px;
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

.error-text {
  color: #FF4D4D;
  font-size: 13px;
  margin-top: 2px;
  margin-bottom: -8px;
}

.login-links {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: -8px;
}

.forgot-link {
  color: #fff;
  font-size: 14px;
  text-decoration: underline;
  opacity: 0.85;
  transition: opacity 0.2s;
}
.forgot-link:hover {
  opacity: 1;
}

.login-button {
  background: #fff;
  color: #00BF63;
  font-weight: bold;
  border: none;
  padding: 10px 32px;
  border-radius: 8px;
  cursor: pointer;
  font-size: 16px;
  transition: background 0.3s, color 0.3s;
  margin-left: 10px;
}
.login-button:hover {
  background: #e6ffe6;
  color: #00994d;
}

.login-divider {
  border: none;
  border-top: 1.5px solid #fff;
  margin: 18px 0 0 0;
  opacity: 0.5;
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

.login-right {
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