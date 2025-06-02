<template>
  <div class="home-container">
    <!-- Sección de Búsqueda -->
    <section class="search-section">
      <div class="search-box">
        <div class="search-title">BÚSQUEDA</div>
        <div class="search-fields">
          <div class="field-group">
            <input v-model="searchQuery" type="text" placeholder="Nombre Camping, Ciudad, Provincia" />
          </div>
          <div class="field-group date-inputs">
            <input
              v-model="arrivalDate"
              :type="typeArrival"
              placeholder="Fecha llegada"
              min="{{ today }}"
              @focus="typeArrival = 'date'"
              @blur="typeArrival = 'text'"
            />
            <input
              v-model="departureDate"
              :type="typeDeparture"
              placeholder="Fecha salida"
              :min="arrivalDate || today"
              @focus="typeDeparture = 'date'"
              @blur="typeDeparture = 'text'"
            />
          </div>
          <div class="field-group">
            <input v-model="people" type="number" placeholder="Personas" min="1" />
          </div>
          <div class="field-group">
            <button
              class="web-button"
              :disabled="!canSearch"
              @click="goToSearchResults"
            >BUSCAR</button>
          </div>
        </div>
        <div v-if="!validDates && arrivalDate && departureDate" class="error-msg">
          Las fechas seleccionadas no son válidas.
        </div>
      </div>
    </section>

        <div class="campings-container">
  <!-- Sección de Campings Destacados -->
  <section class="featured-campings">
    <h2 class="section-title">CAMPINGS DESTACADOS</h2>
    <div class="campings-content">
      <div class="campings-list">
        <!-- Dentro de la lista de campings -->
        <div
  class="camping-card"
  v-for="camping in campings"
  :key="camping.id"
  @click="$router.push({ name: 'campings.show', params: { id: camping.id } })"
  style="cursor:pointer"
>
          <img :src="camping.image" :alt="camping.name" class="camping-image" />
          <div class="camping-info">
            <h3 class="camping-name">{{ camping.name }}</h3>
            <p class="camping-address">{{ camping.address }}</p>
            <p class="camping-rating"><strong>{{ camping.rating }} / 5</strong></p>
          </div>
          <div class="camping-price">
            <p class="price-text">Desde <strong>{{ camping.price }} €</strong> noche</p>
            <a
              v-if="camping.web"
              :href="camping.web"
              target="_blank"
              class="web-button"
            >WEB CAMPING</a>
            <button v-else class="web-button" disabled style="opacity: 0.5; cursor: not-allowed;">
              WEB NO DISPONIBLE
            </button>
          </div>
        </div>

      </div>

      <!-- Barra separadora -->
      <div class="separator-bar"></div>

      <!-- Mapa -->
      <div class="map-container">
        <iframe
          width="100%"
          height="100%"
          frameborder="0"
          style="border:0"
          referrerpolicy="no-referrer-when-downgrade"
          src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBwoXNHQAsvDqvdG3qJ0-MGYieC85E8T8E&q=España"
          allowfullscreen>
        </iframe>
      </div>
    </div>
  </section>
</div>

    <!-- Separador -->
    <div class="footer-divider"></div>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script>
import Footer from '@/layouts/AppFooter.vue'

export default {
  components: { Footer },
  data() {
    return {
      campings: [],
      searchQuery: '',
      arrivalDate: '',
      departureDate: '',
      people: '',
      typeArrival: 'text',
      typeDeparture: 'text',
      today: new Date().toISOString().slice(0, 10)
    };
  },
  mounted() {
    this.loadFeaturedCampings();
  },
  computed: {
    validDates() {
      if (!this.arrivalDate || !this.departureDate) return true;
      const today = this.today;
      return (
        this.arrivalDate >= today &&
        this.departureDate >= today &&
        this.arrivalDate < this.departureDate
      );
    },
    canSearch() {
      return (
        this.searchQuery.trim() !== '' &&
        this.arrivalDate.trim() !== '' &&
        this.departureDate.trim() !== '' &&
        this.people !== '' &&
        this.validDates
      );
    }
  },
  methods: {
    goToSearchResults() {
      if (!this.canSearch) return;
      this.$router.push({
        name: 'searchResults',
        query: {
          q: this.searchQuery,
          arrival: this.arrivalDate,
          departure: this.departureDate,
          people: this.people
        }
      });
    },
    async loadFeaturedCampings() {
      try {
        const response = await fetch('/api/campings/destacados');
        const json = await response.json();

        this.campings = json.data.map(camping => ({
          ...camping,
          address: camping.location || 'Dirección no disponible',
          rating: camping.rating || (Math.random() * 2 + 3).toFixed(1),
          price: Math.floor(Math.random() * 50) + 20,
          web: camping.website_url || null
        }));

      } catch (error) {
        console.error('Error al cargar campings destacados:', error);
      }
    }
  }
};
</script>

