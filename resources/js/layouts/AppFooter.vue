<template>
    <footer class="footer">
        <div class="footer-column">
            <h3>ACERCA DE</h3>
            <p>Somos una plataforma dedicada a conectar a los amantes del camping con los mejores destinos. Encuentra, reserva y comparte experiencias en campings de toda la región con facilidad y confianza.</p>
        </div>

        <div class="footer-column">
            <h3>CONTACTO</h3>
            <p>contacto@campingvibe.com</p>
            <p>+34 623 456 789</p>
            <p>¿Tienes dudas o sugerencias?</p>
            <textarea class="footer-message" placeholder="Escribe tu mensaje..."></textarea>
        </div>

        <div class="footer-column footer-logo">
            <img src="/images/icon-logo-green.png" alt="Logo">
            <div class="social-icons">
                <img src="/images/icon-instagram.png" alt="Instagram">
                <img src="/images/icon-linkedin.png" alt="LinkedIn">
                <img src="/images/icon-x.png" alt="Twitter">
                <img src="/images/icon-facebook.png" alt="Facebook">
            </div>
        </div>
    </footer>
</template>

<style lang="scss" scoped>
.footer {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 30px 10%;
    background: white;
    color: black;
}

.footer-column {
    flex: 1;
    text-align: left;
}

.footer h3 {
    color: #00bf63;
    font-weight: bold;
    margin-bottom: 10px;
}

.footer-message {
    width: 100%;
    max-width: 250px;
    height: 40px;
    padding: 8px;
    border: 2px solid #00bf63;
    border-radius: 5px;
    outline: none;
    resize: none;
    font-size: 14px;
}

.footer-message::placeholder {
    color: #00bf63;
}

.footer-message:focus {
    border-color: #008f4f;
}

.footer-logo {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.footer-logo img {
    width: 140px;
    display: block;
    margin-bottom: 15px;
}

.social-icons {
    display: flex;
    justify-content: left;
    gap: 10px;
}

.social-icons img {
    width: 30px;
    height: 30px;
    cursor: pointer;
    transition: 0.3s;
}

.social-icons img:hover {
    transform: scale(1.1);
}
</style>

<script setup>
import { useLayout } from '../composables/layout';
import { computed } from 'vue';

const { layoutConfig } = useLayout();

const logoUrl = computed(() => {
    return `layout/images/${layoutConfig.darkTheme.value ? 'logo-white' : 'logo-dark'}.svg`;
});
</script>