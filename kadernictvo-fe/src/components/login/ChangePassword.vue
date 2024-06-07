<template>
    <v-card class="p-3">
        <v-card-title>
            <h3>Change password</h3>
            <p class="text-danger text-h5">Still in implementation, email provider needs to be configured for this functionality !</p>
        </v-card-title>
        <v-card-subtitle>
            <v-row>
                <v-col cols="12">
                    <p>These are the credentials associated with your user profile. Use the form below to update your password, which will enhance the security of your account.</p>
                    <hr>
                </v-col>
            </v-row>
        </v-card-subtitle>
        <v-card-text>
            <v-row>
                <v-col cols="12">
                    <h6>Current password<span class="text-danger">*</span></h6>
                    <v-text-field></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <h6>New password<span class="text-danger">*</span></h6>
                    <v-text-field></v-text-field>
                </v-col>
            </v-row>
        </v-card-text>
        <v-card-actions>
            <v-row>
                <v-col cols="3">
                    <v-btn class="ms-2" color="primary" :ripple="false" variant="elevated" plain block>Save</v-btn>
                </v-col>
            </v-row>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    name: "ChangePassword"
}
</script>

<style scoped>

</style>
