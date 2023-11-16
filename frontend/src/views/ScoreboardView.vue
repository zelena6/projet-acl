<template>
  <div class="table-responsive">
    <h1>Scoreboard</h1>
    <br />
    <table class="tableModif">
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
    <br />
    <router-link to="/">Retour au menu</router-link>
  </div>
</template>

<style>
.tableModif {
  overflow-y: scroll;
  display: block;
  border-collapse: separate;
  border-spacing: 1 1em;
  border: 1px solid black;
  border-radius: 10px;
  background-color: aliceblue;
  font-size: 20px;
  font-weight: bold;
  font-family: 'Courier New', Courier, monospace;
  text-align: center;
  margin: auto;
  width: 60vh;
  padding: 10px;
  height: 50vh;
}
</style>

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
