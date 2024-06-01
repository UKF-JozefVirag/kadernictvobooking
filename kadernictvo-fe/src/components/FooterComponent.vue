<template>
    <div class="bg-black text-white mt-5 footer">
        <v-container fluid class="px-5">
            <v-row class="mt-2 mb-2">
                <v-col>
                    <p class="h6 footer-h">O nás</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet, nobis. Lorem ipsum dolor sit amet.. <a href="#about-us" class="read-more">Čítať viac</a></p>
                </v-col>
                <v-col>
                    <p class="h6 footer-h">Kontakt</p>
                    <v-row>
                        <a href="https://www.google.sk/maps/place/OC+Mlyny+Nitra/@48.3070976,18.0839326,17z/data=!3m1!4b1!4m6!3m5!1s0x476b3ee307b4e213:0xcc86d6ceb39dab2e!8m2!3d48.3070941!4d18.0865075!16s%2Fg%2F11xqzgkk1?entry=ttu" target="_blank" class="mt-3 address">
                            <BIconGeoAlt></BIconGeoAlt> Štefánikova trieda 61, 949 01 Nitra
                        </a>
                    </v-row>
                    <v-row>
                        <a href="tel:0950444555" class="mt-3 address">
                            <BIconPhone></BIconPhone> 0950 444 555
                        </a>
                    </v-row>
                    <v-row>
                        <a href="mailto:info@barbershop.sk" class="mt-3 address">
                            <BIconEnvelope></BIconEnvelope> info@barbershop.sk
                        </a>
                    </v-row>
                </v-col>
                <v-col>
                    <p class="h6 footer-h">Sociálne siete</p>
                    <v-row>
                        <v-col lg="2">
                            <a href="https://www.instagram.com" target="_blank" class="footer-s">
                                <BIconInstagram class="icon"></BIconInstagram>
                            </a>
                        </v-col>
                        <v-col lg="2">
                            <a href="https://www.facebook.com" target="_blank" class="footer-s">
                                <BIconFacebook class="icon"></BIconFacebook>
                            </a>
                        </v-col>
                        <v-col lg="2">
                            <a href="https://www.tiktok.com" target="_blank" class="footer-s">
                                <BIconTiktok class="icon"></BIconTiktok>
                            </a>
                        </v-col>
                    </v-row>
                </v-col>
                <v-col>
                    <p class="h6 footer-h">Newsletter</p>
                    <p>Chcete vedieť, čo chystáme? Prihláste sa na odber noviniek a pripojte sa ku nám.</p>
                    <input type="text" placeholder="Email" style="width: 100%; height: 50px;" class="my-3 p-3 rounded-2 text-black bg-white">
                    <v-btn type="submit" class="w-100 submit-button" :ripple="false" plain block>Odoslať</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    name: "FooterComponent"
}
</script>

<style lang="scss" scoped>
.icon {
    width: 48px;
    height: 48px;
    transition: 0.5s ease-in-out;
    &:hover {
        color: #d09c6e;
    }
}
.footer {
    letter-spacing: 2px;
}

.footer-h {
    color: #d09c6e;
}

.footer-s {
    text-decoration: none;
    color: white;
}

.address {
    margin-left: 10px;
    text-decoration: none;
    color: white;
    display: flex;
    align-items: center;
    :nth-child(1) {
        margin-right: 10px;
    }
}

.read-more {
    color: white;
    transition: 0.5s ease-in-out;
    &:hover {
        color: #d09c6e;
    }
}

.submit-button {
    background-color: white;
    transition: 0.3s ease-in-out;
    color: black;
    &:hover {
        color: #d09c6e;
    }
}
</style>
