<template>
    <div>
        <Navbar v-if="!hideNav" />
        <router-view></router-view>
    </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
import Navbar from './Nav.vue'

const route = useRoute()
const hideNav = ['auth.login', 'auth.register'].includes(route.name)
</script>
