<template>
    <nav class="navbar navbar-expand-md navbar-custom shadow-sm">
        <div class="container d-flex align-items-center justify-content-between">
            <router-link to="/" class="navbar-brand d-flex align-items-center">
                <img src="/images/icon-logo-CampingVibe.png" alt="CampingVibe Logo" class="nav-logo">
            </router-link>
            <a class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto d-flex align-items-center">
                    <template v-if="!authStore().user?.name">
                        <li class="nav-item">
                            <router-link class="btn nav-button" to="/login">
                                {{ $t('login') }}
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="btn nav-button" to="/register">{{ $t('register') }}</router-link>
                        </li>
                    </template>
                    <li v-if="authStore().user?.name" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ authStore().user?.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><router-link class="dropdown-item" to="/admin">Admin</router-link></li>
                            <li><router-link to="/admin/posts" class="dropdown-item">Post</router-link></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" @click="logout">Logout</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <router-link to="/resources/js/layouts/Guest.vue" class="nav-link d-flex align-items-center">
                            <img src="/images/icon-user.png" alt="User Icon" class="nav-user-icon">
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<style scoped>
.navbar-custom {
    background-color: #00bf63;
    height: 100px;
    display: flex;
    align-items: center;
}
.navbar-custom .nav-link, 
.navbar-custom .navbar-brand, 
.navbar-custom .nav-link.dropdown-toggle {
    color: #FFFFFF !important;
}
.nav-logo {
    height: 125px;
    max-width: 150px;
    object-fit: contain;
}
.nav-user-icon {
    height: 50px;
    width: 50px;
    border-radius: 50%;
    object-fit: cover;
}
.nav-button {
    background-color: transparent;
    color: #FFFFFF;
    border: 2px solid transparent;
    transition: all 0.3s ease-in-out;
    padding: 5px 15px;
    margin: 0 5px;
}
.nav-button:hover {
    background-color: #FFFFFF;
    color: #00bf63;
    border: 2px solid #00bf63;
}
</style>

<script setup>

import useAuth from "@/composables/auth";
import { authStore } from "../store/auth";

const { processing, logout } = useAuth();
</script>
