<template>
    <v-container fluid class="aboutContainer mt-5" id="about-us">
        <v-row>
            <v-col align-self="center">
                <SectionDescriber :section-name="$t('about.section_name')" class="text-black"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row align="center">
            <v-col offset="1" cols="10" class="text">
                <p class="text-center" style="letter-spacing: 2px">
                    {{ $t('about.paragraph_1') }}
                </p>
                <p class="text-center" style="letter-spacing: 2px">
                    {{ $t('about.paragraph_2') }}
                </p>
            </v-col>
        </v-row>
        <v-spacer></v-spacer>
        <v-row>
            <v-col offset="1" cols="10" align-self="center" class="text-center">
                <v-carousel hide-delimiters :show-arrows="false"
                            cycle interval="3000" class="shadow-lg">
                    <v-carousel-item
                        v-for="(item,i) in images"
                        :key="i"
                        eager
                    >
                        <v-img :src="item.src" height="100%" cover></v-img>
                    </v-carousel-item>
                </v-carousel>
            </v-col>
        </v-row>
    </v-container>
    <div style="border-bottom: 1px solid #ececec;"></div>
</template>

<script>
import SectionDescriber from "@/components/home/SectionDescriber.vue";

export default {
    name: "AboutUsView",
    components: {SectionDescriber},
    data() {
        return {
            images: [
                {
                    src: 'src/assets/images/carousel/carousel1.jpg',
                },
                {
                    src: 'src/assets/images/carousel/carousel2.jpg',
                },
                {
                    src: 'src/assets/images/carousel/carousel3.jpg',
                },
            ]
        }
    }
}
</script>

<style scoped>
.aboutContainer {
    height: 100%;
}
</style>
