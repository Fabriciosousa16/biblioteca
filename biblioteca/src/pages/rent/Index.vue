<template>
  <site-template>
    <span slot="principal">
      <publicar-conteudo-vue />
      <card-conteudo-vue />
      <h4>Alugueis</h4>

      <router-link :to="{ name: 'CreateRent' }" class="btn green darken-1 " id="cadRent">Cadastrar</router-link>
      <button class="custom-btn btn grey lighten-1" @click="exportRentsToTxt">Exportar</button>

      <div class="container">
        <div class="row">

          <div class="col-lg-12">
            <div class="page-header"></div>
            <div class="bs-component">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Usuário</th>
                    <th scope="col">Livro</th>
                    <th scope="col">Inicio</th>
                    <th scope="col">Fim</th>
                    <th scope="col">Criado</th>
                    <th scope="col">Atualizado</th>
                    <th scope="col">Ações</th>

                  </tr>
                </thead>
                <tbody>
                  <tr v-if="rentals.length === 0">
                    <td colspan="6">Não há Alugueis cadastrados.</td>
                  </tr>
                  <tr v-for="rent in rentals" :key="rent.aluguel_id">
                    <td>{{ rent.aluguel_id }}</td>
                    <td>{{ rent.users.nome }}</td>
                    <td>{{ rent.books.nome_livro }}</td>
                    <td>{{ rent.dt_aluguel_ini }}</td>
                    <td>{{ rent.dt_aluguel_fim }}</td>
                    <td>{{ rent.created_at }}</td>
                    <td>{{ rent.updated_at }}</td>

                    <td>
                    <router-link :to="{ name: 'EditRent', params: { id: rent.aluguel_id } }" class="custom-btn btn yellow darken-1">Editar</router-link>
                    
                    </td>
                   <!-- <button class="custom-btn btn grey lighten-1"><a :href="exportRentsUrl" download="alugueis.txt">Exportar Aluguéis</a></button> -->

                    <td>

                      <!-- Botão para chamar o método de exclusão -->
                      <button @click="destroyRent(rent.aluguel_id)" class="custom-btn btn red darken-1">Excluir</button>
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
  name: 'IndexRent',
  data() {
    return {
      rentals: [], // Corrigido para rentals (plural)
      alugueis: [],
      rents: [],
    }
  },
  created() {
    this.getRentals();
   },
  methods: {
    async getRentals() {
      let url = 'http://127.0.0.1:8000/api/rent/index';
      try {
        const response = await axios.get(url);
        this.rentals = response.data.rent; // Assumindo que os dados dos alugueis estão em response.data.rent
        console.log(this.rentals);
      } catch (error) {
        console.error(error);
      }
    },
    async destroyRent(id) {
      const confirmed = window.confirm("Tem certeza de que deseja excluir este Aluguel?");
      if (!confirmed) {
        return; // Se o usuário cancelar, não faz nada.
      }
      let url = `http://127.0.0.1:8000/api/rent/destroy/${id}`;
      try {
        const response = await axios.delete(url);
        if (response.data.code === 200) {
          alert(response.data.message);
          this.getRentals();
        }
      } catch (error) {
        console.error(error);
      }
   
  },

  async exportRentsToTxt() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/rent/export-rents-to-txt');

        if (response.status === 200) {
          // Crie um link de download e clique nele para iniciar o download
          const blob = new Blob([response.data], { type: 'text/plain' });
          const url = window.URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = url;
          a.download = 'alugueis.txt';
          a.click();
          window.URL.revokeObjectURL(url);
        } else {
          console.error('Erro ao exportar aluguéis para .txt');
        }
      } catch (error) {
        console.error(error);
      }
    }

  },
  
  mounted() {
    console.log('Lista de Alugueis');
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

  #cadRent {
    font-size: 10px;
    padding: 1px 20px; /* Ajuste a largura e altura conforme necessário */
  }
</style>
