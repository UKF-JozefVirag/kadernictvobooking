<template>
    <v-card width="300px" class="mx-auto text-center" v-ripple="false">
        <template v-slot:title>
            <span class="font-weight-black">{{cardTitle}}</span>
        </template>
        <v-card-text style="color: #d09c6e">
            <h5>
                {{cardPrice}} <span v-if="cardPrice!=null">€</span>
            </h5>
            <span v-if="reservation && service" class="text-black"> {{cardSecondText}} min.</span>
        </v-card-text>
        <img :src="cardImage" width="60px" alt="logo"/>
        <v-card-text class="bg-grey-lighten-2 pt-4 mt-2" style="letter-spacing: 2px">
            {{cardText}}
        </v-card-text>
        <a href="#" class="btn btn-cus border-top w-100" v-if="!reservation">Rezervovať</a>
    </v-card>
</template>

<script>
export default {
    name: "ServiceCard",
    props: {
        cardTitle: String,
        cardText: String,
        cardPrice: Number,
        cardImage: String,
        cardSecondText: String,
        reservation: Boolean,
        service: Boolean
    }
}
</script>

<style scoped>
@import "../../assets/styles/buttons.scss";

.btn-cus {
    color: black;
}

.btn-cus:hover {
    color: #d09c6e;
}
</style>
