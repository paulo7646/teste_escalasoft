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

        <v-divider class="my-4" />

        <!-- Depósito -->
        <h3>Depósito</h3>
        <v-row>
          <v-col v-for="valor in valoresCedulas" :key="valor" cols="3">
            <v-text-field v-model.number="deposito[valor]" :label="'R$' + valor" type="number" min="0" />
          </v-col>
        </v-row>
        <v-btn color="green" class="mt-2" @click="realizarDeposito">Depositar</v-btn>

        <v-divider class="my-4" />

        <!-- Saque -->
        <h3>Saque</h3>
        <v-text-field v-model.number="valorSaque" label="Valor para saque" type="number" min="1" />
        <v-btn color="red" class="mt-2" @click="realizarSaque">Sacar</v-btn>

        <v-alert class="mt-4" v-if="mensagem" :type="mensagemTipo" dismissible>{{ mensagem }}</v-alert>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Swal from 'sweetalert2'

const total = ref(0)
const estoque = ref({})
const mensagem = ref('')
const mensagemTipo = ref('info')
const valorSaque = ref(null)
const valoresCedulas = [200, 100, 50, 20, 10, 5, 2]
const deposito = ref({})

// Inicializa campos de depósito
valoresCedulas.forEach((v) => (deposito.value[v] = 0))

const carregarDados = async () => {
  const resTotal = await axios.get('./api/total.php')
  total.value = resTotal.data.total
  const resEstoque = await axios.get('./api/estoque.php')
  estoque.value = resEstoque.data
}

const realizarDeposito = async () => {
  if (deposito.value != null && deposito.value !== '' && Number(deposito.value) > 0) {
    try {
      await axios.post('./api/depositar.php', deposito.value)
      showAlert('success', 'Depósito realizado com sucesso!')
      await carregarDados()
    } catch (error) {
      showAlert('error', 'Erro ao realizar depósito.')
      console.error(error)
    }
  } else {
    showAlert('error', 'Insira a quantidade de notas para o depósito!')
  }
}

const realizarSaque = async () => {

  if (valorSaque.value != null && valorSaque.value !== '' && Number(valorSaque.value) > 0) {
    try {
      const res = await axios.post('./api/sacar.php', { valor: valorSaque.value })
      showAlert(res.data.sucesso ? 'success' : 'error', res.data.mensagem)
      await carregarDados()
    } catch (error) {
      showAlert('error', 'Erro ao realizar saque.')
      console.error(error)
    }
  } else {
    showAlert('error', 'Insira um valor para o deposito !')
  }
}

function showAlert(type = "error", message) {
  if (type == "error") {
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });
    Toast.fire({
      icon: "error",
      title: message,
    });
  } else {
    const Toast = Swal.mixin({
      toast: true,
      position: "top-end",
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
      }
    });
    Toast.fire({
      icon: "success",
      title: message,
    });
  }

}

onMounted(() => carregarDados())
</script>
