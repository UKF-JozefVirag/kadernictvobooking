<template>
    <v-container class="mt-5" id="services">
        <v-row>
            <v-col>
                <SectionDescriber :section-name="$t('services.sectionName')"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <v-col lg="4"
                   md="6"
                   sm="6"
                   xs="12"
                   v-for="(service) in services"
                   :key="service.id">
                <ServiceCard
                    :class="{'selected': isSelected(service.id)}"
                    :card-title="service.name"
                    :card-text="service.desc"
                    :card-price="service.price"
                    :card-image="getImageUrl(service.image)"
                    @click="toggleService(service)"
                    :card-second-text="service.duration"
                    :reservation="true"
                    :service="true"
                ></ServiceCard>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import SectionDescriber from "@/components/home/SectionDescriber.vue";
import ServiceCard from "@/components/home/ServiceCard.vue";
import axios from 'axios';

export default {
    name: "ServicesView",
    components: { ServiceCard, SectionDescriber },
    data() {
        return {
            services: [],
            loadingEvents: true,
            selectedServices: []
        };
    },
    created() {
        this.fetchServices();
    },
    methods: {
        async fetchServices() {
            try {
                const response = await axios.get('http://localhost:8000/api/services');
                this.services = response.data;
                this.loadingEvents = false;
            } catch (error) {
                console.error('Error fetching services:', error);
            }
        },
        getImageUrl(image) {
            return image ? `http://localhost:8000/storage/${image}` : '';
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
    }
}
</script>

<style scoped>
.selected {
    border: 2px solid #d09c6e;
}
</style>
