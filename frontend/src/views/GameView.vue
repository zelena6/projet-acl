<template>
  <div id="game" style="display: ; width: 25vw; height: 80vh;">
    <div class="container text-center align-items mt-3">
      <button
        id="btnRegle"
        class="btn btn-success btn-lg mb-5"
        @click="showRulesDialog = true"
        v-if="!showRulesDialog"
      >
        Règles du jeu
      </button>
    </div>
      
    <div
      class="container text-center align-items"
      v-show="!showRulesDialog"
    >
    <button class="btn btn-danger btn-lg mb-5" @click="handleAbandonnerClick">
            Abandonner
    </button>
      <!-- Header Row -->
      <div class="row text-center align-items-center mb-5">
        <div class="col">
          <h4>Tour : {{ tour }}</h4>
        </div>
        <div class="col">
          <h4>Score : {{ score }}</h4>
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
            class="btn btn-success btn-lg"
            @click="drawTwoCards"
            :disabled="true"
          >
            Piocher 2
          </button>
          <button
          id="btnFinPartie"
            class="btn btn-success btn-lg"
            style="display: none;"
          >Continuer</button>
        </div>
      </div>
    </div>
  </div>
  <RulesDialog
      v-if="showRulesDialog"
      @close-rules="showRulesDialog = false"
      class="centered-dialog" 
    />

  <div id="end-view" style="display: none">
    <div class="container text-center align-items mt-3 mb-3">
      <h4>Tour : {{ tour }}</h4>
      <h4>Score : {{ score }}</h4>
    </div>
    <router-link :to="'/'">
      <button class="btn btn-success btn-lg btn-block" @click="saveGame">
        Continuer
      </button>
    </router-link>
    <router-link :to="'/game/'+username+'/play'">
      <button class="btn btn-success btn-lg btn-block" @click="rejouer">
        Rejouer
      </button>
    </router-link>
  </div>
</template>
<style scoped>
.centered-dialog {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
<script>
import { defineComponent } from 'vue';
import { ref } from 'vue';
import { useRoute } from 'vue-router';
import RulesDialog from '../components/Rules.vue';
import router from '../router';

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
      tourMax: 5,
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
          console.clear();
        }
      }
      console.log('serverResponse.value', serverResponse.value);
    };

    fetchServerData();
    return {
      serverResponse,
      username,
      fetchServerData,
    };
  },

  methods: {
    handleAbandonnerClick() {
      router.back();
    },

    saveGame() {
      fetch('http://localhost:8888/game/' + this.username + '/stop', {
        method: 'GET',
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
        .catch((error) => {
          console.error('Erreur de connexion !');
          console.error(error);
        });
    },

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
            document.getElementById('btnFinPartie').style.display = '';
            document.getElementById('btnPiocher').style.display = 'none';
            document.getElementById('btnFinPartie').onclick = () => {
              document.getElementById('game').style.display = 'none';
              document.getElementById('end-view').style.display = 'block';
            };

            // document.getElementById('btnPiocher').disabled = true;
            // setTimeout(() => {
            //   document.getElementById('game').style.display = 'none';
            //   document.getElementById('end-view').style.display = 'block';
            // }, 1000);
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
      while (this.tour < 5) {
        this.tour++;
        break;
      }
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
    rejouer() {
      document.getElementById('game').style.display = '';
      document.getElementById('end-view').style.display = 'none';
      this.tour = 1;
      this.score = 0;
      this.card1 = false;
      this.card2 = false;
      this.card1Clickable = true;
      this.card2Clickable = true;
      document.getElementById('btnPiocher').disabled = true;
      document.getElementById('btnPiocher').style.display = '';
      document.getElementById('btnFinPartie').style.display = 'none';

    },
  },
});
</script>
