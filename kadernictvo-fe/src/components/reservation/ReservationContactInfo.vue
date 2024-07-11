<template>
    <v-container>
        <v-row>
            <v-col>
                <SectionDescriber :section-name="$t('reservation.fourthSectionName')"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-form @submit.prevent="submitForm" ref="form">
                    <v-row>
                        <v-col cols="6">
                            <h6>{{ $t('reservation.firstName') }}<span class="text-danger"> *</span></h6>
                            <v-text-field
                                placeholder="John"
                                v-model="firstName"
                                :rules="[v => !!v || $t('reservation.firstName') + ' ' + $t('reservation.required')]"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <h6>{{ $t('reservation.lastName') }}</h6>
                            <v-text-field
                                placeholder="Doe"
                                v-model="lastName"
                                :rules="[v => !!v || $t('reservation.lastName') + ' ' + $t('reservation.required')]"
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <h6>{{ $t('reservation.email') }}<span class="text-danger"> *</span></h6>
                            <v-text-field
                                placeholder="johndoe@example.com"
                                v-model="email"
                                :rules="[v => !!v || $t('reservation.email') + ' ' + $t('reservation.required')]"
                                required
                            ></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <h6>{{ $t('reservation.phoneNumber') }}<span class="text-danger"> *</span></h6>
                            <v-text-field
                                placeholder="09xx xxx xxx"
                                type="text"
                                v-model="phoneNumber"
                                :rules="[v => !!v || $t('reservation.phoneNumber') + ' ' + $t('reservation.required')]"
                                required
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row class="justify-content-center">
                        <v-col cols="3">
                            <v-btn
                                type="submit"
                                class="w-100 submit-button"
                                variant="outlined"
                                :ripple="false"
                                plain
                                block
                            >{{ $t('reservation.send') }}</v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import SectionDescriber from '@/components/home/SectionDescriber.vue'

export default {
    name: 'ReservationContactInfo',
    components: { SectionDescriber },
    data() {
        return {
            firstName: '',
            lastName: '',
            phoneNumber: '',
            email: '',
            snackText: '',
            snackColor: '',
            snackOpen: false,
            originalProfile: {
                firstName: '',
                lastName: '',
                phoneNumber: '',
                email: ''
            }
        }
    },
    methods: {
        submitForm() {
            if (this.$refs.form.validate()) {
                this.$emit('contact-info-submitted', {
                    firstName: this.firstName,
                    lastName: this.lastName,
                    phoneNumber: this.phoneNumber,
                    email: this.email
                });
                this.$emit('open-modal');
            } else {
                this.snackText = 'Please fill in all required fields.';
                this.snackColor = 'yellow';
                this.snackOpen = true;
            }
        }
    }
}
</script>

<style scoped>
</style>
