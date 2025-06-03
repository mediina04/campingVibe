<template>
  <div class="search-results-root">
    <!-- Barra de búsqueda centrada -->
    <div class="search-bar">
      <span class="search-label">TU BÚSQUEDA:</span>
      <input v-model="searchQuery" type="text" class="search-input" />
      <div class="date-inputs">
        <input v-model="arrivalDate" type="text" class="search-input date-left" placeholder="" />
        <input v-model="departureDate" type="text" class="search-input date-right" placeholder="" />
      </div>
      <input v-model="people" type="text" class="search-input" />
      <button class="search-btn" @click="buscar">BUSCAR</button>
    </div>

    <div class="main-content">
      <!-- Mapa a la izquierda -->
      <div class="map-section">
        <div id="map" style="width: 100%; height: 100%;"></div>
      </div>
      <!-- Resultados a la derecha -->
      <div class="results-section">
        <div v-if="campings.length === 0" class="no-results-msg">
          No se han encontrado campings para tu búsqueda.
        </div>
        <div v-else class="campings-list">
          <div
            class="camping-card"
            v-for="camping in paginatedCampings"
            :key="camping.id"
            @click="$router.push({ name: 'campings.show', params: { id: camping.id } })"
            style="cursor:pointer"
          >
            <img :src="camping.image" :alt="camping.name" class="camping-image" />
            <div class="camping-info">
              <h3 class="camping-name">{{ camping.name }}</h3>
              <p class="camping-address">{{ camping.location }}</p>
              <p class="camping-rating"><strong>{{ camping.rating ?? 'N/A' }} / 5</strong></p>
            </div>
            <div class="camping-price">
              <p class="price-text">
                <span v-if="camping.price !== null">Desde <strong>{{ camping.price }} €</strong> noche</span>
                <span v-else>No disponible</span>
              </p>
              <a
                v-if="camping.web"
                :href="camping.web"
                target="_blank"
                class="web-button"
              >WEB CAMPING</a>
              <button
                v-else
                class="web-button"
                disabled
                style="opacity: 0.5; cursor: not-allowed;"
              >WEB NO DISPONIBLE</button>
            </div>
          </div>
        </div>
        <!-- Paginación -->
        <div class="pagination" v-if="campings.length > 0">
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

    <div class="footer-divider"></div>
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
      currentPage: 1,
      perPage: 4,
      map: null,
      markers: []
    };
  },
  computed: {
    paginatedCampings() {
      const start = (this.currentPage - 1) * this.perPage;
      return this.campings.slice(start, start + this.perPage);
    },
    totalPages() {
      return Math.ceil(this.campings.length / this.perPage);
    }
  },
  mounted() {
    // Sincroniza los inputs con los parámetros de la URL al cargar
    this.syncInputsWithQuery();
    this.fetchCampings().then(() => {
      this.initMap();
    });
  },
  watch: {
    // Si cambian los parámetros de la URL, actualiza los inputs y los resultados
    '$route.query': {
      handler() {
        this.syncInputsWithQuery();
        this.fetchCampings().then(() => {
          if (this.map) this.updateMarkers();
        });
      },
      immediate: false
    }
  },
  methods: {
    syncInputsWithQuery() {
      this.searchQuery = this.$route.query.q || '';
      this.arrivalDate = this.$route.query.arrival || '';
      this.departureDate = this.$route.query.departure || '';
      this.people = this.$route.query.people || '';
    },
    async fetchCampings() {
      try {
        const params = new URLSearchParams(this.$route.query).toString();
        const response = await fetch(`http://localhost:8000/api/campings?${params}`);
        const json = await response.json();

        this.campings = json.data.map(camping => ({
          ...camping,
          address: camping.location || 'Dirección no disponible',
          image: camping.image || '/images/default-camping.jpg',
          rating: camping.rating_avg ?? 'N/A',
          price: (camping.accommodations && camping.accommodations.length > 0)
            ? Math.min(...camping.accommodations.map(a => parseFloat(a.price_per_night)))
            : null,
          web: camping.website_url || null
        }));

        // Si el mapa ya está inicializado, actualiza los marcadores
        if (this.map) {
          this.updateMarkers();
        }
      } catch (error) {
        console.error('Error al cargar campings:', error);
      }
    },
    initMap() {
      // Centra el mapa en España
      this.map = new window.google.maps.Map(document.getElementById('map'), {
        center: { lat: 40.4637, lng: -3.7492 },
        zoom: 6
      });
      this.updateMarkers();
    },
    updateMarkers() {
      // Limpia marcadores anteriores
      if (this.markers) {
        this.markers.forEach(marker => marker.setMap(null));
      }
      this.markers = [];

      // Añade un marcador por cada camping
      this.campings.forEach(camping => {
        if (camping.latitude && camping.longitude) {
          const marker = new window.google.maps.Marker({
            position: { lat: parseFloat(camping.latitude), lng: parseFloat(camping.longitude) },
            map: this.map,
            title: camping.name
          });

          // InfoWindow opcional
          const infowindow = new window.google.maps.InfoWindow({
            content: `<strong>${camping.name}</strong><br>${camping.location}`
          });
          marker.addListener('click', function() {
            infowindow.open(this.map, marker);
          });

          this.markers.push(marker);
        }
      });
    },
    buscar() {
      // Actualiza la URL con los nuevos parámetros y recarga resultados
      this.$router.push({
        name: this.$route.name,
        query: {
          q: this.searchQuery,
          arrival: this.arrivalDate,
          departure: this.departureDate,
          people: this.people
        }
      });
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
.search-results-root {
  background: #fff;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
.search-bar {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  background: #fff;
  padding: 36px 40px 36px 40px;
  font-size: 20px;
  font-weight: bold;
  margin-bottom: 18px;
}
.search-label {
  color: #222;
  margin-right: 10px;
  font-size: 22px;
  font-weight: bold;
  letter-spacing: 1px;
}
.search-input {
  border: 2px solid #00bf63;
  border-radius: 8px;
  padding: 8px 12px;
  font-size: 16px;
  width: 120px;
}
.date-inputs {
  display: flex;
}
.date-left {
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
  border-right: none;
}
.date-right {
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
}
.search-btn {
  background: #00bf63;
  color: #fff;
  border: 2px solid #00bf63; /* <-- Añade el borde aquí */
  border-radius: 8px;
  padding: 10px 24px;
  font-weight: bold;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.2s, color 0.2s, border 0.2s;
  box-shadow: 0 2px 8px rgba(0,191,99,0.08);
}
.search-btn:hover {
  background: #fff;
  color: #00bf63;
  /* El borde ya está en el estado normal, así que no cambia el tamaño */
}

.main-content {
  display: flex;
  flex: 1;
  gap: 24px;
  padding: 0 40px 0 40px;
}
.map-section {
  width: 38%;
  min-width: 320px;
  height: 500px;
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0,0,0,0.08);
  background: #eee;
}
.results-section {
  flex: 1;
  display: flex;
  flex-direction: column;
}
.campings-list {
  display: flex;
  flex-direction: column;
  gap: 18px;
  margin-bottom: 24px;
}
.camping-card {
  display: flex;
  align-items: stretch;
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
  border: 1.5px solid #00bf63;
  overflow: hidden;
  min-height: 110px;
}
.camping-image {
  width: 120px;
  height: 100%;
  object-fit: cover;
  border-radius: 10px 0 0 10px;
}
.camping-info {
  flex: 1;
  text-align: left;
  padding: 18px 0 0 18px;
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

.web-button {
  margin-top: 0; /* Sin margen extra */
  background: #00bf63;
  color: white;
  font-weight: bold;
  border: 2px solid #00bf63;
  cursor: pointer;
  padding: 8px 16px;
  border-radius: 10px;
  transition: 0.3s ease;
}
.web-button:hover {
  background: white;
  color: #00bf63;
  border: 2px solid #00bf63;
}
.pagination {
  display: flex;
  justify-content: center;
  gap: 8px;
  margin-bottom: 24px;
}
.pagination button {
  background: #fff;
  border: 2px solid #00bf63;
  color: #00bf63;
  border-radius: 8px;
  padding: 6px 16px;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.2s;
}
.pagination button.active,
.pagination button:hover {
  background: #00bf63;
  color: #fff;
}
.footer-divider {
  width: 90%;
  height: 3px;
  background-color: #00bf63;
  margin: 20px auto 0 auto;
}
.no-results-msg {
  color: #00bf63;
  font-weight: bold;
  font-size: 18px;
  margin: 40px 0;
  text-align: center;
}
</style>
