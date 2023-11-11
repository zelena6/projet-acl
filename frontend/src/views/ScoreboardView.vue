<template>
  <div>
    <h1>Scoreboard</h1>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Rang</th>
          <th scope="col">Pseudo</th>
          <th scope="col">Score</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="sb in scoreboard" :key="sb.rank">
          <th scope="row">{{ sb.rank }}</th>
          <td>{{ sb.username }}</td>
          <td>{{ sb.score }}</td>
        </tr>
      </tbody>
    </table>

    <router-link to="/">Retour au menu</router-link>
  </div>
</template>

<script>
import { defineComponent } from 'vue';

export default defineComponent({
  name: 'ScoreboardView',
  data() {
    return {
      scoreboard: [],
    };
  },
  methods: {
    async fetchScoreboard() {
      const response = await fetch('http://localhost:8888/scoreboard');
      if (response.ok) {
        const data = await response.json();
        this.scoreboard = data;
        console.log(data);
      } else {
        console.error('Erreur de connexion !');
      }
    },
  },
  mounted() {
    this.fetchScoreboard();
  },
});
</script>
