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
      <h4>Cadastro de Usuários</h4>

      <form @submit.prevent="createUser">
        <input type="text" placeholder="Nome" v-model="nome" name="nome" />
        <p class="text-danger">{{ getErrorMessage('nome') }}</p> <!-- Exibe erro de validação para o campo Nome em vermelho -->

        <input type="text" v-mask="'###.###.###-##'" placeholder="Cpf" v-model="cpf" name="cpf" />
        <p class="text-danger">{{ getErrorMessage('cpf') }}</p> <!-- Exibe erro de validação para o campo CPF em vermelho -->

        <button class="btn green darken-1">Adicionar</button>
      </form>
    </span>
  </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'
import axios from 'axios';

export default {
  name: 'CreateUser',
  data() {
    return {
      nome: '',
      cpf: '',
      errors: {}, // Objeto para rastrear erros de validação
    }
  },
  methods: {
    async createUser() {
      this.errors = {}; // Limpa erros anteriores

      let formData = new FormData();
      formData.append('nome', this.nome);
      formData.append('cpf', this.cpf);

      let url = 'http://127.0.0.1:8000/api/store';

      try {
        const response = await axios.post(url, formData);
        console.log(response);
        
        if (response.status === 200) {
          // O usuário foi criado com sucesso
          this.$router.push({ name: 'IndexUser' });

        }
      } catch (error) {
        if (error.response && error.response.status === 422) {
          // Erros de validação foram retornados
          this.errors = error.response.data.errors;
        }
      }
    },
    getErrorMessage(field) {
      if (field in this.errors) {
        return this.errors[field][0]; // Exibe a primeira mensagem de erro para o campo especificado
      }
      return ''; // Retorna uma string vazia se não houver erros
    },
  },
  components: {
    SiteTemplate,
  },
}
</script>

<style scoped>
  .text-danger {
    color: rgb(203, 14, 14);
  }
</style>

