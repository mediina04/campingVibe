<template>
  <div class="profile-page">
    <Nav />
    <div class="profile-main">
      <div class="profile-columns">
        <!-- Formulario de edición de usuario -->
        <form class="user-form" @submit.prevent="updateProfile">
          <h2 class="form-title">DATOS DEL USUARIO</h2>
          <div class="form-group">
            <input v-model="user.name" type="text" placeholder="Nombre" />
            <input v-model="user.surname1" type="text" placeholder="Primer apellido" />
          </div>
          <input v-model="user.email" type="email" placeholder="Email" />
          <div class="form-buttons">
            <button type="submit" class="btn-green">
              <i class="fa fa-save"></i> Guardar
            </button>
          </div>
        </form>

        <!-- Reservas activas -->
        <div class="reservations-section">
          <h2 class="section-title">RESERVAS ACTIVAS</h2>
          <div class="reservations-list">
            <div class="reservation-card" v-for="reservation in paginatedReservations" :key="reservation.id">
              <div class="reservation-info">
                <div class="camping-name">{{ reservation.camping }}</div>
                <div class="dates"><i class="fa fa-calendar"></i> {{ reservation.start }} - {{ reservation.end }}</div>
                <div class="people"><i class="fa fa-user"></i> {{ reservation.people }} {{ reservation.people == 1 ? 'persona' : 'personas' }}</div>
              </div>
              <a :href="reservation.web" target="_blank" class="web-button">WEB CAMPING</a>
            </div>
          </div>
          <div class="pagination" v-if="totalPages > 1">
            <button v-for="page in totalPages" :key="page" @click="goToPage(page)" :class="{active: currentPage === page}">{{ page }}</button>
          </div>
        </div>
      </div>

      <!-- Reseñas -->
      <div class="reviews-section">
        <h2 class="section-title">TUS RESEÑAS</h2>
        <div class="reviews-list">
          <div class="review-card" v-for="review in paginatedReviews" :key="review.id">
            <div class="review-header">
              <span class="camping-name">{{ review.camping }}</span>
              <span class="rating">{{ review.rating }} / 5</span>
            </div>
            <div class="review-date">{{ review.date }}</div>
            <div class="review-text">{{ review.text }}</div>
          </div>
        </div>
        <div class="pagination" v-if="totalReviewsPages > 1">
          <button
            v-for="page in totalReviewsPages"
            :key="page"
            @click="reviewsPage = page"
            :class="{active: reviewsPage === page}"
          >{{ page }}</button>
        </div>
      </div>
    </div>
    <div class="footer-divider"></div>
    <Footer />
  </div>
</template>

<script>
import Nav from '@/layouts/Nav.vue'
import Footer from '@/layouts/AppFooter.vue'
import axios from 'axios'

export default {
  name: 'UserProfile',
  components: { Nav, Footer },
  data() {
    return {
      user: {
        name: '',
        surname: '',
        email: '',
        phone: ''
      },
      reservations: [],
      reviews: [],
      currentPage: 1,
      perPage: 3,
      reviewsPage: 1,
      reviewsPerPage: 4
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.reservations.length / this.perPage);
    },
    paginatedReservations() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.reservations.slice(start, start + this.perPage);
    },
    paginatedReviews() {
      const start = (this.reviewsPage - 1) * this.reviewsPerPage;
      return this.reviews.slice(start, start + this.reviewsPerPage);
    },
    totalReviewsPages() {
      return Math.ceil(this.reviews.length / this.reviewsPerPage);
    }
  },
  mounted() {
    this.fetchUser();
    this.fetchReservations();
    this.fetchReviews();
  },
  methods: {
    async fetchUser() {
      try {
        const res = await axios.get('/api/user');
        this.user = res.data.data ? res.data.data : res.data;
        this.user.password = ''; // Para que el campo quede vacío por defecto
      } catch (e) {
        // Manejo de error
      }
    },
    async fetchReservations() {
      // Llama a tu endpoint real de reservas del usuario
      const res = await axios.get('/api/user/reservations');
      this.reservations = res.data; // o res.data.data si usas successResponse
    },
    async fetchReviews() {
      // Llama a tu endpoint real de reseñas del usuario
      try {
        const res = await axios.get('/api/user/reviews');
        this.reviews = res.data;
      } catch (e) {
        // Manejo de error
      }
    },
    async updateProfile() {
      try {
        await axios.put('/api/user', {
          name: this.user.name,
          surname1: this.user.surname1,
          email: this.user.email,
          password: this.user.password // Solo si el usuario la cambia
        });
        alert('Perfil actualizado');
        this.fetchUser(); // Refresca los datos tras actualizar
      } catch (e) {
        alert('Error al actualizar el perfil');
      }
    },
    goToPage(page) {
      this.currentPage = page;
    },
    goToReviewsPage(page) {
      this.reviewsPage = page;
    },
  }
};
</script>

