<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span
                    class="headline">{{ employee ? $t('employees_view.editEmployee') : $t('employees_view.addEmployee')
                    }}</span>
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-text-field
                        v-model="employeeData.first_name"
                        :label="$t('employees_view.firstName')"
                        :rules="[v => !!v || $t('employees_view.firstName') + ' ' + $t('employees_view.isRequired')]"
                        variant="outlined"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="employeeData.last_name"
                        :label="$t('employees_view.lastName')"
                        :rules="[v => !!v || $t('employees_view.lastName') + ' ' + $t('employees_view.isRequired')]"
                        variant="outlined"
                        required
                    ></v-text-field>
                    <v-file-input
                        v-model="imageFile"
                        :label="$t('employees_view.image')"
                        :rules="[v => !!v || $t('employees_view.image') + ' ' + $t('employees_view.isRequired')]"
                        variant="outlined"
                    ></v-file-input>
                    <v-img
                        v-if="employeeData.image && !imageFile"
                        :src="getImageUrl(employeeData.image)"
                        :alt="employeeData.name"
                        class="my-3 mx-auto"
                        width="100px"
                        height="100px"
                    ></v-img>
                    <v-text-field
                        v-model="employeeData.email"
                        :label="$t('employees_view.email')"
                        :rules="[v => !!v || $t('employees_view.email') + ' ' + $t('employees_view.isRequired'), v => /.+@.+\..+/.test(v) || $t('employees_view.email') + ' ' + $t('employees_view.wrongFormat')]"
                        variant="outlined"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="employeeData.phone_number"
                        :label="$t('employees_view.phoneNumber')"
                        :rules="[v => !!v || $t('employees_view.phoneNumber') + ' ' + $t('employees_view.isRequired')]"
                        variant="outlined"
                        required
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" @click="cancel">{{ $t('buttons.cancel') }}</v-btn>
                <v-btn color="blue darken-1" @click="save">{{ $t('buttons.submit') }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
    <SnackComponent color="warning" :text="snackText" :snackOpen="snackOpen"></SnackComponent>

</template>

<script>
import axiosInstance from '@/axios.js'
import SnackComponent from '@/components/common/SnackComponent.vue'

export default {
    name: 'EmployeeForm',
    components: { SnackComponent },
    props: {
        employee: Object
    },
    data() {
        return {
            dialog: true,
            valid: false,
            employeeData: this.employee ? { ...this.employee } : {
                first_name: '',
                last_name: '',
                image: '',
                email: '',
                phone_number: ''
            },
            imageFile: null,
            snackText: "",
            snackOpen: false
        }
    },
    watch: {
        employee(newVal) {
            this.employeeData = newVal ? { ...newVal } : {
                first_name: '',
                last_name: '',
                image: '',
                email: '',
                phone_number: '',
                snackOpen: false,
                snackText: ''
            }
        },
        imageFile() {
            if (this.imageFile) {
                this.employeeData.image = null
            }
        }
    },
    methods: {
        cancel() {
            this.$emit('cancel')
        },
        async save() {
            if (await this.$refs.form.validate()) {
                try {
                    const token = this.$cookies.get('token')
                    const config = {
                        headers: {
                            'Authorization': `Bearer ${decodeURIComponent(token)}`,
                            'Content-Type': 'multipart/form-data'
                        }
                    }

                    const formData = new FormData()
                    formData.append('first_name', this.employeeData.first_name)
                    formData.append('last_name', this.employeeData.last_name)
                    formData.append('email', this.employeeData.email)
                    formData.append('phone_number', this.employeeData.phone_number)

                    if (this.imageFile) {
                        formData.append('image', this.imageFile)
                    }

                    if (this.employeeData.id) {
                        formData.append('_method', 'PATCH');
                    }

                    await this.sendData(formData, config);
                } catch (error) {
                    this.snackOpen = true;
                    this.snackText = 'Error deleting order: ' + error;
                }
            }
        },
        async sendData(formData, config) {
            let response;
            if (this.employeeData.id) {
                response = await axiosInstance.post(`/employees/${this.employeeData.id}`, formData, config);
            } else {
                response = await axiosInstance.post(`/employees`, formData, config);
            }
            this.$emit('save', response.data);
        },
        getImageUrl(image) {
            return image ? `http://localhost:8000/storage/${image}` : ''
        }
    }
}
</script>

<style scoped>
</style>
