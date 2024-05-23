<template>
    <v-container class="mt-5" id="services">
        <v-row>
            <v-col>
                <SectionDescriber section-name="Naše služby"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <v-col lg="4"
                   md="6"
                   sm="6"
                   xs="12"
                   v-for="(item, i) in cards"
            :key="i">
                <ServiceCard
                    :card-title="item.title"
                    :card-text="item.description"
                    :card-price="item.price"
                    :card-image="item.image"
                ></ServiceCard>
            </v-col>
        </v-row>
    </v-container>

</template>

<script>
import SectionDescriber from "@/components/SectionDescriber.vue";
import ServiceCard from "@/components/ServiceCard.vue";

export default {
    name: "ServicesView",
    components: {ServiceCard, SectionDescriber},
    data() {
        let src = "/src/assets/images/services/";
        return {
            cards: [
                {
                    title: "Pánsky strih",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "15",
                    image: src + "man-hair.png"
                },
                {
                    title: "Úprava brady",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas. consectetur adipisicing elit.",
                    price: "10",
                    image: src + "beard.png"
                },
                {
                    title: "Pánsky strih a úprava brady",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "20",
                    image: src + "beard-hair.png"
                },
                {
                    title: "Holenie do hladka Hot Towel",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "12",
                    image: src + "hot-towel.png"
                },
                {
                    title: "Farbenie vlasov",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "20",
                    image: src + "hair-brush.png"

                },
                {
                    title: "Starostlivosť o pleť",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "11,50",
                    image: src + "cream.png"
                },
                {
                    title: "Depilácia uši a nosa voskom",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "5",
                    image: src + "wax.png"
                },
                {
                    title: "Balíček Extra",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas. Lorem ipsum dolor sit amet",
                    price: "25",
                    image: src + "pack-extra.png"
                },
                {
                    title: "Balíček Super",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas. consectetur adipisicing elit. Consequatur, voluptas. consectetur adipisicing elit. ",
                    price: "32",
                    image: src + "pack-super.png"
                },
            ]
        }
    }
}
</script>

<style scoped>

</style>