<style scoped>
.home-container {
  font-family: Arial, sans-serif;
  text-align: center;
  background: #ffffff;
}

.search-section {
  background: url('/images/fondo-busq.png') no-repeat center center/cover;
  padding: 25px;
  height: 350px;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.search-box {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  width: 80%;
  max-width: 1200px;
  background: white;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}

.search-title {
  font-size: 22px;
  font-weight: bold;
  color: #00bf63;
  text-transform: uppercase;
  text-align: center;
}

.search-section {
  display: flex;
  justify-content: center;
  padding: 20px;
}

.search-box {
  width: 100%;
  max-width: 1000px;
}

.search-fields {
  display: flex;
  gap: 12px;
  width: 100%;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
}

.field-group {
  flex: 1;
  display: flex;
}

.search-fields input {
  padding: 10px;
  border: 2px solid #00bf63;
  border-radius: 10px;
  font-size: 14px;
  color: #00bf63;
  width: 100%;
}

.search-fields:focus {
  outline: none;
  border-color: #00bf63;
}

.date-inputs {
  display: flex;
  gap: 0;
}

.date-inputs input {
  padding: 10px;
  border: 2px solid #00bf63;
  border-radius: 0;
  appearance: none;
}

.date-inputs input:first-child {
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;
}

.date-inputs input:last-child {
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
}

input::placeholder {
  color: #00bf63;
}

.web-button {
  background: #00bf63;
  color: white;
  font-weight: bold;
  border: 2px solid #00bf63;
  cursor: pointer;
  padding: 12px 20px;
  border-radius: 10px;
  transition: 0.3s ease;
  white-space: nowrap;
}

.web-button:hover {
  background: white;
  color: #00bf63;
  border: 2px solid #00bf63;
}

.field-group:last-child {
  flex: none;
}


.campings-container {
display: flex;
flex-direction: column;
align-items: center;
background: white;
padding: 20px;
}

.featured-campings {
width: 100%;
max-width: 1200px;
}

.section-title {
color: #00bf63;
font-weight: bold;
font-size: 24px;
margin-bottom: 15px;
text-align: left;
}

.campings-content {
display: flex;
gap: 20px;
}

.campings-list {
  display: flex;
  flex-direction: column;
  gap: 15px;
  flex: 1 1 auto;
  height: 400px; /* Igual que el mapa */
  overflow-y: auto;
  padding-right: 10px;
}

/* Scroll personalizado para campings-list */
.campings-list::-webkit-scrollbar {
  width: 8px;
}

.campings-list::-webkit-scrollbar-track {
  background: transparent;
  border-radius: 10px;
}

.campings-list::-webkit-scrollbar-thumb {
  background-color: #00bf63;
  border-radius: 10px;
  border: 2px solid white;
}

/* Firefox */
.campings-list {
  scrollbar-color: #00bf63 transparent;
  scrollbar-width: thin;
}


.separator-bar {
width: 4px;
height: 100%; /* Grosor de la barra */
background-color: #00bf63; /* Color verde */
margin: 15px 0; /* Espaciado arriba y abajo */
border-radius: 2px;
}

.camping-card {
display: flex;
align-items: stretch; /* Asegura que la imagen y el contenido ocupen la misma altura */
background: white;
border-radius: 10px;
box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
border: 1px solid #00bf63;
overflow: hidden; /* Evita que la imagen sobresalga */
flex-shrink: 0;
}

.camping-image {
width: 120px; /* Ajusta el ancho según necesites */
height: auto; /* Permite que la imagen se ajuste correctamente */
flex-shrink: 0; /* Evita que la imagen se deforme si el contenido crece */
border-radius: 10px 0 0 10px; /* Bordes redondeados solo en el lado izquierdo */
object-fit: cover;
}

.camping-info {
flex: 1;
text-align: left;
padding-left: 20px;
margin-top: 15px;
}

.camping-name {
font-size: 18px;
font-weight: bold;
}

.camping-address {
font-size: 14px;
color: #666;
}

.camping-rating {
font-size: 16px;
font-weight: bold;
}

.camping-price {
text-align: right;
min-width: 140px;
padding-right: 15px;
margin-top: 15px;
margin-bottom: 20px;
}

.price-text {
color: #00bf63;
font-size: 16px;
font-weight: bold;
margin-bottom: 20px;
}

.map-container {
  width: 40%;
  height: 400px;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.footer-divider {
  width: 90%;
  height: 3px;
  background-color: #00bf63;
  margin: 20px auto;
}

.error-msg {
  color: #d32f2f;
  font-weight: bold;
  margin-top: 10px;
}
</style>
