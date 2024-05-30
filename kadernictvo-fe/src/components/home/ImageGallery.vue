<template>
    <v-container>
        <v-row
            align="center"
            justify="center"
        >
            <v-col
                v-for="(image, imageIndex) in images"
                :key="imageIndex"
                cols="12"
                sm="6"
                md="4"
                lg="4"
            >
                <v-img
                    class="image"
                    @click="index = imageIndex"
                    :style="{ backgroundImage: 'url(' + image.imgSrc + ')', width: '100%', height: '300px', cursor: 'pointer' }"
                ></v-img>
            </v-col>
        </v-row>
        <v-gallery :images="images.map(image => image.imgSrc)" :index="index" @close="index = null"></v-gallery>
    </v-container>
</template>

<script>
import VueGallery from 'vue-gallery';

export default {
    name: 'ImageGallery',
    components: {
        'v-gallery': VueGallery
    },
    data() {
        return {
            index: null
        };
    },
    props: {
        images: {
            type: Array,
            required: true
        }
    }
};
</script>

<style lang="scss" scoped>
.image {
    background-size: cover;
    border: 1px solid #ebebeb;
    margin: 5px;
    transition: 0.5s ease-in-out;
    &:hover {
        filter: grayscale(1);
    }

}
</style>
