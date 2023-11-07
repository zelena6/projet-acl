<template>
  <div id="game" style="display: ">
    <div class="container text-center align-items mt-3">
      <button
        id="btnRegle"
        class="btn btn-primary btn-lg"
        style="margin-bottom: 15%"
        @click="showRulesDialog = true"
        v-if="!showRulesDialog"
      >
        Règles du jeu
      </button>
      <RulesDialog
        v-if="showRulesDialog"
        @close-rules="showRulesDialog = false"
      />
    </div>
    <div class="container text-center align-items mt-3" v-if="!showRulesDialog">
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
            @click="handleImageClick(1)"
            class="img-fluid img-thumbnail"
          />
        </div>
        <div class="col-md-6">
          <img
            id="card2"
            src="../assets/boardgamePack_v2/PNG/Cards/cardBack_blue3.png"
            @click="handleImageClick(2)"
            class="img-fluid img-thumbnail"
          />
        </div>
      </div>

      <!-- Button Row -->
      <div class="row justify-content-center mt-4 mb-3">
        <div class="col">
          <button
            id="btnPiocher"
            class="btn btn-primary btn-lg"
            @click="drawTwoCards"
            :disabled="true"
          >
            Piocher 2
          </button>
        </div>
      </div>
    </div>
  </div>

  <div id="end-view" style="display: none">
    <div class="container text-center align-items mt-3 mb-3">
      <h4>Tour : {{ tour }}</h4>
      <h4>Score : {{ score }}</h4>
    </div>
    <router-link :to="'/'">
      <button class="btn btn-primary btn-lg btn-block">Continuer</button>
    </router-link>
  </div>
</template>

<script>
import { defineComponent } from 'vue';
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import RulesDialog from '../components/Rules.vue';

export default defineComponent({
  name: 'GameView',
  data() {
    return {
      score: 0,
      tour: 1,
      card1: false,
      card2: false,
      card1Clickable: true,
      card2Clickable: true,
      showRulesDialog: false,
    };
  },
  components: {
    RulesDialog,
  },
  setup() {
    const serverResponse = ref('');
    const route = useRoute();
    const username = route.params.username;

    const fetchServerData = async () => {
      let retries = 3;
      while (retries > 0) {
        try {
          const response = await fetch(
            'http://localhost:8888/game/' + username + '/play'
          );
          if (response.ok) {
            const data = await response.text();
            serverResponse.value = data;
            break;
          } else {
            throw new Error('Erreur de connexion !');
          }
        } catch (error) {
          console.error('Erreur de connexion !');
          console.error(error);
          retries--;
        }
      }
    };

    fetchServerData();

    return {
      serverResponse,
      username,
      fetchServerData,
    };
  },

  methods: {
    handleAbandonnerClick() {},

    async handleImageClick(cardNumber) {
      if (this.tour <= 5 && this['card' + cardNumber + 'Clickable']) {
        const dataOfServerResponse = JSON.parse(this.serverResponse);

        const card = dataOfServerResponse.cards[cardNumber - 1]; // Utilisez cardNumber pour sélectionner la carte 1 ou 2
        let cardValue = card.value;

        switch (cardValue) {
          case 11:
            cardValue = 'J';
            break;
          case 12:
            cardValue = 'Q';
            break;
          case 13:
            cardValue = 'K';
            break;
          case 14:
            cardValue = 'A';
            break;
        }

        const cardShape = card.shape;
        const firstLetter = cardShape.charAt(0).toUpperCase();
        const restOfString = cardShape.slice(1);
        const cardShapeCapitalized = firstLetter + restOfString;

        const cardImage = 'card' + cardShapeCapitalized + cardValue + '.png';
        document.getElementById('card' + cardNumber).src =
          '../../src/assets/boardgamePack_v2/PNG/Cards/' + cardImage;

        if (cardNumber === 1) {
          this.card1 = true;
          this.card1Clickable = false;
        } else if (cardNumber === 2) {
          this.card2 = true;
          this.card2Clickable = false;
        }

        if (this.card1 && this.card2) {
          if (this.tour == 1) {
            this.score = dataOfServerResponse.score;
          } else {
            this.score += dataOfServerResponse.score;
          }
          document.getElementById('btnPiocher').disabled = false;

          if (this.tour === 5) {
            document.getElementById('btnPiocher').disabled = true;
            setTimeout(() => {
              document.getElementById('game').style.display = 'none';
              document.getElementById('end-view').style.display = 'block';
            }, 1000);
          }
        }
      }
    },
    async drawTwoCards() {
      await this.fetchServerData();
      document.getElementById('card1').src =
        '../../src/assets/boardgamePack_v2/PNG/Cards/cardBack_blue3.png';
      document.getElementById('card2').src =
        '../../src/assets/boardgamePack_v2/PNG/Cards/cardBack_blue3.png';
      this.tour++;
      if (this.card1 != true || this.card2 != true) {
        document.getElementById;
      }
      this.card1 = false;
      this.card2 = false;

      this.card1Clickable = true;
      this.card2Clickable = true;
      document.getElementById('btnPiocher').disabled = true;
    },
    showRules() {
      this.showRulesDialog = true;
    },

    closeRulesDialog() {
      this.showRulesDialog = false;
    },
  },
});
</script>
