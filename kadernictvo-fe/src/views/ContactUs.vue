<template>
    <v-container fluid class="mt-5 contactus">
        <v-row>
            <v-col>
                <SectionDescriber section-name="Kontakt"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row class="justify-content-md-center">
            <v-col cols="8" md="6" sm="12">
                <h2 class="text-left">Kde nás nájdete</h2>
                <a href="#" class="mt-3 address"><BIconGeoAlt></BIconGeoAlt>Štefánikova trieda 61, 949 01 Nitra</a>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2653.779397425777!2d18.083927212399463!3d48.307094071142856!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x476b3ee307b4e213%3A0xcc86d6ceb39dab2e!2sOC%20Mlyny%20Nitra!5e0!3m2!1ssk!2ssk!4v1716199574037!5m2!1ssk!2ssk"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </v-col>
            <v-col cols="12" md="4">
                <h2 class="text-left">Otváracie hodiny</h2>
                <v-row class="d-flex justify-space-between mt-3">
                    <v-col class="text-left">
                        <p class="h6">Pondelok</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">08:00 - 20:00</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6 ">Utorok</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">08:00 - 20:00</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6">Streda</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">08:00 - 20:00</p>
                    </v-col>
                </v-row>
                <v-row class=" d-flex justify-space-between
                    ">
                    <v-col class="text-left">
                        <p class="h6">Štvrtok</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">08:00 - 20:00</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6">Piatok</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">08:00 - 20:00</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6">Sobota</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">12:00 - 18:00</p>
                    </v-col>
                </v-row>
                <v-row class="d-flex justify-space-between">
                    <v-col class="text-left">
                        <p class="h6 ">Nedeľa</p>
                    </v-col>
                    <v-col class="text-right">
                        <p class="h6 hours">Zatvorené</p>
                    </v-col>
                </v-row>
                <hr>
                <v-row>
                    <v-col class="text-left">
                        <p class="h6">Telefónne číslo: </p>
                    </v-col>
                    <v-col class="text-right">
                        <a href="tel:0950444555" class="h6 hours">0950 444 555</a>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col class="text-left">
                        <p class="h6">Email: </p>
                    </v-col>
                    <v-col class="text-right">
                        <a href="mailto: info@barbershop.sk" class="h6 hours">info@barbershop.sk</a>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import SectionDescriber from "@/components/SectionDescriber.vue";

export default {
    name: "ContactUs",
    components: {SectionDescriber}
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
