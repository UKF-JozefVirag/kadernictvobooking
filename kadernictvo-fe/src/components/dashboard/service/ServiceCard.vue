<template>
    <v-container>
        <v-row>
            <v-col lg="8"
                   md="12"
                   sm="12"
                   offset-lg="2"
            >
                <v-card class="shadow-lg">
                    <v-card-title class="text-center">
                        <h4>{{ $t('services_view.service') }}</h4>
                    </v-card-title>
                    <v-card-title>
                        <v-btn color="primary" @click="showAddForm">
                            <BIconPlusCircleFill class="me-2"></BIconPlusCircleFill>
                            {{ $t('services_view.addService') }}
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field
                            v-model="search"
                            :label="$t('services_view.search')"
                            single-line
                            variant="outlined"
                            hide-details
                            v-ripple="false"
                        ></v-text-field>
                        <ServiceForm v-if="isFormVisible" :service="currentService" @save="saveService" @cancel="hideForm" />
                        <v-data-table :headers="headers"
                                      :items="filteredServices"
                                      class="elevation-1"
                                      :items-per-page-text="this.$t('services_view.itemsPerPage')">
                            <template v-slot:item.actions="{ item }">
                                <v-icon small @click="editService(item)">mdi-pencil</v-icon>
                                <v-icon small @click="deleteService(item.id)">mdi-delete</v-icon>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import ServiceForm from './ServiceForm.vue'
import axios from 'axios'

export default {
    name: 'ServiceCard',
    components: {
        ServiceForm
    },
    data() {
        return {
            headers: [
                { text: this.$t('services_view.name'), value: 'name' },
                { text: this.$t('services_view.desc'), value: 'desc' },
                { text: this.$t('services_view.image'), value: 'image' },
                { text: this.$t('services_view.price'), value: 'price' },
                { text: this.$t('services_view.duration'), value: 'duration' },
                { text: this.$t('services_view.actions'), value: 'actions', sortable: false }
            ],
            services: [],
            isFormVisible: false,
            currentService: null,
            search: '',
        }
    },
    computed: {
        filteredServices() {
            return this.services.filter(service => {
                return service.name.toLowerCase().includes(this.search.toLowerCase());
            });
        }
    },
    created() {
        this.getServices();
    },
    methods: {
        showAddForm() {
            this.currentService = null;
            this.isFormVisible = true;
        },
        editService(service) {
            this.currentService = service;
            this.isFormVisible = true;
        },
        async deleteService(id) {
            try {
                const token = this.$cookies.get('token');
                await axios.delete(`http://localhost:8000/api/services/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${decodeURIComponent(token)}`
                    }
                });
                this.getServices();
            } catch (error) {
                console.error(error);
            }
        },
        async saveService(service) {
            if (service.id) {
                const index = this.services.findIndex(svc => svc.id === service.id);
                if (index !== -1) {
                    this.services.splice(index, 1, service);
                }
            } else {
                this.services.push(service);
            }
            this.hideForm();
            this.getServices();
        },
        hideForm() {
            this.isFormVisible = false;
        },
        async getServices() {
            try {
                const token = this.$cookies.get('token');
                const response = await axios.get('http://localhost:8000/api/services', {
                    headers: {
                        'Authorization': `Bearer ${decodeURIComponent(token)}`
                    }
                });
                this.services = response.data;
            } catch (error) {
                console.error(error);
            }
        }
    }
}
</script>

<style scoped>
</style>
