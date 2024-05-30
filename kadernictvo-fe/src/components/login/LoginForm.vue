<template>
    <v-form ref="form" lazy-validation>
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-text-field label="Email" variant="outlined"></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field label="Password" variant="outlined"></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="6">
                    <v-checkbox-btn v-ripple="false" plain id="xx" label="Remember Me"></v-checkbox-btn>
                </v-col>
                <v-col cols="6">
                    <a href="#">Forgot password ?</a>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-btn :ripple="false" plain>Sign in</v-btn>
                </v-col>
            </v-row>
        </v-container>
    </v-form>
</template>

<script>
export default {
    name: "LoginForm",
};
</script>

<style lang="scss">
.xx::before {
    background-color: transparent !important;
}
$button-background: yellow !important;
</style>
