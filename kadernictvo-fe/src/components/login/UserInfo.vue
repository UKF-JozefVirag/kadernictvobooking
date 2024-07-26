<template>
    <div>
        <SnackComponent :color="snackColor" :text="snackText" :snackOpen="snackOpen"></SnackComponent>
        <v-card class="p-3">
            <v-card-title>
                <h3>My profile</h3>
            </v-card-title>
            <v-card-subtitle>
                <v-row>
                    <v-col cols="12">
                        <p>These are the email and name associated with your user profile and will be used in
                            email communications we send you.</p>
                        <hr>
                    </v-col>
                </v-row>
            </v-card-subtitle>
            <v-form @submit.prevent="saveProfileInfo">
                <v-card-text>
                    <v-row>
                        <v-col cols="6">
                            <h6>Email<span class="text-danger">*</span></h6>
                            <v-text-field placeholder="johndoe@example.com" v-model="email"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <h6>Phone number<span class="text-danger"></span></h6>
                            <v-text-field placeholder="+421 123 456 789" type="text" v-model="phoneNumber"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <h6>First name<span class="text-danger">*</span></h6>
                            <v-text-field placeholder="John" v-model="firstName"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <h6>Last name<span class="text-danger">*</span></h6>
                            <v-text-field placeholder="Doe" v-model="lastName"></v-text-field>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-row>
                        <v-col cols="3">
                            <v-btn class="ms-2" color="primary" :ripple="false" variant="elevated" plain block type="submit">Save</v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </v-form>
        </v-card>
    </div>
</template>

<script>
import SnackComponent from "@/components/common/SnackComponent.vue";
import axiosInstance from '@/axios.js'

export default {
    name: "UserInfo",
    components: { SnackComponent },
    data() {
        return {
            firstName: "",
            lastName: "",
            phoneNumber: "",
            email: "",
            snackText: "",
            snackColor: "",
            snackOpen: false,
            originalProfile: {
                firstName: "",
                lastName: "",
                phoneNumber: "",
                email: ""
            },
        }
    },
    beforeMount() {
        this.fetchProfileInfo();
    },
    methods: {
        async saveProfileInfo() {
            this.snackOpen = false;
            if (
                this.firstName === this.originalProfile.firstName &&
                this.lastName === this.originalProfile.lastName &&
                this.phoneNumber === this.originalProfile.phoneNumber &&
                this.email === this.originalProfile.email
            ) {
                this.snackText = "No changes to save.";
                this.snackColor = "warning";
                this.snackOpen = true;
                return;
            }

            try {
                const token = decodeURIComponent($cookies.get('token'))
                await axiosInstance.patch(
                    '/user',
                    {
                        firstName: this.firstName,
                        lastName: this.lastName,
                        phoneNumber: this.phoneNumber,
                        email: this.email
                    },
                    {
                        headers: {
                            Authorization: 'Bearer ' + { token }
                        }
                    }
                );

                this.snackText = "Data has been successfully updated.";
                this.snackColor = "success";
                this.snackOpen = true;

                this.originalProfile = {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    phoneNumber: this.phoneNumber,
                    email: this.email
                };
            } catch (error) {
                this.snackText = "Error: " + error;
                this.snackColor = "danger";
                this.snackOpen = true;
            }
        },

        async fetchProfileInfo() {
            try {
                const token = decodeURIComponent($cookies.get('token'))
                const response = await axiosInstance.get(`/user`, {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });
                const data = response.data;
                this.firstName = data.first_name;
                this.lastName = data.last_name;
                this.phoneNumber = data.phoneNumber;
                this.email = data.email;

                this.originalProfile = {
                    firstName: data.first_name,
                    lastName: data.last_name,
                    phoneNumber: data.phoneNumber,
                    email: data.email
                };
            } catch (error) {
                this.snackOpen = true;
                this.snackText = "Error logging out: " + error;
            }
        }
    }
}
</script>

<style scoped>

</style>
