<template>
  <site-template>
    <span slot="principal">
      <h4>Edição de Aluguel</h4>
      <form @submit.prevent="updateRent">

        <div class="row">
          <div class="col s6">
            <select class="browser-default" v-model="selectedUser" name="selectedUser">
              <option v-for="user in users" :value="user.usuario_id" :selected="user.usuario_id === selectedUser">
                {{ user.nome }}
              </option>
            </select>
             <p class="text-danger">{{ formatErrorMessage(errors.selectedUser) }}</p>

          </div>

            <div class="col s6">
            <select class="browser-default" v-model="selectedBook" name="selectedBook">
              <option v-for="book in books" :value="book.livro_id" :selected="book.livro_id === selectedBook">
                {{ book.nome_livro }}
              </option>
            </select>
             <p class="text-danger">{{ formatErrorMessage(errors.selectedUser) }}</p>

          </div>
             <p class="text-danger">{{ formatErrorMessage(errors.selectedUser) }}</p>

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

        <button class="btn green darken-1">Atualizar</button>
      </form>
    </span>
  </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate';
import axios from 'axios';

export default {
  name: 'EditRent',
  data() {
    return {
      selectedUser: null,
      selectedBook: null,
      dt_aluguel_ini: '',
      dt_aluguel_fim: '',
      users: [],
      books: [],
      errors: {},
    };
  },
  created() {
    this.getRentDetails();
    this.getUsers();
    this.getBooks();
  },
  methods: {
    async getRentDetails() {
    const rentId = this.$route.params.id;
    let url = `http://127.0.0.1:8000/api/rent/edit/${rentId}`;

    try {
      const response = await axios.get(url);
      if (response.status === 200) {
        this.selectedUser = response.data.usuario_id; // Defina o ID do usuário selecionado
        this.selectedBook = response.data.livro_id;
        this.dt_aluguel_ini = response.data.dt_aluguel_ini;
        this.dt_aluguel_fim = response.data.dt_aluguel_fim;
      }
    } catch (error) {
      console.error(error);
    }
  },
    async updateRent() {
      this.errors = {};
      const rentId = this.$route.params.id;
      let url = `http://127.0.0.1:8000/api/rent/update/${rentId}`;

      try {
        const response = await axios.put(url, {
          selectedUser: this.selectedUser,
          selectedBook: this.selectedBook,
          dt_aluguel_ini: this.dt_aluguel_ini,
          dt_aluguel_fim: this.dt_aluguel_fim,
        });
        if (response.status === 200) {
          this.$router.push({ name: 'IndexRent' });
        }
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        } else {
          console.error(error);
        }
      }
    },
    getUsers() {
      axios.get('http://127.0.0.1:8000/api/index')
        .then(response => {
          this.users = response.data.user;
        })
        .catch(error => {
          console.error(error);
        });
    },
    getBooks() {
      axios.get('http://127.0.0.1:8000/api/book/index')
        .then(response => {
          this.books = response.data.book;
        })
        .catch(error => {
          console.error(error);
        });
    },
    formatErrorMessage(error) {
      if (Array.isArray(error) && error.length > 0) {
        return error[0];
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