<template>
    <v-container class="text-dark">
        <v-col>
            <SectionDescriber :section-name="$t('reservation.sectionName')"></SectionDescriber>
        </v-col>
        <v-row>
            <v-col
                v-for="service in services"
                :key="service.id"
                cols="12"
                sm="6"
                md="4"
            >
                <v-card
                    :class="{'selected': selectedServices.includes(service.id)}"
                    @click="toggleService(service.id)"
                >
                    <v-img :src="service.image" height="200px"></v-img>
                    <v-card-title>{{ service.name }}</v-card-title>
                    <v-card-subtitle>{{ service.price }} €</v-card-subtitle>
                    <v-card-text>{{ service.description }}</v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import SectionDescriber from '@/components/home/SectionDescriber.vue'

export default {
    name: 'ReservationEvent',
    components: { SectionDescriber },
    data() {
        return {
            services: [
                {
                    id: 1,
                    name: 'Haircut',
                    price: 15,
                    description: 'Professional haircut service',
                    image: 'https://via.placeholder.com/200'
                },
                {
                    id: 2,
                    name: 'Beard Trim',
                    price: 10,
                    description: 'Expert beard trimming',
                    image: 'https://via.placeholder.com/200'
                },
                {
                    id: 3,
                    name: 'Full Service',
                    price: 25,
                    description: 'Complete haircut and beard trim',
                    image: 'https://via.placeholder.com/200'
                }
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
    border: 2px solid #d09c6e;
}
</style>
