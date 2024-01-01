<template>
  <div class="container-fluid" style="width: 50vw; height: 70vh;">
    <h1>Scoreboard</h1>
    <br />
    <br />
    <!-- Rechercher un joueur -->
    <div class="input-group mb-3">
      <input
        type="text"
        class="form-control"
        placeholder="Rechercher un joueur"
        maxlength="10"
        v-model="searchQuery"
      />
      <button class="btn btn-success" type="button" @click="search">Rechercher</button>
    </div>
    <p v-if="!playerFound" style="color: red;">Joueur non trouvé</p>

    <br />
    <table class="table" ref="scoreboard">
      <thead>
        <tr>
          <th scope="col">Rang</th>
          <th scope="col">Pseudo</th>
          <th scope="col">Score</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sb in displayedScoreboard" :key="sb.rank">
          <th scope="row">{{ sb.rank }}</th>
          <td>{{ sb.username }}</td>
          <td>{{ sb.score }}</td>
        </tr>
      </tbody>
    </table>
    <br />
    <p>Page : {{ currentPage }} sur {{ pages.length }}</p>
    <div class="navigation-buttons" style="justify-content: center; display: flex; align-items: center;">
      <button id="btnPrev" class="btn btn-primary" @click="navigate('prev')" :disabled="currentPage === 1" style="margin: 1%;">← </button>
  <button id="btnNext" class="btn btn-primary" :disabled="currentPage===pages.length" @click="navigate('next')" style="margin: 1%;"> →</button>
    </div>
    <router-link to="/" class="btn">
  <button class="btn btn-primary">Retour au menu</button>
</router-link>

  </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'ScoreboardView',
  data() {
    return {
      scoreboard: [],
      pages: [],
      contentPage: [],
      searchQuery: '',
      currentPage: 1,
      step: 10,
      playerFound: true,
    };
  },
  computed: {
    displayedScoreboard() {
      return this.contentPage;
    },
  },
  methods: {
    async fetchScoreboard() {
      const response = await fetch('http://localhost:8888/scoreboard');
      if (response.ok) {
        const data = await response.json();
        this.scoreboard = data;
        this.scoreboard.forEach((sb, index) => {
          sb.rank = index + 1;
        });
        this.top10 = this.scoreboard.slice(0, 10);
      } else {
        console.error('Erreur de connexion !');
      }
      for (let i = 0; i < this.scoreboard.length; i += 10) {
        this.pages.push(this.scoreboard.slice(i, i + 10));
      }
      this.contentPage = this.pages[this.currentPage - 1];

      console.log(this.scoreboard.length);
    },
    search() {
      const player = this.scoreboard.find(sb => sb.username.toLowerCase() === this.searchQuery.toLowerCase());
      if (player) {
        // afficher la page où se trouve le joueur
        this.currentPage = Math.ceil(player.rank / 10);
        this.contentPage = this.pages[this.currentPage - 1];
        this.playerFound = true;
      } else {
        this.playerFound = false;
      }
    },
    navigate(direction) {
      if (direction === 'prev') {
        this.currentPage -= 1;
        this.contentPage = this.pages[this.currentPage - 1];
      }
      if (direction === 'next') {
        this.currentPage += 1;
        this.contentPage = this.pages[this.currentPage - 1];
      }

    },
  },
  mounted() {
    this.fetchScoreboard();
  },
});
</script>
