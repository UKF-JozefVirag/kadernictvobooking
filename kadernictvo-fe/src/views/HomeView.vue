<template>
    <NavBar></NavBar>
    <HeaderComponent></HeaderComponent>
    <AboutUsView></AboutUsView>
    <ServicesComponent></ServicesComponent>
    <ReviewsCarousel></ReviewsCarousel>
    <GalleryView></GalleryView>
    <ContactUs></ContactUs>
    <FooterComponent></FooterComponent>
</template>

<script>
import HeaderComponent from "@/components/home/HeaderComponent.vue";
import AboutUsView from "@/components/home/AboutUs.vue";
import ServicesComponent from "@/components/home/ServicesComponent.vue";
import ReviewsCarousel from "@/components/home/ReviewsCarousel.vue";
import GalleryView from "@/components/home/GalleryComponent.vue";
import ContactUs from "@/components/home/ContactUs.vue";
import FooterComponent from "@/components/FooterComponent.vue";
import NavBar from "@/components/NavBar.vue";

export default {
    name: "HomeView",
    components: {
        NavBar,
        HeaderComponent,
        AboutUsView,
        ServicesComponent,
        ReviewsCarousel,
        GalleryView,
        ContactUs,
        FooterComponent
    },
}
</script>



<style scoped>

</style>
