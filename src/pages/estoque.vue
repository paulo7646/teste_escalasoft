<template>
  <v-container>
    <v-card class="pa-4">
      <v-card-title>Caixa Eletrônico</v-card-title>
      <v-card-text>
        <!-- Total -->
        <v-alert type="info">Total disponível: R$ {{ total }}</v-alert>
        <!-- Estoque -->
        <v-table>
          <thead>
            <tr>
              <th>Valor</th>
              <th>Quantidade</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(qtde, valor) in estoque" :key="valor">
              <td>R$ {{ valor }}</td>
              <td>{{ qtde }}</td>
            </tr>
          </tbody>
        </v-table>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const total = ref(0)
const estoque = ref({})
const valoresCedulas = [200, 100, 50, 20, 10, 5, 2]

const carregarDados = async () => {
  const resTotal = await axios.get('/api/total.php')
  total.value = resTotal.data.total

  const resEstoque = await axios.get('/api/estoque.php')
  console.log(resEstoque.data)
  estoque.value = resEstoque.data
}

onMounted(() => carregarDados())
</script>
