<script setup>
/*
import { ref } from 'vue';
// Utilisez une référence pour stocker la réponse du serveur
const serverResponse = ref('');

fetch('http://localhost:8888')
  // si connexion établie alors message de confirmation
  .then((response) => {
    if (response.ok) {
      // Si la connexion est établie avec succès, lisez le corps de la réponse
      return response.text();
    } else {
      throw new Error('Erreur de connexion !');
    }
  })
  .then((data) => {
    // Mettez à jour la référence avec le texte de la réponse
    serverResponse.value = data;
    console.log('Connexion établie !');
  })
  // si connexion non établi alors message d'erreur
  .catch((error) => {
    console.error('Erreur de connexion !');
    console.error(error);
  });
  */
</script>

<template>
  <router-view />
</template>
