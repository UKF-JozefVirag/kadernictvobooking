<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline">{{ employee ? $t('employees_view.editEmployee') : $t('employees_view.addEmployee') }}</span>
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
                <v-btn color="blue darken-1" text @click="cancel">{{ $t('buttons.cancel') }}</v-btn>
                <v-btn color="blue darken-1" text @click="save">{{ $t('buttons.submit') }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import axios from 'axios';

export default {
    name: 'EmployeeForm',
    props: {
        employee: Object
    },
    data() {
        return {
            dialog: true,
            valid: false,
            employeeData: this.employee ? { ...this.employee } : { first_name: '', last_name: '', email: '', phone_number: '' }
        }
    },
    watch: {
        employee(newVal) {
            this.employeeData = newVal ? { ...newVal } : { first_name: '', last_name: '', email: '', phone_number: '' };
        }
    },
    methods: {
        cancel() {
            this.$emit('cancel');
        },
        async save() {
            if (this.$refs.form.validate()) {
                try {
                    let response;
                    const token = this.$cookies.get('token');
                    if (this.employeeData.id) {
                        response = await axios.patch(`http://localhost:8000/api/employees/${this.employeeData.id}`, this.employeeData, {
                            headers: {
                                Authorization: `Bearer ${decodeURIComponent(token)}`
                            }
                        });
                    } else {
                        response = await axios.post('http://localhost:8000/api/employees', this.employeeData, {
                            headers: {
                                Authorization: `Bearer ${decodeURIComponent(token)}`
                            }
                        });
                    }
                    this.$emit('save', response.data);
                } catch (error) {
                    console.error(error);
                }
            }
        }
    }
}
</script>

<style scoped>
</style>
