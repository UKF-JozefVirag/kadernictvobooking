<template>
    <v-container>
        <v-row>
            <v-col>
                <SectionDescriber section-name="Naše služby" class="mt-5"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <v-col v-for="(item, i) in cards"
            :key="i">
                <ServiceCard
                    :card-title="item.title"
                    :card-text="item.description"
                    :card-price="item.price"
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
        return {
            cards: [
                {
                    title: "Pánsky strih",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "15",
                    image: "../assets/"
                },
                {
                    title: "Úprava brady",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "10"
                },
                {
                    title: "Pánsky strih a úprava brady",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "20"
                },
                {
                    title: "Pánsky strih",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "10"
                },
                {
                    title: "Pánsky strih",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "10"
                },
                {
                    title: "Pánsky strih",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "10"
                },
                {
                    title: "Pánsky strih",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "10"
                },
                {
                    title: "Pánsky strih",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "10"
                },
                {
                    title: "Pánsky strih",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "10"
                },
            ]
        }
    }
}
</script>

<style scoped>

</style>
