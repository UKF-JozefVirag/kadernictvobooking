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
                   v-for="(item, i) in services"
                   :key="i">
                <ServiceCard
                    :card-title="item.name"
                    :card-text="item.desc"
                    :card-price="item.price"
                    :card-image="getImageUrl(item.image)"
                    :reservation="true"
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
            loadingEvents: true
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
                console.log(this.services);
            } catch (error) {
                console.error('Error fetching services:', error);
            }
        },
        getImageUrl(image) {
            return image ? `http://localhost:8000/storage/${image}` : '';
        }
    }
}
</script>

<style scoped>
</style>
