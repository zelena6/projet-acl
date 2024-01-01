<template>
  <div id="rulesDialog">
    <div class="modal-content" style="background-color:azure; padding: 3%; border-radius: 5%;">
      <div class="modal-header">
        <h2 class="modal-title">Règles du jeu de cartes</h2>
      </div>
      <div class="modal-body">
        <br />

        <p>
          Le score du joueur est calculé en fonction de la combinaison de ces
          cartes :
        </p>
        <ul>
          <li class="custom-li">
            ● Si les cartes ont des valeurs et des couleurs différentes, ajoutez
            la somme de leurs valeurs au score.
          </li>
          <li class="custom-li">
            ● Si les cartes ont la même valeur mais des couleurs différentes,
            soustrayez la somme de leurs valeurs du score.
          </li>
          <li class="custom-li">
            ● Si les cartes ont la même valeur et la même couleur, soustrayez le
            double de la somme de leurs valeurs du score.
          </li>
        </ul>
        <p>Les valeurs des cartes sont prédéfinies :</p>
        <ul>
          <li class="custom-li">● As : 11 points</li>
          <li class="custom-li">● 10 : 10 points</li>
          <li class="custom-li">● Roi : 4 points</li>
          <li class="custom-li">● Dame : 3 points</li>
          <li class="custom-li">● Valet : 2 points</li>
          <li class="custom-li">● 9, 8 et 7 : 0 points</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button @click="closeDialog" class="btn btn-danger">Fermer</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
.custom-li {
  list-style: none;
}
</style>

<script>
export default {
  name: 'RulesDialog',
  methods: {
    closeDialog() {
      this.$emit('close-rules');
    },
  },
};
</script>
