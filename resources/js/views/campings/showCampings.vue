<template>
  <div class="camping-detail-container" v-if="camping">
    <div class="camping-header">
      <div class="camping-collage" v-if="camping.images && camping.images.length">
        <img
          v-for="(img, index) in camping.images.slice(0, 4)"
          :key="index"
          :src="img"
          class="collage-img"
          :alt="`Imagen ${index + 1}`"
        />
      </div>
      <div class="camping-main-info">
        <h1 class="camping-title">{{ camping.name }}</h1>
        <p class="camping-location">{{ camping.location }}</p>
        <div class="camping-rating-row">
          <div class="camping-rating">
            <span class="rating-value">{{ camping.rating ?? 'N/A' }}</span>
            <span class="rating-max">/ 5</span>
          </div>
        </div>
        <a
          v-if="camping.website_url"
          :href="camping.website_url"
          target="_blank"
          class="web-button-big"
        >WEB CAMPING</a>
      </div>
    </div>

    <div class="camping-description-section">
      <h2>Descripción</h2>
      <p class="camping-description">{{ camping.description }}</p>
    </div>

    <!-- SECCIÓN DE RESERVA -->
    <div class="reservation-section">
      <div class="reservation-form">
        <h2 class="reservation-title">RESERVA TU ESTANCIA</h2>
        <select v-model="reservation.type" class="reservation-input">
          <option>Bungalow</option>
          <option>Parcela</option>
        </select>
        <div class="field-group date-inputs">
            <input
              v-model="arrivalDate"
              :type="typeArrival"
              placeholder="Llegada"
              min="{{ today }}"
              @focus="typeArrival = 'date'"
              @blur="typeArrival = 'text'"
            />
            <input
              v-model="departureDate"
              :type="typeDeparture"
              placeholder="Salida"
              :min="arrivalDate || today"
              @focus="typeDeparture = 'date'"
              @blur="typeDeparture = 'text'"
            />
          </div>
        <input v-model="reservation.people" type="number" min="1" class="reservation-input" placeholder="Personas" />
        <button class="price-btn" @click="calculatePrice" :disabled="!canCalculatePrice">CALCULAR PRECIO</button>
        <div v-if="priceError" class="form-error">{{ priceError }}</div>      
      </div>
      <div class="reservation-summary">
        <div class="summary-title">RESUMEN DE TU RESERVA</div>
        <div class="summary-info">
          <div>
            <div class="summary-camping">{{ camping.name }}</div>
            <div class="summary-address">{{ camping.location }}</div>
          </div>
          <div>
            <div class="summary-dates">
              {{ reservation.arrival || 'Fecha llegada' }} - {{ reservation.departure || 'Fecha salida' }}
            </div>
            <div>
              <span class="summary-people">
                {{ reservation.people }} {{ reservation.people == 1 ? 'persona' : 'personas' }}
              </span>
              <span class="summary-type">{{ reservation.type }}</span>
            </div>
          </div>
        </div>
        <div class="summary-bottom">
          <div class="summary-total">
            <span>TOTAL:</span>
            <span class="summary-price" v-if="showPrice">{{ price }} €</span>
          </div>
          <div class="reserve-btn-wrapper">
            <button class="reserve-btn" :disabled="!canCalculatePrice">RESERVA</button>
          </div>
        </div>
      </div>
    </div>

    <!-- SECCIÓN DE RESEÑAS -->
    <div class="reviews-section">
      <div class="reviews-content">
        <div class="review-form">
          <h2 class="review-title">DEJA TU RESEÑA</h2>
          <input v-model="review.name" type="text" class="review-input" placeholder="Nombre" />
          <textarea v-model="review.text" class="review-input" placeholder="Reseña"></textarea>
          <div class="review-rating-stars">
            <span
              v-for="star in 5"
              :key="star"
              class="star"
              :class="{ filled: review.rating >= star }"
              @click="review.rating = star"
            >★</span>
            <span class="review-rating-value">{{ review.rating }} / 5</span>
          </div>
          <div class="review-btn-wrapper">
            <button class="publish-btn">PUBLICAR</button>
          </div>
        </div>
        <div class="reviews-list">
          <div class="review-card" v-for="r in paginatedReviews" :key="r.id">
            <div class="review-header">
              <span class="review-author">{{ r.name }}</span>
              <span class="review-rating">{{ r.rating }} / 5</span>
              <span class="review-date">{{ r.date }}</span>
            </div>
            <div class="review-text">{{ r.text }}</div>
          </div>
          <div class="pagination">
            <button @click="prevPage" :disabled="currentPage === 1">&lt;</button>
            <button
              v-for="page in totalPages"
              :key="page"
              :class="{ active: currentPage === page }"
              @click="goToPage(page)"
            >{{ page }}</button>
            <button @click="nextPage" :disabled="currentPage === totalPages">&gt;</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-else>
    <p>Cargando información del camping...</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      camping: null,
      today: new Date().toISOString().slice(0, 10),
      reservation: {
        type: 'Bungalow',
        arrival: '',
        departure: '',
        people: 1,
      },
      showDatepickerType: null,
      price: null,
      showPrice: false,
      review: {
        name: '',
        text: '',
        rating: 5,
      },
      reviews: [
        { id: 1, name: 'Montoya', date: '25 / 01 / 2025', text: 'Camping estupendo, parcela large, personal buenísimo...', rating: 5 },
        { id: 2, name: 'Naomi', date: '7 / 11 / 2024', text: 'Muy bonito y muy chulo este camping...', rating: 4.5 },
        { id: 3, name: 'Petri', date: '31 / 12 / 2023', text: 'De los mejores campings que he estado...', rating: 5 },
      ],
      currentPage: 1,
      perPage: 3,
      typeArrival: 'text',
      typeDeparture: 'text',
      arrivalDate: '',
      departureDate: '',
    };
  },
  computed: {
    paginatedReviews() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.reviews.slice(start, start + this.perPage);
    },
    totalPages() {
      return Math.ceil(this.reviews.length / this.perPage);
    },
    priceError() {
    if (!this.reservation.type) return 'Selecciona tipo de alojamiento.';
    if (!this.arrivalDate) return 'Selecciona la fecha de llegada.';
    if (!this.departureDate) return 'Selecciona la fecha de salida.';
    if (!this.reservation.people || this.reservation.people < 1) return 'Indica el número de personas.';
    if (this.arrivalDate && this.departureDate && this.arrivalDate > this.departureDate) return 'La fecha de salida debe ser posterior a la de llegada.';
    return '';
    },
    canCalculatePrice() {
      return (
        this.reservation.type &&
        this.arrivalDate &&
        this.departureDate &&
        this.reservation.people > 0 &&
        this.arrivalDate <= this.departureDate
      );
    }
  },
  mounted() {
    this.fetchCamping();
  },
  methods: {
    async fetchCamping() {
      const id = this.$route.params.id;
      try {
        const response = await fetch(`/api/campings/${id}`);
        const json = await response.json();
        this.camping = json.data;
      } catch (error) {
        console.error('Error al cargar el camping:', error);
      }
    },
    showDatepicker(type) {
      // Aquí puedes abrir un datepicker externo si usas uno, o usar un modal, etc.
      // Por defecto, solo borra el valor para que el usuario escriba la fecha.
      this.showDatepickerType = type;
      this.reservation[type] = '';
    },
    calculatePrice() {
      // Simulación de cálculo de precio
      this.price = 340;
      this.showPrice = true;
    },
    goToPage(page) {
      this.currentPage = page;
    },
    prevPage() {
      if (this.currentPage > 1) this.currentPage--;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) this.currentPage++;
    }
  }
};
</script>

