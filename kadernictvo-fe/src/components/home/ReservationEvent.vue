<template>
    <v-container class="text-dark">
        <v-col>
            <SectionDescriber :section-name="$t('reservation.sectionName')"></SectionDescriber>
        </v-col>
        {{ selectedServices }}
        <v-row>
            <v-col
                v-for="service in services"
                :key="service.id"
                cols="12"
                sm="6"
                md="4"
            >
                <ServiceCard
                    :class="{'selected': selectedServices.includes(service.id)}"
                    @click="toggleService(service.id)"
                    :card-title="service.title"
                    :card-text="service.description"
                    :card-price="service.price"
                    :card-image="service.image"
                ></ServiceCard>
            </v-col>
        </v-row>
    </v-container>
</template>


<script>
import SectionDescriber from '@/components/home/SectionDescriber.vue'
import ServiceCard from "@/components/home/ServiceCard.vue";

export default {
    name: 'ReservationEvent',
    components: {ServiceCard, SectionDescriber},
    data() {
        let src = "/src/assets/images/services/";
        return {
            services: [
                {
                    id: 1,
                    title: "Pánsky strih",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "15",
                    image: src + "man-hair.png"
                },
                {
                    id: 2,
                    title: "Úprava brady",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas. consectetur adipisicing elit.",
                    price: "10",
                    image: src + "beard.png"
                },
                {
                    id: 3,
                    title: "Pánsky strih a úprava brady",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "20",
                    image: src + "beard-hair.png"
                },
                {
                    id: 4,
                    title: "Holenie do hladka Hot Towel",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "12",
                    image: src + "hot-towel.png"
                },
                {
                    id: 5,
                    title: "Farbenie vlasov",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "20",
                    image: src + "hair-brush.png"

                },
                {
                    id: 6,
                    title: "Starostlivosť o pleť",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "11,50",
                    image: src + "cream.png"
                },
                {
                    id: 7,
                    title: "Depilácia uši a nosa voskom",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas.",
                    price: "5",
                    image: src + "wax.png"
                },
                {
                    id: 8,
                    title: "Balíček Extra",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas. Lorem ipsum dolor sit amet",
                    price: "25",
                    image: src + "pack-extra.png"
                },
                {
                    id: 9,
                    title: "Balíček Super",
                    description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur, voluptas. consectetur adipisicing elit. Consequatur, voluptas. consectetur adipisicing elit. ",
                    price: "32",
                    image: src + "pack-super.png"
                },
            ],
            selectedServices: []
        }
    },
    methods: {
        toggleService(serviceId) {
            if (this.selectedServices.includes(serviceId)) {
                this.selectedServices = this.selectedServices.filter(id => id !== serviceId)
            } else {
                this.selectedServices.push(serviceId)
            }
            this.$emit('services-selected', this.selectedServices)
        }
    }
}
</script>

<style scoped>
.selected {
    border: 3px solid #d09c6e;
}
</style>
