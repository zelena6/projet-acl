<template>
  <div class="container">
    <div
      class="row text-center justify-content-center align-items-center vh-100"
    >
      <div class="col-12">
        <h1>Belette</h1>
      </div>
      <div class="col-12 mt-2">
        <!-- Utilisez v-model pour lier l'input à la variable username -->
        <input
          type="text"
          class="form-control text-center mx-auto w-25"
          id="pseudo"
          placeholder="Pseudo"
          v-model="username"
        />
      </div>
      <div class="col-12">
        <router-link :to="'/game/' + username + '/play'">
          <button class="btn btn-primary btn-lg btn-block" @click="createGame">
            Jouer
          </button>
        </router-link>
      </div>
      <div class="col-12">
        <button class="btn btn-primary btn-lg btn-block">
          Voir classement
        </button>
      </div>
      <div class="col-12">
        <button class="btn btn-primary btn-lg btn-block">Règles</button>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

export default defineComponent({
  name: 'MenuView',
  setup() {
    const serverResponse = ref('');
    const username = ref('');

    const router = useRouter();

    const createGame = () => {
      const usernameValue = username.value;
      router.push({ name: 'game', params: { username: usernameValue } });

      fetch('http://localhost:8888/game', {
        method: 'POST',
        body: JSON.stringify({
          username: usernameValue,
        }),
        headers: {
          'Content-Type': 'application/json',
        },
      })
        .then((response) => {
          if (response.ok) {
            return response.text();
          } else {
            throw new Error('Erreur de connexion !');
          }
        })
        .then((data) => {
          serverResponse.value = data;
        })
        .catch((error) => {
          console.error('Erreur de connexion !');
          console.error(error);
        });
    };

    return {
      serverResponse,
      createGame,
      username, // Renvoyez la variable username
    };
  },
});
</script>
