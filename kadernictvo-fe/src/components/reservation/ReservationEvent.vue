<template>
    <v-container class="text-dark mt-5">
        <v-row>
            <v-col>
                <SectionDescriber :section-name="$t('reservation.firstSectionName')"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <v-col
                v-for="service in services"
                :key="service.id"
                cols="12"
                sm="6"
                md="4"
            >
                <v-skeleton-loader type="card" v-if="loadingEvents"></v-skeleton-loader>
                <ServiceCard
                    v-else
                    :class="{'selected': isSelected(service.id)}"
                    @click="toggleService(service)"
                    :card-title="service.name"
                    :card-text="service.desc"
                    :card-price="service.price"
                    :card-image="service.image"
                    :card-second-text="service.duration"
                    :reservation="true"
                    :service="true"
                ></ServiceCard>
            </v-col>
        </v-row>
        <div class="mt-3" style="border-bottom: 1px solid #ececec;"></div>
    </v-container>
</template>

<script>
import axios from 'axios';
import SectionDescriber from '@/components/home/SectionDescriber.vue';
import ServiceCard from '@/components/home/ServiceCard.vue';

export default {
    name: 'ReservationEvent',
    components: { ServiceCard, SectionDescriber },
    data() {
        return {
            loadingEvents: true,
            services: [],
            selectedServices: []
        };
    },
    methods: {
        async fetchServices() {
            try {
                const response = await axios.get('http://localhost:8000/api/services');
                this.services = response.data;
                this.loadingEvents = false;
                console.log(this.services);
            } catch (error) {
                console.error('Error fetching services:', error);
            }
        },
        toggleService(service) {
            const index = this.selectedServices.findIndex(s => s.id === service.id);
            if (index !== -1) {
                this.selectedServices.splice(index, 1);
            } else {
                this.selectedServices.push(service);
            }
            this.$emit('services-selected', {
                services: this.selectedServices
            });
        },
        isSelected(serviceId) {
            return this.selectedServices.some(service => service.id === serviceId);
        }
    },
    created() {
        this.fetchServices();
    }
}
</script>

<style scoped>
.selected {
    border: 2px solid #d09c6e;
}
</style>
