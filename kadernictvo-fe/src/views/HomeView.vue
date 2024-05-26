<template>
    <v-app>
        <NavBar v-if="isNotHome"></NavBar>
        <RouterView />
        <FooterComponent></FooterComponent>
    </v-app>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import NavBar from "@/components/NavBar.vue";
import FooterComponent from "@/components/FooterComponent.vue";

export default {
    name: "App",
    components: {NavBar, FooterComponent},
    computed: {
        isNotHome() {
            // TODO: condition: if route name isnt home, .navbar bg-color = black
            console.log("xdddd");
        }
    }
}

</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
* {
    font-family: "Roboto", sans-serif;
}

body {
    overflow-x: hidden;
}
</style>
