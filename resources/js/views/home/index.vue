<template>
    <div class="home-container">
      
      <!-- Sección de Búsqueda -->
      <section class="search-section">
        <div class="search-box">
          <div class="search-title">BÚSQUEDA</div>
          <div class="search-fields">
            <input type="text" placeholder="Nombre camping, país, provincia" class="green-placeholder" />
            <div class="date-inputs">
              <input type="date" placeholder="Llegada" class="green-placeholder" />
              <input type="date" placeholder="Salida" class="green-placeholder" />
            </div>
            <input type="number" placeholder="Personas" class="green-placeholder" />
            <button class="web-button">BUSCAR</button>
          </div>
        </div>
      </section>
  
      <!-- Sección de Campings Destacados -->
      <section class="featured-campings">
        <h2>CAMPINGS DESTACADOS</h2>
        <div class="campings-list">
          <div class="camping-card" v-for="camping in campings" :key="camping.id">
            <img :src="camping.image" alt="Camping Image" />
            <div class="camping-info">
              <h3>{{ camping.name }}</h3>
              <p>{{ camping.address }}</p>
              <p class="rating"> {{ camping.rating }} / 5</p>
              <p class="price">Desde {{ camping.price }} € noche</p>
              <button class="web-button">WEB CAMPING</button>
            </div>
          </div>
        </div>
      </section>
  
      <!-- Pie de Página -->
      <footer class="footer">
        <div class="about">
          <h3>ACERCA DE</h3>
          <p>Somos una plataforma dedicada a conectar a los amantes del camping con los mejores destinos...</p>
        </div>
        <div class="contact">
          <h3>CONTACTO</h3>
          <p>contacto@campingvibe.com</p>
          <p>+34 623 456 789</p>
          <button class="web-button">Mensaje</button>
        </div>
      </footer>
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
            address: "Carretera N-340A, Km 1.172, 43008 Tarragona",
            rating: 4.5,
            price: 44,
            image: "/images/tamarit.png"
          },
          {
            id: 2,
            name: "Camping & Resort Sangulí Salou",
            address: "Vial de Cavet T-325, 43840 Salou, Tarragona",
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
    color: #00bf63;
    width: 100%;
  }

  .green-placeholder::placeholder {
    color: #00bf63;
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
  
  .featured-campings {
    margin: 20px;
    text-align: left;
  }
  
  .campings-list {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
  }
  
  .camping-card {
    background: white;
    margin: 10px;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: left;
  }
  
  .camping-card img {
    width: 100%;
    border-radius: 10px;
  }
  
  .price {
    color: #00bf63;
    font-weight: bold;
  }
  
  .footer {
    display: flex;
    justify-content: space-around;
    background: #00bf63;
    color: white;
    padding: 20px;
    margin-top: 20px;
  }
  
  .contact-button {
    background: #00bf63;
  }
  </style>
  