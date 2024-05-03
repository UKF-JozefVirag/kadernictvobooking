<template>
    <v-container>
        <img
            class="header-img"
            src="../assets/images/header.jpg"
            alt="header image"
        >

        <div class="d-flex flex-column text-center justify-content-center align-items-center text-white header-text">
            <h6 class="display-6">
                vaše vlasy sú naše plátno
            </h6>
            <h1 class="display-1">
                Barbershop Ružomberok
            </h1>
            <div class="align-items-center">
                <a class="btn btn-cus btn-fill m-3 border border-2 p-2" href="#">Rezervovať online termín</a>
                <a class="btn btn-cus btn-fill m-3 border border-2 p-2" href="#">Zavolajte nám na 0987 123 456</a>
            </div>
        </div>
    </v-container>


</template>

<script>
export default {
    name: "HeaderComponent"
}
</script>

<style scoped>
@import "../assets/styles/buttons.scss";
.header-img {
    height: 100vh;
    width: 100vw;
    object-fit: cover;
    filter: brightness(0.4);
    position: absolute;
    top: 0;
    left: 0;
    z-index: -2;
}

.header-text{
    height: 90vh;
    padding-bottom: 30vh;
}
</style>
