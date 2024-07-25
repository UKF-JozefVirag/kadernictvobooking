<template>
    <SnackComponent :color="snackColor" :text="snackText" :snackOpen="snackOpen"></SnackComponent>
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
                        type="card"
                        class="my-2">
                    </v-skeleton-loader>
                </v-col>
            </template>
            <template v-else>
                <v-col lg="4" md="6" sm="6" xs="12" v-for="(item, i) in services" :key="i">
                    <ServiceCard
                        :card-title="item.name"
                        :card-text="item.desc"
                        :card-price="item.price"
                        :card-image="getImageUrl(item.image)"
                        :reservation="true"
                    ></ServiceCard>
                </v-col>
            </template>
        </v-row>
    </v-container>
</template>




<script>
import SectionDescriber from "@/components/home/SectionDescriber.vue";
import ServiceCard from "@/components/home/ServiceCard.vue";
import axios from 'axios';
import SnackComponent from '@/components/common/SnackComponent.vue';
import axiosInstance from '@/axios.js'

export default {
    name: "ServicesComponent",
    components: { SnackComponent, ServiceCard, SectionDescriber },
    data() {
        return {
            services: [],
            loadingEvents: false,
            snackColor: "danger",
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
                this.loadingEvents = true;
                const response = await axiosInstance('/services');
                this.services = response.data;
                this.loadingEvents = false;
            } catch (error) {
                this.snackOpen = true;
                this.snackText = 'Error fetching services: ' + error;
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
