<template>
  <div>
    <h1>Page Not Found</h1>
    <p>La page que vous recherchez n'existe pas.</p>
    <router-link to="/">Retour au menu</router-link>
  </div>
</template>

<script>
import { defineComponent } from 'vue';
export default defineComponent({
  name: 'NotFoundView',
});
</script>
