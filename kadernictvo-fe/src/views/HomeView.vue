<template>
    <NavBar></NavBar>
    <HeaderComponent></HeaderComponent>
    <AboutUsView></AboutUsView>
    <ServicesView></ServicesView>
    <ReviewsCarousel></ReviewsCarousel>
    <GalleryView></GalleryView>
    <ContactUs></ContactUs>
    <FooterComponent></FooterComponent>
</template>

<script>
import HeaderComponent from "@/components/home/HeaderComponent.vue";
import AboutUsView from "@/components/home/AboutUs.vue";
import ServicesView from "@/components/home/ServicesComponent.vue";
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
        ServicesView,
        ReviewsCarousel,
        GalleryView,
        ContactUs,
        FooterComponent
    },
}
</script>



<style scoped>

</style>
