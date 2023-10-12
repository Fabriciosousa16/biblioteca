<template>
  <site-template>
    <span slot="principal">

      <h4>Usuários</h4>

      <router-link :to="{ name: 'CreateUser' }" class="btn green darken-1 " id="cadUser">Cadastrar</router-link>

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
                    <th scope="col">Cpf</th>
                    <th scope="col">Criado</th>
                    <th scope="col">Atualizado</th>
                    <th scope="col">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-if="users.length === 0">
                    <td colspan="6">Não há usuários cadastrados.</td>
                  </tr>
                  <tr v-for="user in users" :key="user.usuario_id">
                    <td>{{ user.usuario_id }}</td>
                    <td>{{ user.nome }}</td>
                    <td>{{ user.cpf }}</td>
                    <td>{{ user.created_at }}</td>
                    <td>{{ user.updated_at }}</td>

                    <td>
                      <router-link :to="{ name: 'EditUser', params: { id: user.usuario_id } }"
                        class="custom-btn btn yellow darken-1">Editar</router-link>
                    </td>
                    <td>

                      <!-- Botão para chamar o método de exclusão -->
                      <button @click="destroy(user.usuario_id)" class="custom-btn btn red darken-1">Excluir</button>
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
  name: 'IndexUser',
  data() {
    return {
      users: [] // Corrigido para users (plural)
    }
  },
  created() {
    this.getUsers();
  },
  methods: {
    async getUsers() {
      let url = 'http://127.0.0.1:8000/api/index';
      try {
        const response = await axios.get(url);
        this.users = response.data.user; // Assumindo que os dados dos usuários estão em response.data.user
        console.log(this.users);
      } catch (error) {
        console.error(error);
      }
    },
    async destroy(id) {
      const confirmed = window.confirm("Tem certeza de que deseja excluir este usuário?");
      if (!confirmed) {
        return; // Se o usuário cancelar, não faz nada.
      }
      let url = `http://127.0.0.1:8000/api/destroy/${id}`;
      try {
        const response = await axios.delete(url);
        if (response.data.code === 200) {
          alert(response.data.message);
          this.getUsers();
        }
      } catch (error) {
        console.error(error);
      }
    }
  },
  mounted() {
    console.log('Lista de Usuários');
  },
  components: {
    SiteTemplate,
  }
}
</script>

<style scoped>
.custom-btn {
  font-size: 10px;
  padding: 1px 20px;
  /* Ajuste a largura e altura conforme necessário */
}

#cadUser {
  font-size: 10px;
  padding: 1px 20px;
  /* Ajuste a largura e altura conforme necessário */
}</style>
