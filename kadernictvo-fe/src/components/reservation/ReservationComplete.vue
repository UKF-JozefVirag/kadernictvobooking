<template>
    <v-container class="reservation-complete-container">
        <v-card class="text-center shadow-lg">
            <BIconCheckCircleFill style="color: #d09c6e" class="align-start"></BIconCheckCircleFill>
            <v-card-title class="text-h4" style="color: #d09c6e">{{ this.$t('reservation_complete.title')}}</v-card-title>
            <v-card-text>
                <p>{{ this.$t('reservation_complete.subtitleFirst')}}</p>
                <p>{{ this.$t('reservation_complete.subtitleSecond')}}: {{ email }}.</p>
                <p>{{ this.$t('reservation_complete.subtitleThird')}}</p>
            </v-card-text>
            <v-card-actions class="justify-content-center">
                <v-btn class="homeBtn" @click="goHome">{{ this.$t('reservation_complete.button')}}</v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>

<script>
export default {
    name: 'ReservationComplete',
    data() {
      return {
          email: null
      }
    },
    methods: {
        goHome() {
            this.$router.push('/');
        }
    },
    mounted() {
        this.email = this.$route.query.email;
    }
}
</script>

<style scoped>
.reservation-complete-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 60vh;
}

.homeBtn {
    background-color: white;
    transition: 0.3s ease-in-out;
    color: black;
    text-decoration: underline;

    &:hover {
        color: #d09c6e;
    }
}
</style>
