<template>
  <site-template>
    <span slot="principal">
      <h4>Edição de Livro</h4>
      <form @submit.prevent="updateBook">
        <div class="form-group">
          <label for="nome">Nome</label>
          <input type="text" class="form-control" id="nome" v-model="nome" name="nome" />
          <p class="text-danger">{{ getErrorMessage('nome') }}</p>
        </div>
        <button class="btn green darken-1">Atualizar</button>
      </form>
    </span>
  </site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'
import axios from 'axios'

export default {
  name: 'EditBook',
  data() {
    return {
      nome: '', // Variável para armazenar o nome do livro
      errors: {}, // Objeto para rastrear erros de validação
    }
  },
  created() {
    this.getBookById();
  },
  methods: {
    async getBookById() {
      let url = `http://127.0.0.1:8000/api/book/edit/${this.$route.params.id}`;
      try {
        const response = await axios.get(url);
        if (response.status === 200) {
          this.nome = response.data.nome_livro; 
        }
      } catch (error) {
        console.error(error);
      }
    },
    async updateBook() {
      this.errors = {}
      const bookId = this.$route.params.id

      const url = `http://127.0.0.1:8000/api/book/update/${bookId}`

      try {
        const response = await axios.put(url,{
          nome:this.nome,
        })

        if (response.status === 200) {
          this.$router.push({ name: 'IndexBook' })
        }
      } catch (error) {
        if (error.response && error.response.status === 422) {
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
    color: red;
  }
</style>