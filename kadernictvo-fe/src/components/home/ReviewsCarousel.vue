<template>
    <v-carousel class="carousel reviews bg-black mt-5 text-center text-white" hide-delimiters>
        <template v-slot:prev="{ props }">
            <a class="btn btn-cus text-white carousel-arrow left" @click="props.onClick">
                <span class="mdi mdi-chevron-left"></span>
            </a>
        </template>
        <template v-slot:next="{ props }">
            <a class="btn btn-cus text-white carousel-arrow right" @click="props.onClick">
                <span class="mdi mdi-chevron-right"></span>
            </a>
        </template>

        <v-carousel-item class="carousel text-center" v-for="(review, i) in translatedReviews" :key="i">
            <div class="carousel-items">
                <div class="title text-white">
                    <span>{{ review.title }}</span>
                </div>
                <p class="review-comment">{{ review.comment }}</p>
                <v-rating readonly class="text-white" :model-value="review.rating" density="default"></v-rating>

                <br>
                <span class="author">— {{ review.author }}</span>
            </div>
        </v-carousel-item>
    </v-carousel>
</template>

<script>
export default {
    name: "ReviewsCarousel",
    computed: {
        translatedReviews() {
            return [
                {
                    title: this.$t('reviews.title'),
                    comment: this.$t('reviews.comments.0.comment'),
                    rating: Number(this.$t('reviews.comments.0.rating')),
                    author: this.$t('reviews.comments.0.author')
                },
                {
                    title: this.$t('reviews.title'),
                    comment: this.$t('reviews.comments.1.comment'),
                    rating: Number(this.$t('reviews.comments.1.rating')),
                    author: this.$t('reviews.comments.1.author')
                },
                {
                    title: this.$t('reviews.title'),
                    comment: this.$t('reviews.comments.2.comment'),
                    rating: Number(this.$t('reviews.comments.2.rating')),
                    author: this.$t('reviews.comments.2.author')
                }
            ];
        }
    }
}
</script>

<style lang="scss" scoped>
.v-btn {
    background-color: transparent;
    color: white;

    &:hover {
        background-color: transparent;
        color: white;
    }

    transition: none;
}

.carousel-items {
    margin: 0;
    position: relative;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    max-width: 70%;
}

.v-list-item__overlay {
    background-color: theme("colors.primary.500") !important;
}
</style>
