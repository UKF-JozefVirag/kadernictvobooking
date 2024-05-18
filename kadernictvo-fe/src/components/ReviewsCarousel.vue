<template>

    <v-carousel class="carousel reviews bg-black mt-5 text-center text-white"
                hide-delimiters>
        <template v-slot:prev="{ props }">
            <a
                class="btn btn-cus text-white carousel-arrow left"
                @click="props.onClick"
            > <span class="mdi mdi-chevron-left"></span>
            </a>
        </template>
        <template v-slot:next="{ props }">
            <a
                class="btn btn-cus text-white carousel-arrow right"
                @click="props.onClick"
            > <span class="mdi mdi-chevron-right"></span>
            </a>
        </template>

            <v-carousel-item
                class="carousel text-center"
                v-for="(review, i) in reviews"
                :key="i">
                <div class="carousel-items">
                    <div class="title text-white">
                        <span>Čo o nás povedali?</span>
                    </div>
                    <p class="review-comment">{{ review.comment }}</p>
                    <v-rating
                        readonly
                        class="text-white"
                        v-model="review.rating"
                        density="default"
                    ></v-rating>
                    <br>
                    <span class="author">— {{review.author}}</span>
                </div>
            </v-carousel-item>
    </v-carousel>
</template>

<script>
export default {
    name: "ReviewsCarousel",
    data() {
        return {
            reviews: [
                {
                    comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad alias aliquid at commodi cum dignissimos eveniet excepturi exercitationem",
                    author: "Martin",
                    rating: 5
                },
                {
                    comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad alias aliquid at commodi cum dignissimos eveniet excepturi exercitationem,facilis,illum in laboriosam molestiae odio quis reiciendis saepe sapiente sint tempora ut voluptatibus. Amet dignissimos esse quas quibusdam?",
                    author: "Juraj",
                    rating: 4.5
                },
                {
                    comment: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad alias aliquid at commodi cum dignissimos eveniet excepturi exercitationem et, consectetur adipisicing elit. Ad alias aliquid at",
                    author: "Albert",
                    rating: 5
                }
            ]
        }
    }
}
</script>

<style lang="scss" scoped>
.v-btn {
    background-color: transparent;
    color: white;
    &:hover{
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
