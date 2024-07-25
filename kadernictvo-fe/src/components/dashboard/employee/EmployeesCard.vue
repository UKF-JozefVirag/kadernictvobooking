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
                        <h4>{{ $t('employees_view.employees') }}</h4>
                    </v-card-title>
                    <v-card-title>
                        <v-btn color="primary" @click="showAddForm">
                            <BIconPlusCircleFill class="me-2"></BIconPlusCircleFill>
                            {{ $t('employees_view.addEmployee') }}
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-text-field
                            v-model="search"
                            :label="$t('employees_view.search')"
                            single-line
                            variant="outlined"
                            hide-details
                            v-ripple="false"
                        ></v-text-field>
                        <EmployeeForm v-if="isFormVisible" :employee="currentEmployee" @save="saveEmployee" @cancel="hideForm" />
                        <v-data-table :headers="headers"
                                      :items="filteredEmployees"
                                      class="elevation-1"
                                      :items-per-page-text="this.$t('employees_view.itemsPerPage')">
                            <template v-slot:item.image="{ item }">
                                <div class="image-container">
                                    <v-img
                                        :src="getImageUrl(item.image)"
                                        height="75"
                                        width="75"
                                    ></v-img>
                                </div>
                            </template>
                            <template v-slot:item.actions="{ item }">
                                <v-icon small @click="editEmployee(item)">mdi-pencil</v-icon>
                                <v-icon small @click="deleteEmployee(item.id)">mdi-delete</v-icon>
                            </template>
                        </v-data-table>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import EmployeeForm from './EmployeeForm.vue'
import axios from 'axios'
import axiosInstance from '@/axios.js'

export default {
    name: 'EmployeesCard',
    components: {
        EmployeeForm
    },
    data() {
        return {
            headers: [
                { text: this.$t('employees_view.firstName'), value: 'first_name' },
                { text: this.$t('employees_view.lastName'), value: 'last_name' },
                { text: this.$t('employees_view.email'), value: 'email' },
                { text: this.$t('employees_view.image'), value: 'image', sortable: false },
                { text: this.$t('employees_view.phoneNumber'), value: 'phone_number' },
                { text: this.$t('employees_view.actions'), value: 'actions', sortable: false }
            ],
            employees: [],
            isFormVisible: false,
            currentEmployee: null,
            search: '',
        }
    },
    computed: {
        filteredEmployees() {
            return this.employees.filter(employee => {
                const fullName = `${employee.first_name} ${employee.last_name}`.toLowerCase();
                return fullName.includes(this.search.toLowerCase());
            });

        }
    },
    created() {
        this.getEmployees();
    },
    methods: {
        showAddForm() {
            this.currentEmployee = null;
            this.isFormVisible = true;
        },
        editEmployee(employee) {
            this.currentEmployee = employee;
            this.isFormVisible = true;
        },
        async deleteEmployee(id) {
            try {
                const token = this.$cookies.get('token');
                await axiosInstance.delete(`/employees/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${decodeURIComponent(token)}`
                    }
                });
                await this.getEmployees();
            } catch (error) {
                console.error(error);
            }
        },
        async saveEmployee(employee) {
            if (employee.id) {
                const index = this.employees.findIndex(emp => emp.id === employee.id);
                if (index !== -1) {
                    this.employees.splice(index, 1, employee);
                }
            } else {
                this.employees.push(employee);
            }
            this.hideForm();
            this.getEmployees();
        },
        hideForm() {
            this.isFormVisible = false;
        },
        async getEmployees() {
            try {
                const token = this.$cookies.get('token');
                const response = await axiosInstance.get('/employees', {
                    headers: {
                        'Authorization': `Bearer ${decodeURIComponent(token)}`
                    }
                });
                this.employees = response.data;
            } catch (error) {
                console.error(error);
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
