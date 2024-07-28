<template>
    <v-container class="mt-5" id="services">
        <v-row>
            <v-col>
                <SectionDescriber :section-name="$t('services.sectionName')"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <template v-if="loadingEvents">
                <v-col lg="4" md="6" sm="6" xs="12" v-for="n in 9" :key="'skeleton-' + n">
                    <v-skeleton-loader
                        type="image"
                        class="my-2"
                        style="background-color: #E0E0E0;">
                    </v-skeleton-loader>
                </v-col>
            </template>
            <template v-else>
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
            </template>
        </v-row>
    </v-container>
    <SnackComponent color="warning" :text="snackText" :snackOpen="snackOpen"></SnackComponent>
</template>


<script>
import SectionDescriber from "@/components/home/SectionDescriber.vue";
import ServiceCard from "@/components/home/ServiceCard.vue";
import axiosInstance from '@/axios.js'
import SnackComponent from '@/components/common/SnackComponent.vue'

export default {
    name: "ReservationEvent",
    components: { SnackComponent, ServiceCard, SectionDescriber },
    data() {
        return {
            services: [],
            loadingEvents: true,
            selectedServices: [],
            snackText: "",
            snackOpen: false
        };
    },
    created() {
        this.fetchServices();
    },
    methods: {
        async fetchServices() {
            try {
                const response = await axiosInstance.get('/services');
                this.services = response.data;
                this.loadingEvents = false;
            } catch (error) {
                this.snackOpen = true;
                this.snackText = 'Error fetching services: ' + error;
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
    },
    emits: ['services-selected']
}
</script>

<style scoped>
.selected {
    border: 2px solid #d09c6e;
}
</style>
