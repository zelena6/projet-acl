<template>
  <div class="container text-center align-items mt-3">
    <!-- Header Row -->
    <div class="row text-center align-items-center mb-5">
      <div class="col">
        <h4>Tour {{ tour }}</h4>
      </div>
      <div class="col">
        <h4>{{ score }}</h4>
      </div>
      <div class="col">
        <button class="btn btn-danger" @click="handleAbandonnerClick">
          Abandonner
        </button>
      </div>
    </div>

    <!-- Image Rows -->
    <div class="row mb-5">
      <div class="col-md-6">
        <img
          id="card1"
          src="../assets/boardgamePack_v2/PNG/Cards/cardBack_blue3.png"
          @click="handleImageClick1"
          class="img-fluid img-thumbnail"
        />
      </div>
      <div class="col-md-6">
        <img
          id="card2"
          src="../assets/boardgamePack_v2/PNG/Cards/cardBack_blue3.png"
          @click="handleImageClick2"
          class="img-fluid img-thumbnail"
        />
      </div>
    </div>

    <!-- Button Row -->
    <div class="row justify-content-center mt-4 mb-3">
      <div class="col">
        <button class="btn btn-primary btn-lg" @click="drawTwoCards">
          Piocher 2 cartes
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue';
import { ref } from 'vue';
import { useRoute } from 'vue-router';

export default defineComponent({
  name: 'GameView',
  data() {
    return {
      score: 0,
      tour: 1,
      donneesTour: [],
    };
  },
  setup() {
    const serverResponse = ref('');
    const route = useRoute();
    const username = route.params.username;

    const fetchServerData = async () => {
      try {
        const response = await fetch(
          'http://localhost:8888/game/' + username + '/play'
        );
        if (response.ok) {
          const data = await response.text();
          serverResponse.value = data;
        } else {
          throw new Error('Erreur de connexion !');
        }
      } catch (error) {
        console.error('Erreur de connexion !');
        console.error(error);
      }
    };

    fetchServerData(); // Appel initial lors de la création du composant

    return {
      serverResponse,
      username,
      fetchServerData, // Ajoutez fetchServerData aux données renvoyées par le setup
    };
  },

  methods: {
    handleAbandonnerClick() {
      // Gérer l'événement de clic sur le bouton Abandonner
    },
    async handleImageClick1() {
      const dataOfServerResponse = JSON.parse(this.serverResponse);

      const card1 = dataOfServerResponse.cards[0];
      let card1Value = card1.value;

      switch (card1Value) {
        case 11:
          card1Value = 'J';
          break;
        case 12:
          card1Value = 'Q';
          break;
        case 13:
          card1Value = 'K';
          break;
        case 14:
          card1Value = 'A';
          break;
        // Ajoutez d'autres cas au besoin
      }

      const card1Shape = card1.shape;
      const card1Color = card1.color;
      // Supposons que card1Shape contienne la valeur, par exemple, "hearts"
      const firstLetter = card1Shape.charAt(0).toUpperCase(); // Obtenez la première lettre en majuscule
      const restOfString = card1Shape.slice(1); // Obtenez le reste de la chaîne
      const card1ShapeCapitalized = firstLetter + restOfString; // Concaténez-les

      const card1Image = 'card' + card1ShapeCapitalized + card1Value + '.png';
      document.getElementById('card1').src =
        '../../src/assets/boardgamePack_v2/PNG/Cards/' + card1Image;
    },
    async handleImageClick2() {
      const dataOfServerResponse = JSON.parse(this.serverResponse);

      this.score = dataOfServerResponse.score;

      const card1 = dataOfServerResponse.cards[1];
      let card1Value = card1.value;

      switch (card1Value) {
        case 11:
          card1Value = 'J';
          break;
        case 12:
          card1Value = 'Q';
          break;
        case 13:
          card1Value = 'K';
          break;
        case 14:
          card1Value = 'A';
          break;
        // Ajoutez d'autres cas au besoin
      }

      const card1Shape = card1.shape;
      const card1Color = card1.color;
      // Supposons que card1Shape contienne la valeur, par exemple, "hearts"
      const firstLetter = card1Shape.charAt(0).toUpperCase(); // Obtenez la première lettre en majuscule
      const restOfString = card1Shape.slice(1); // Obtenez le reste de la chaîne
      const card1ShapeCapitalized = firstLetter + restOfString; // Concaténez-les

      const card1Image = 'card' + card1ShapeCapitalized + card1Value + '.png';
      document.getElementById('card2').src =
        '../../src/assets/boardgamePack_v2/PNG/Cards/' + card1Image;
    },
    async drawTwoCards() {
      await this.fetchServerData();
      document.getElementById('card1').src =
        '../../src/assets/boardgamePack_v2/PNG/Cards/cardBack_blue3.png';
      document.getElementById('card2').src =
        '../../src/assets/boardgamePack_v2/PNG/Cards/cardBack_blue3.png';
      this.tour++;
    },
  },
});
</script>
