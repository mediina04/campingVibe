<template>
  <div class="home-container">
    
    <!-- Sección de Búsqueda -->
    <section class="search-section">
    <div class="search-box">
      <div class="search-title">BÚSQUEDA</div>
      <div class="search-fields">
        <input v-model="searchQuery" type="text" placeholder="Nombre camping, país, provincia" />
        <div class="date-inputs">
          <input v-model="arrivalDate" type="date" />
          <input v-model="departureDate" type="date" />
        </div>
        <input v-model="people" type="number" placeholder="Personas" />
        <button class="web-button" @click="searchCampings">BUSCAR</button>
      </div>
    </div>
  </section>

    <div class="campings-container">
  <!-- Sección de Campings Destacados -->
  <section class="featured-campings">
    <h2 class="section-title">CAMPINGS DESTACADOS</h2>
    <div class="campings-content">
      <div class="campings-list">
        <div class="camping-card" v-for="camping in campings" :key="camping.id">
          <img :src="camping.image" :alt="camping.name" class="camping-image" />
          <div class="camping-info">
            <h3 class="camping-name">{{ camping.name }}</h3>
            <p class="camping-address">{{ camping.address }}</p>
            <p class="camping-rating"><strong>{{ camping.rating }} / 5</strong></p>
          </div>
          <div class="camping-price">
            <p class="price-text">Desde <strong>{{ camping.price }} €</strong> noche</p>
            <button class="web-button">WEB CAMPING</button>
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
          src="https://www.google.com/maps/embed/v1/place?key=TU_CLAVE_API&q=España"
          allowfullscreen>
        </iframe>
      </div>
    </div>
  </section>
</div>

    <!-- Barra separadora -->
    <div class="footer-divider"></div>

  </div>
</template>

<script>
export default {
data() {
  return {
    campings: [
      {
        id: 1,
        name: "Tamarit Beach Resort",
        address: "Carretera N-340A. Km 1.172, 43008 Tarragona.",
        rating: 4.5,
        price: 44,
        image: "/images/tamarit.png"
      },
      {
        id: 2,
        name: "Camping & Resort Sangulí Salou",
        address: "Vial de Cavet (T-325), 43840 Salou, Tarragona",
        rating: 4.8,
        price: 120,
        image: "/images/sanguli.png"
      },
      {
        id: 3,
        name: "Camping Capfun - El Escorial",
        address: "M-600, km 3, 500, 28280 El Escorial, Madrid",
        rating: 4.3,
        price: 28,
        image: "/images/escorial.png"
      }
    ]
  };
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
  margin-top: 0;
  width: 100vw;
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

.search-fields {
  display: flex;
  align-items: center;
  gap: 12px;
  width: 100%;
}

.search-box input {
  padding: 10px;
  border: 2px solid #00bf63;
  border-radius: 10px;
  outline: none;
  font-size: 14px;
  font-weight: normal;
  color: black;
  width: 100%;
  gap: 15px;
}

.search-fields input[type="text"] {
  flex: 1;
}

.search-fields input[type="number"] {
    flex: 0.5; 
    min-width: 80px;
    text-align: left;
    margin-left: -10px;
}

.search-fields::placeholder {
  color: black;
}

.date-inputs {
  display: flex;
  gap: 0;
}

.date-inputs input {
  width: 48%;
  padding: 10px;
  border-radius: 0;
  border-left: none;
  appearance: none;
}

.date-inputs input:first-child {
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;
  border-left: 2px solid #00bf63;
}

.date-inputs input:last-child {
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
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
}

.web-button:hover {
background: white;
color: #00bf63;
border: 2px solid #00bf63;
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
flex: 1;
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
}

.price-text {
color: #00bf63;
font-size: 16px;
font-weight: bold;
margin-bottom: 5px;
}

/* Estilos para el mapa */
.map-container {
width: 40%;
height: 400px;
border-radius: 10px;
overflow: hidden;
box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Barra separadora */
.footer-divider {
width: 90%;
height: 3px;
background-color: #00bf63;
margin: 20px auto;
}

/* Barra separadora */
.footer-divider {
width: 90%;
height: 3px;
background-color: #00bf63;
margin: 20px auto;
}

</style>
