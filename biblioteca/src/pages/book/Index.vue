<template>
  <site-template>
    <span slot="principal">
      <publicar-conteudo-vue />
      <card-conteudo-vue />
      <h4>Livros</h4>

      <router-link :to="{ name: 'CreateBook' }" class="btn green darken-1 " id="cadBook">Cadastrar</router-link>

      <div class="container">
        <div class="row">

          <div class="col-lg-12">
            <div class="page-header"></div>
            <div class="bs-component">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Criado</th>
                    <th scope="col">Atualizado</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="books.length === 0">
                    <td colspan="6">Não há Livros cadastrados.</td>
                  </tr>
                  <tr v-for="book in books" :key="book.livro_id">
                    <td>{{ book.livro_id }}</td>
                    <td>{{ book.nome_livro }}</td>
                    <td>{{ book.created_at }}</td>
                    <td>{{ book.updated_at }}</td>

                    <td>
                    <router-link :to="{ name: 'EditBook', params: { id: book.livro_id } }" class="custom-btn btn yellow darken-1">Editar</router-link>
                    </td>
                    <td>

                      <!-- Botão para chamar o método de exclusão -->
                      <button @click="destroyBook(book.livro_id)" class="custom-btn btn red darken-1">Excluir</button>
                    </td>

                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </span>
  </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'
import axios from 'axios';

export default {
  name: 'IndexBook',
  data() {
    return {
      books: [] // Corrigido para books (plural)
    }
  },
  created() {
    this.getBooks();
  },
  methods: {
    async getBooks() {
      let url = 'http://127.0.0.1:8000/api/book/index';
      try {
        const response = await axios.get(url);
        this.books = response.data.book; // Assumindo que os dados dos usuários estão em response.data.book
        console.log(this.books);
      } catch (error) {
        console.error(error);
      }
    },
    async destroyBook(id) {
      const confirmed = window.confirm("Tem certeza de que deseja excluir este Livro?");
      if (!confirmed) {
        return; // Se o usuário cancelar, não faz nada.
      }
      let url = `http://127.0.0.1:8000/api/book/destroy/${id}`;
      try {
        const response = await axios.delete(url);
        if (response.data.code === 200) {
          alert(response.data.message);
          this.getBooks();
        }
      } catch (error) {
        console.error(error);
      }
    }
  },
  mounted() {
    console.log('Lista de Livros');
  },
  components: {
    SiteTemplate,
  }
}
</script>

<style scoped>
.custom-btn {
    font-size: 10px;
    padding: 1px 20px; /* Ajuste a largura e altura conforme necessário */
  }

  #cadBook {
    font-size: 10px;
    padding: 1px 20px; /* Ajuste a largura e altura conforme necessário */
  }
</style>
