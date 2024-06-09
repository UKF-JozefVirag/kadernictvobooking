<template>
    <SectionDescriber :section-name="$t('gallery.sectionName')" class="mt-5" id="gallery"></SectionDescriber>
    <ImageGallery :images="images"></ImageGallery>
    <div style="border-bottom: 1px solid #ececec;"></div>
</template>

<script>
import ImageGallery from "@/components/home/ImageGallery.vue";
import SectionDescriber from "@/components/home/SectionDescriber.vue";

export default {
    name: "GalleryView",
    components: {SectionDescriber, ImageGallery },
    data() {
        let src = "/src/assets/images/gallery/";
        return {
            images: [
                { id: 1, imgSrc: src + "inside.jpg" },
                { id: 2, imgSrc: src + "inside-chair.jpg" },
                { id: 3, imgSrc: src + "inside-chairs.jpg" },
                { id: 4, imgSrc: src + "outside.jpg" },
                { id: 5, imgSrc: src + "salon.jpg" },
                { id: 6, imgSrc: src + "trimmers.jpg" },
                { id: 7, imgSrc: src + "washing-basin.jpg" },
                { id: 8, imgSrc: src + "carousel2.jpg" },
                { id: 9, imgSrc: src + "carousel3.jpg" }
            ]
        };
    }
};
</script>

<style scoped>
</style>
