<template>
  <div class="container">
    <div
      class="row text-center justify-content-center align-items-center vh-100"
    >
      <div class="col-12" v-if="!showRules">
        <img src="../assets/logo2.png" alt="belette" height="150" width="150" />
        <h1 style="font-weight: bold">Belette</h1>
      </div>
      <div class="col-12 mt-2" v-show="!showRules">
        <input
          type="text"
          class="form-control text-center mx-auto w-25"
          id="pseudo"
          placeholder="Pseudo"
          v-model="username"
          @keyup.enter="startGame"
        />
      </div>
      <div class="col-12" v-if="!showRules">
        <router-link :to="'/game/' + username + '/play'">
          <button class="btn btn-success btn-lg btn-block" @click="startGame">
            Jouer
          </button>
        </router-link>
      </div>
      <div class="col-12" v-if="!showRules">
        <router-link :to="'/scoreboard'">
          <button class="btn btn-success btn-lg btn-block">
            Voir classement
          </button>
        </router-link>
      </div>
      <div class="col-12">
        <button
          class="btn btn-success btn-lg btn-block"
          @click="showRules = !showRules"
          v-if="!showRules"
        >
          Règles
        </button>
        <div id="componentContainer">
          <Rules v-if="showRules" @close-rules="showRules = false" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import Rules from '../components/Rules.vue';

export default defineComponent({
  name: 'MenuView',
  components: {
    Rules,
  },
  setup() {
    const serverResponse = ref('');
    const username = ref('');

    const showRules = ref(false);

    const router = useRouter();

    const startGame = () => {
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
      username,
      showRules,
      startGame,
    };
  },
});
</script>
