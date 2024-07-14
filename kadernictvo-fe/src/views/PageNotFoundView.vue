<template>
    <div class="background vh-100 vw-100">
        <v-container fluid>
            <v-row class="text-center justify-center align-center">
                <v-col cols="12">
                    <BIconScissors class="h5" style="color: white"></BIconScissors>
                    <h2 class="status-error" style="color: #d09c6e">
                        404
                    </h2>
                    <p class="text-status-error">
                        {{ this.$t('error_page.title') }}
                    </p>
                    <p class="text-status-error-2 mt-4 mb-8">
                        {{ this.$t('error_page.subtitle') }}
                    </p>
                </v-col>
                <v-col cols="12" xs="12" sm="8" md="4" lg="2" xl="2" offset-sm="2" offset-lg="4" offset-xl="5" class="d-flex justify-center">
                    <v-btn type="submit" class="submit-button" @click="$router.push('/')" :ripple="false" plain block>{{ this.$t('error_page.button') }}</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    name: 'PageNotFoundView',
}
</script>

<style lang="scss" scoped>


.status-error {
    font-size: 8rem;
    line-height: 1;
    font-weight: 800;
    margin-bottom: 25px;
}

.text-status-error {
    font-size: 1.5rem;
    line-height: 2rem;
    font-weight: 600;
    color: white;
}

.text-status-error-2 {
    color: rgb(156 163 175);
}

.submit-button {
    background-color: white;
    transition: 0.3s ease-in-out;
    color: black;
    text-decoration: none;

    &:hover {
        color: #d09c6e;
    }
}
</style>
