<template>
    <v-container fluid>
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
                    Dignissimos, dolorum totam. Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                </p>
            </v-col>
        </v-row>
        <v-spacer></v-spacer>
        <v-row>
            <v-col offset="1" cols="10" align-self="center" class="text-center">
                <v-carousel :show-arrows="false" hide-delimiters
                            cycle>
                    <v-carousel-item
                        v-for="(item,i) in images"
                        :key="i"
                        :src="item.src"
                        cover
                    ></v-carousel-item>
                </v-carousel>
            </v-col>
        </v-row>
    </v-container>

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
                    src: 'src/assets/beard1.jpg',
                },
                {
                    src: 'src/assets/fade1.jpg',
                },
                {
                    src: 'src/assets/fade2.jpg',
                },
            ]
        }
    }
}
</script>

<style scoped>


</style>
