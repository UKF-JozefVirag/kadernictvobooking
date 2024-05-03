<template>
    <NavBar></NavBar>
<!--    <ScrollToTopButton></ScrollToTopButton>-->
    <HeaderComponent></HeaderComponent>
    <AboutUsView></AboutUsView>
    <RouterView />
</template>

<script setup>
import { RouterLink, RouterView } from 'vue-router'
import NavBar from "@/components/NavBar.vue";
import HeaderComponent from "@/components/HeaderComponent.vue";
import AboutUsView from "@/views/AboutUsView.vue";
// import ScrollToTopButton from "@/components/ScrollToTopButton.vue";
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