<style scoped>
.profile-page {
  background: #fff;
  min-height: 100vh;
  font-family: Arial, sans-serif;
}
.profile-main {
  max-width: 1200px;
  margin: 0 auto;
  padding: 30px 0 0 0;
}
.profile-columns {
  display: flex;
  gap: 40px;
  align-items: stretch;
  margin-bottom: 30px;
}

.user-form,
.reservations-section {
  flex: 1 1 0;
  min-width: 340px;
  min-height: 370px;
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 6px 24px rgba(0,191,99,0.10);
  border: none;
  padding: 32px 28px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.form-title {
  font-size: 1.3rem;
  font-weight: bold;
  color: #00bf63;
  margin-bottom: 18px;
  text-align: center;
  letter-spacing: 1px;
}

.form-group {
  display: flex;
  gap: 12px;
  margin-bottom: 12px;
}
.form-group input {
  flex: 1 1 0;
  min-width: 0;
}

.user-form input {
  padding: 12px;
  border: 1.5px solid #e0e0e0;
  border-radius: 8px;
  font-size: 15px;
  margin-bottom: 10px;
  background: #f8f8f8;
  transition: border 0.2s;
}
.user-form input:focus {
  border: 1.5px solid #00bf63;
  outline: none;
}

.form-buttons {
  display: flex;
  gap: 16px;
  margin-top: 18px;
  justify-content: center;
}
.form-buttons button {
  flex: 1 1 0;
  min-width: 0;
  border-radius: 8px;
  font-size: 16px;
  padding: 12px 0;
  font-weight: bold;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}
.btn-green {
  background: #00bf63;
  color: #fff;
  border: none;
  transition: background 0.2s;
}
.btn-green:hover {
  background: #00994d;
}
.btn-outline {
  background: #fff;
  color: #00bf63;
  border: 2px solid #00bf63;
  transition: background 0.2s, color 0.2s;
}
.btn-outline:hover {
  background: #00bf63;
  color: #fff;
}

.reservations-section {
  background: #fff;
  border-radius: 18px;
  box-shadow: 0 6px 24px rgba(0,191,99,0.10);
  border: none;
  padding: 32px 28px;
  display: flex;
  flex-direction: column;
  justify-content: center;
}
.section-title {
  font-size: 1.3rem;
  font-weight: bold;
  color: #00bf63;
  margin-bottom: 18px;
  text-align: center;
  letter-spacing: 1px;
}
.reservations-list {
  display: flex;
  flex-direction: column;
  gap: 18px;
}
.reservation-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #f8f8f8;
  border-radius: 12px;
  padding: 16px 22px;
  font-size: 15px;
  box-shadow: 0 2px 8px rgba(0,191,99,0.07);
  border: 1.5px solid #e0e0e0;
}
.reservation-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
}
.camping-name {
  font-weight: bold;
  font-size: 1.1rem;
  color: #00bf63;
  margin-bottom: 2px;
}
.dates, .people {
  font-size: 0.98rem;
  color: #444;
  display: flex;
  align-items: center;
  gap: 6px;
}
.dates i, .people i {
  color: #00bf63;
}
.web-button {
  background: #00bf63;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 8px;
  font-weight: bold;
  cursor: pointer;
  font-size: 15px;
  transition: background 0.2s;
}
.web-button:hover {
  background: #00994d;
}

.pagination {
  margin-top: 16px;
  text-align: center;
  display: flex;
  justify-content: center;
  gap: 8px;
}
.pagination button {
  background: #fff;
  border: 1.5px solid #00bf63;
  color: #00bf63;
  margin: 0 2px;
  padding: 6px 14px;
  border-radius: 6px;
  cursor: pointer;
  font-size: 15px;
  font-weight: bold;
  transition: background 0.2s, color 0.2s;
}
.pagination .active,
.pagination button:focus,
.pagination button:hover {
  background: #00bf63;
  color: #fff;
  outline: none;
}

.reviews-section {
  margin-top: 10px;
}
.reviews-section .section-title {
  color: #222;
  text-align: left;
  margin-left: 0;
}
.reviews-list {
  display: flex;
  gap: 28px;
  margin-top: 18px;
  flex-wrap: wrap;
  justify-content: center;
}
.review-card {
  background: #f8f8e8;
  border-radius: 14px;
  padding: 22px 18px;
  min-width: 260px;
  max-width: 330px;
  box-shadow: 0 2px 8px rgba(0,191,99,0.07);
  border: 1.5px solid #e3e3c7;
  flex: 1 1 0;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}
.review-header {
  display: flex;
  justify-content: space-between;
  width: 100%;
  color: #222;
  font-weight: bold;
  font-size: 16px;
  margin-bottom: 6px;
}
.review-header .camping-name {
  color: #222 !important;
}
.review-date {
  font-size: 13px;
  color: #888;
  margin-bottom: 8px;
}
.review-text {
  font-size: 15px;
  color: #444;
}
.footer-divider {
  width: 90%;
  height: 3px;
  background-color: #00bf63;
  margin: 20px auto;
}
</style>
