// resources/js/views/admin/campings/Index.vue
<template>
  <div>
    <h1>Listado de Campings</h1>
    <router-link to="/admin/campings/create">Nuevo Camping</router-link>
    <table>
      <tr v-for="camping in campings" :key="camping.id">
        <td>{{ camping.nombre }}</td>
        <td>
          <router-link :to="`/admin/campings/${camping.id}/edit`">Editar</router-link>
        </td>
      </tr>
    </table>
  </div>
</template>
<script>
export default {
  data() {
    return { campings: [] }
  },
  mounted() {
    // Llama a tu API para obtener los campings
  }
}
</script>