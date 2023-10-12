<template>
  <site-template>
    <span slot="menuesquerdo">
      <div class="row valign-wrapper">
        <grid-vue tamanho="2"></grid-vue>
        <grid-vue tamanho="10">
          <span class="black-text"></span>
        </grid-vue>
      </div>
    </span>

    <span slot="principal">
      <publicar-conteudo-vue />
      <card-conteudo-vue />
      
      <h4>Cadastro de Aluguéis</h4>
      <form @submit.prevent="createRent">
        <div class="row">
          <div class="col s6">
            <select class="browser-default" v-model="selectedUser" name="selectedUser">
              <option value="" disabled selected>Usuário</option>
              <option v-for="user in users" :value="user.usuario_id">{{ user.nome }}</option>
            </select>
            <p class="text-danger">{{ formatErrorMessage(errors.selectedUser) }}</p>
          </div>

          <div class="col s6">
            <select class="browser-default" v-model="selectedBook" name="selectedBook">
              <option value="" disabled selected>Livro</option>
              <option v-for="book in books" :value="book.livro_id">{{ book.nome_livro }}</option>
            </select>
            <p class="text-danger">{{ formatErrorMessage(errors.selectedBook) }}</p>
          </div>
        </div>
        
        <div class="row">
          <div class="col s6">
            <input type="datetime-local" placeholder="Data de início do aluguel" v-model="dt_aluguel_ini" name="dt_aluguel_ini" />
            <p class="text-danger">{{ formatErrorMessage(errors.dt_aluguel_ini) }}</p>
          </div>

          <div class="col s6">
            <input type="datetime-local" placeholder="Data de término do aluguel" v-model="dt_aluguel_fim" name="dt_aluguel_fim" />
            <p class="text-danger">{{ formatErrorMessage(errors.dt_aluguel_fim) }}</p>
          </div>
        </div>

        <button class="btn green darken-1">Adicionar</button>
      </form>
    </span>
  </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate';
import axios from 'axios';

export default {
  name: 'CreateRent',
  data() {
    return {
      selectedUser: '',
      selectedBook: '',
      dt_aluguel_ini: '',
      dt_aluguel_fim: '',
      users: [],
      books: [],
      errors: {},
    };
  },
  created() {
    this.getUsers();
    this.getBooks();
  },
  methods: {
    async createRent() {
      this.errors = {};

      let formData = new FormData();
      formData.append('selectedUser', this.selectedUser);
      formData.append('selectedBook', this.selectedBook);
      formData.append('dt_aluguel_ini', this.dt_aluguel_ini);
      formData.append('dt_aluguel_fim', this.dt_aluguel_fim);

      let url = 'http://127.0.0.1:8000/api/rent/store';
      try {
        const response = await axios.post(url, formData);
        console.log(response);
        if (response.status === 200) {
          this.$router.push({ name: 'IndexRent' });
        }
      } catch (error) {
        if (error.response && error.response.status === 422) {
          // Atualize o objeto "errors" com as mensagens de erro retornadas pelo Laravel.
          this.errors = error.response.data.errors;
        } else {
          console.error(error);
        }
      }
    },
    getUsers() {
      axios.get('http://127.0.0.1:8000/api/index')
        .then(response => {
          this.users = response.data.user; // Certifique-se de acessar a propriedade "user" dos dados
        })
        .catch(error => {
          console.error(error);
        });
    },
    getBooks() {
      axios.get('http://127.0.0.1:8000/api/book/index')
        .then(response => {
          this.books = response.data.book; // Certifique-se de acessar a propriedade "book" dos dados
        })
        .catch(error => {
          console.error(error);
        });
    },
    formatErrorMessage(error) {
    if (Array.isArray(error) && error.length > 0) {
      return error[0]; // Retorna a primeira mensagem de erro da lista
    }
    return error;
  },
    
  },
  components: {
    SiteTemplate,
  },
};
</script>

<style scoped>
.text-danger {
  color: red;
}
</style>