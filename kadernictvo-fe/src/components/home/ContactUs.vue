<template>
    <v-container fluid class="mt-5 contactus" id="contact-us">
        <v-row>
            <v-col>
                <SectionDescriber :section-name="$t('contact.sectionName')"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row class="justify-content-md-center justify-content-sm-center">
            <v-col cols="8" md="6" sm="12" xs="12">
                <h2 class="text-left">{{ $t('contact.whereToFindUs') }}</h2>
                <a href="https://www.google.sk/maps/place/OC+Mlyny+Nitra/@48.3070976,18.0839326,17z/data=!3m1!4b1!4m6!3m5!1s0x476b3ee307b4e213:0xcc86d6ceb39dab2e!8m2!3d48.3070941!4d18.0865075!16s%2Fg%2F11xqzgkk1?entry=ttu"
                   target="_blank" class="mt-3 address"><BIconGeoAlt></BIconGeoAlt>{{ $t('contact.address') }}</a>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2653.779397425777!2d18.083927212399463!3d48.307094071142856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476b3ee307b4e213%3A0xcc86d6ceb39dab2e!2sOC%20Mlyny%20Nitra!5e0!3m2!1ssk!2ssk!4v1716199574037!5m2!1ssk!2ssk"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </v-col>
            <v-col cols="12" md="4">
                <h2 class="text-left">{{ $t('contact.openingHours') }}</h2>
                <v-row class="d-flex justify-space-between mt-3">
                    <v-col class="text-left">
                        <p class="h6">{{ $t('contact.days.monday') }}</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">{{ $t('contact.hours.monday') }}</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6">{{ $t('contact.days.tuesday') }}</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">{{ $t('contact.hours.tuesday') }}</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6">{{ $t('contact.days.wednesday') }}</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">{{ $t('contact.hours.wednesday') }}</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6">{{ $t('contact.days.thursday') }}</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">{{ $t('contact.hours.thursday') }}</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6">{{ $t('contact.days.friday') }}</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">{{ $t('contact.hours.friday') }}</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6">{{ $t('contact.days.saturday') }}</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">{{ $t('contact.hours.saturday') }}</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6">{{ $t('contact.days.sunday') }}</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">{{ $t('contact.hours.sunday') }}</p>
                    </v-col>
                </v-row>
                <hr>
                <v-row>
                    <v-col class="text-left">
                        <p class="h6">{{ $t('contact.phoneNumber') }}</p>
                    </v-col>
                    <v-col class="text-right">
                        <a href="tel:0950444555" class="h6 hours">{{ $t('contact.phone') }}</a>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col class="text-left">
                        <p class="h6">{{ $t('contact.email') }}</p>
                    </v-col>
                    <v-col class="text-right">
                        <a :href="'mailto:' + interpolatedEmail" class="h6 hours">{{ interpolatedEmail }}</a>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import SectionDescriber from "@/components/home/SectionDescriber.vue";

export default {
    name: "ContactUs",
    components: {SectionDescriber},
    computed: {
        interpolatedEmail() {
            return this.$t('contact.emailAddress', { at: '@' });
        }
    }
}
</script>

<style lang="scss" scoped>
.address {
    text-decoration: underline;
    color: black;
    :nth-child(1) {
        margin-right: 10px;
    }
}

.hours {
    font-weight: normal;
}

.contactus {
    letter-spacing: 2px;
}
</style>
