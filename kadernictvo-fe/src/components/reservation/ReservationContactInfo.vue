<template>
    <v-container>
        <v-row>
            <v-col>
                <SectionDescriber :section-name="$t('reservation.fourthSectionName')"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row>
            <v-col>
                <v-form>
                    <v-row>
                        <v-col cols="6">
                            <h6>{{ $t('reservation.firstName') }}<span class="text-danger"> *</span></h6>
                            <v-text-field placeholder="John" v-model="firstName"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <h6>{{ $t('reservation.lastName') }}</h6>
                            <v-text-field placeholder="Doe" v-model="lastName"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col cols="6">
                            <h6>{{ $t('reservation.email') }}<span class="text-danger"> *</span></h6>
                            <v-text-field placeholder="johndoe@example.com" v-model="email"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <h6>{{ $t('reservation.phoneNumber') }}<span class="text-danger"> *</span></h6>
                            <v-text-field placeholder="+421 123 456 789" type="text"
                                          v-model="phoneNumber"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row class="justify-content-center">
                        <v-col cols="3">
                            <v-btn type="submit" class="w-100 submit-button" variant="outlined" :ripple="false" plain block>{{ $t('reservation.send') }}</v-btn>
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
    }
}
</script>

<style scoped>

</style>