<style scoped>
.camping-detail-container {
  max-width: 900px;
  margin: 40px auto;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  padding: 32px 24px;
}
.camping-header {
  display: flex;
  gap: 32px;
  align-items: flex-start;
  margin-bottom: 32px;
}
.camping-collage {
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: 1fr 1fr;
  gap: 10px;
  width: 320px;
  height: 320px;
}
.collage-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 12px;
}
.camping-main-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 10px;
  justify-content: flex-start;
}
.camping-title {
  font-size: 2.1rem;
  font-weight: bold;
  margin: 0;
}
.camping-location {
  color: #666;
  font-size: 1.1rem;
  margin-bottom: 10px;
}
.camping-rating-row {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 0;
}
.camping-rating {
  font-size: 1.2rem;
  font-weight: bold;
  color: #00bf63;
}
.rating-value {
  font-size: 1.5rem;
}
.rating-max {
  color: #222;
  font-size: 1.1rem;
  margin-left: 2px;
}
.web-button-big {
  background: #00bf63;
  color: white;
  font-weight: bold;
  border: 2px solid #00bf63;
  border-radius: 8px;
  font-size: 1rem;
  padding: 6px 18px;
  text-decoration: none;
  transition: 0.2s;
  margin-top: 14px;
  display: inline-block;
  width: auto;
  min-width: 120px;
  max-width: 180px;
}
.web-button-big:hover {
  background: white;
  color: #00bf63;
  border: 2px solid #00bf63;
}
.camping-description-section {
  margin-top: 32px;
}
.camping-description-section h2 {
  font-size: 1.3rem;
  font-weight: bold;
  margin-bottom: 10px;
}
.camping-description {
  font-size: 1.1rem;
  color: #444;
  line-height: 1.6;
}
.reservation-section {
  display: flex;
  gap: 28px;
  margin-bottom: 36px;
  margin-top: 28px;
}
.reservation-form {
  background: #f8f8f8;
  border-radius: 12px;
  padding: 18px 16px;
  display: flex;
  flex-direction: column;
  gap: 14px;
  min-width: 260px;
  max-width: 260px;
  position: relative;
}
.reservation-title {
  font-size: 1.2rem;
  font-weight: bold;
  color: #00bf63;
  margin-bottom: 16px;
  text-align: center;
  letter-spacing: 1px;
}
.reservation-label {
  display: flex;
  flex-direction: column;
  font-size: 1rem;
  font-weight: 500;
  color: #666;
  margin-bottom: 0;
  margin-top: 8px;
}
.reservation-input {
  border: 1.5px solid #00bf63;
  border-radius: 7px;
  padding: 10px 14px;
  font-size: 16px;
  width: 100%;
  margin-bottom: 0;
  background: #fff;
  height: 40px;
  box-sizing: border-box;
}
.field-group.date-inputs {
  display: flex;
  gap: 0;
  margin-top: 0;
  width: 100%;
}

