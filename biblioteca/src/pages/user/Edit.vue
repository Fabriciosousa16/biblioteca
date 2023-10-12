<template>
  <site-template>
    <span slot="menuesquerdo">
      <div class="row valign-wrapper">
        <grid-vue tamanho="2">

        </grid-vue>
        <grid-vue tamanho="10">

          <span class="black-text">

          </span>
        </grid-vue>
      </div>
    </span>

<span slot="principal">
  <h4>Edição de Usuário</h4>

  <form @submit.prevent="updateUser">
  <input type="text" placeholder="Nome" v-model="nome" name="nome" />
  <p class="text-danger">{{ getErrorMessage('nome') }}</p>
  
  <input type="text" v-mask="'###.###.###-##'" placeholder="Cpf" v-model="cpf" name="cpf" />
  <p class="text-danger">{{ getErrorMessage('cpf') }}</p>
  
  <button class="btn green darken-1">Atualizar</button>
</form>
</span>
</site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'
import axios from 'axios'

export default {
name: 'EditUser',
data() {
return {
    nome: '', // Inicialize com uma string vazia ou com os dados existentes
    cpf: '', // Inicialize com uma string vazia ou com os dados existentes
    errors: {}, // Objeto para rastrear erros de validação
}
},
created() {
// Carregue os dados do usuário a ser editado
this.getUserById();
this.loadUserData(this.$route.params.id); // Use o parâmetro da rota para obter o ID do usuário a ser editado
const userId = this.$route.params.id;
  console.log(userId); 


},
methods: {
  async getUserById() {
      let url = `http://127.0.0.1:8000/api/edit/${this.$route.params.id}`;
      try {
        const response = await axios.get(url);
        if (response.status === 200) {
          this.nome = response.data.nome; // Renomeado para nomeUpt
          this.cpf = response.data.cpf;
        }
      } catch (error) {
        console.error(error);
      }
  },

  async loadUserData(userId) {
    try {
      const response = await axios.get(`http://127.0.0.1:8000/api/user/${userId}`);
      if (response.status === 200) {
        this.nome = response.data.nome;
        this.cpf = response.data.cpf;
      }
    } catch (error) {
      console.error(error);
    }
  },
async updateUser() {
  this.errors = {} // Limpe os erros anteriores

  let url = `http://127.0.0.1:8000/api/update/${this.$route.params.id}`; // Rota de atualização

  try {
    const response = await axios.put(url, {
      'nome': this.nome,
      'cpf': this.cpf
    })

    if (response.status === 200) {
      // O usuário foi atualizado com sucesso
      this.$router.push({ name: 'IndexUser' })
    }
  } catch (error) {
    if (error.response && error.response.status === 422) {
      // Erros de validação foram retornados
      this.errors = error.response.data.errors
    }
  }
},
getErrorMessage(field) {
  if (field in this.errors) {
    return this.errors[field][0]
  }
  return ''
},
},
components: {
SiteTemplate,
},
}
</script>

<style scoped>
.text-danger {
color: rgb(203, 14, 14)
}
</style>