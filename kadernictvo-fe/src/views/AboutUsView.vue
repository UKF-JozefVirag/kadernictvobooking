<template>
    <v-container fluid class="aboutContainer mt-5" id="about-us">
        <v-row>
            <v-col align-self="center">
                <SectionDescriber section-name="O nás" class="text-black"></SectionDescriber>
            </v-col>
        </v-row>
        <v-row align="center">
            <v-col offset="1" cols="10" class="text">
                <p class="text-center" style="letter-spacing: 2px">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad alias aliquid at commodi cum dignissimos eveniet excepturi exercitationem,
                    facilis, illum in laboriosam molestiae odio quis reiciendis saepe sapiente sint tempora ut voluptatibus. Amet dignissimos esse quas quibusdam?
                    Dignissimos, dolorum totam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                </p>
                <p class="text-center" style="letter-spacing: 2px">
                    A alias doloribus fuga odit quisquam, reprehenderit. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti minus quas sequi sint tenetur!
                    Cupiditate fugit rerum sequi ullam veniam. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus amet animi aspernatur atque, aut cumque
                    dolores doloribus fugit illo illum itaque magnam minus modi numquam officia placeat quibusdam quidem quo ratione repudiandae sed sint soluta sunt totam
                    ut vel vitae!
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
import SectionDescriber from "@/components/SectionDescriber.vue";

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