.date-inputs input {
  flex: 1 1 0;
  min-width: 0;
  padding: 10px 14px;
  border: 1.5px solid #00bf63;
  border-radius: 0;
  font-size: 16px;
  background: #fff;
  height: 40px;
  box-sizing: border-box;
}

.date-inputs input:first-child {
  border-top-left-radius: 7px;
  border-bottom-left-radius: 7px;
}

.date-inputs input:last-child {
  border-top-right-radius: 7px;
  border-bottom-right-radius: 7px;
  border-left: none;
}

.date-inputs input::placeholder {
  color: #00bf63;
}

/* Asegura que el grupo no sobresalga */
.reservation-form .field-group.date-inputs {
  width: 100%;
  max-width: 100%;
}

.price-btn {
  background: #fff;
  color: #00bf63;
  border: 2px solid #00bf63;
  border-radius: 8px;
  font-weight: bold;
  padding: 10px 0;
  cursor: pointer;
  transition: 0.2s;
  font-size: 1rem;
  margin-top: 10px;
}
.price-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.price-btn:hover:enabled {
  background: #00bf63;
  color: #fff;
}
.reservation-summary {
  flex: 1;
  background: #f8f8f8;
  border-radius: 12px;
  padding: 28px 32px;
  display: flex;
  flex-direction: column;
  gap: 18px;
  min-width: 340px;
}
.summary-title {
  color: #00bf63;
  font-weight: bold;
  font-size: 1.35rem;
  margin-bottom: 14px;
  text-align: center;
  letter-spacing: 1px;
}
.summary-info {
  display: flex;
  justify-content: space-between;
  font-size: 1.15rem;
  margin-bottom: 16px;
  gap: 18px;
  flex-wrap: wrap;
}
.summary-camping {
  font-weight: bold;
  font-size: 1.12rem;
}
.summary-people {
  font-weight: bold;
  color: #00bf63;
  margin-right: 6px;
  font-size: 1.13rem;
}
.summary-type {
  color: #bfa063;
  margin-left: 4px;
  font-size: 1.13rem;
}
.summary-dates {
  font-size: 1.13rem;
}
.summary-total {
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: bold;
  font-size: 1.35rem;
  margin-top: 12px;
  gap: 18px;
}
.summary-price {
  color: #00bf63;
  font-size: 1.5rem;
  margin-left: 8px;
}
.summary-bottom {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
}
.reserve-btn-wrapper {
  display: flex;
  justify-content: center;
  width: 100%;
}
.reserve-btn {
  background: #00bf63;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  padding: 12px 36px;
  font-size: 1.13rem;
  cursor: pointer;
  transition: 0.2s;
  margin-top: 10px;
}
.reserve-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
.reserve-btn:hover:enabled {
  background: #fff;
  color: #00bf63;
  border: 2px solid #00bf63;
}
.reviews-section {
  margin-top: 48px;
}
.reviews-content {
  display: flex;
  gap: 28px;
}
.review-form {
  background: #f8f8f8;
  border-radius: 12px;
  padding: 18px 16px;
  display: flex;
  flex-direction: column;
  gap: 14px;
  min-width: 260px;
  max-width: 260px;
  position: relative;
  align-items: stretch;
}
.review-title {
  font-size: 1.1rem;
  font-weight: bold;
  color: #bfa063;
  margin-bottom: 10px;
  text-align: center;
  letter-spacing: 1px;
}
.review-input {
  border: 1.5px solid #bfa063;
  border-radius: 7px;
  padding: 10px 14px;
  font-size: 16px;
  width: 100%;
  margin-bottom: 0;
  background: #fff;
  box-sizing: border-box;
}
.review-form textarea.review-input {
  min-height: 60px;
  resize: vertical;
}
.review-rating-stars {
  display: flex;
  align-items: center;
  gap: 2px;
  margin-top: 10px;
  margin-bottom: 4px;
  justify-content: flex-start;
}
.star {
  font-size: 1.7rem;
  color: white;
  -webkit-text-stroke: 2px #ffb400;
  cursor: pointer;
  transition: color 0.2s;
  background: transparent;
  padding: 0 2px;
  border: none;
}
.star.filled {
  color: #ffb400;
  -webkit-text-stroke: 2px #ffb400;
}
.review-rating-value {
  margin-left: 8px;
  font-size: 1.1rem;
  color: #bfa063;
  font-weight: bold;
}
.review-btn-wrapper {
  display: flex;
  justify-content: center;
  width: 100%;
}
.publish-btn {
  background: #bfa063;
  color: #fff;
  border: none;
  border-radius: 8px;
  font-weight: bold;
  padding: 9px 20px;
  font-size: 1rem;
  cursor: pointer;
  transition: 0.2s;
}
.publish-btn:hover {
  background: #fff;
  color: #bfa063;
  border: 2px solid #bfa063;
}
.reviews-list {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.review-card {
  background: #f8f8f8;
  border-radius: 10px;
  padding: 16px 20px;
  margin-bottom: 6px;
}
.review-header {
  display: flex;
  justify-content: space-between;
  font-weight: bold;
  margin-bottom: 6px;
  font-size: 1.08rem;
}
.review-author {
  color: #bfa063;
}
.review-date {
  color: #888;
  font-size: 0.98em;
}
.review-rating {
  color: #ffb400;
}
.review-text {
  font-size: 1.09em;
  color: #444;
}
.pagination {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin-top: 10px;
}
.pagination button {
  background: #fff;
  border: 2px solid #bfa063;
  color: #bfa063;
  border-radius: 8px;
  padding: 4px 14px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.2s;
}
.pagination button.active,
.pagination button:hover {
  background: #bfa063;
  color: #fff;
}
.field-group {
  display: flex;
  gap: 12px;
  margin-top: 12px;
}
.date-input {
  flex: 1;
}
</style>