<template>
    <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline">{{ service ? $t('services_view.editService') : $t('services_view.addService') }}</span>
            </v-card-title>
            <v-card-text>
                <v-form ref="form" v-model="valid" lazy-validation>
                    <v-text-field
                        v-model="serviceData.name"
                        :label="$t('services_view.name')"
                        :rules="[v => !!v || $t('services_view.name') + ' ' + $t('services_view.isRequired')]"
                        variant="outlined"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="serviceData.desc"
                        :label="$t('services_view.desc')"
                        :rules="[v => !!v || $t('services_view.desc') + ' ' + $t('services_view.isRequired')]"
                        variant="outlined"
                        required
                    ></v-text-field>
                    <v-file-input
                        v-model="imageFile"
                        :label="$t('services_view.image')"
                        :rules="[v => !!v || $t('services_view.image') + ' ' + $t('services_view.isRequired')]"
                        variant="outlined"
                    ></v-file-input>
                    <v-img
                        v-if="serviceData.image && !imageFile"
                        :src="getImageUrl(serviceData.image)"
                        :alt="serviceData.name"
                        class="my-3 mx-auto"
                        width="100px"
                        height="100px"
                    ></v-img>
                    <v-text-field
                        v-model="serviceData.price"
                        :label="$t('services_view.price')"
                        :rules="[v => !!v || $t('services_view.price') + ' ' + $t('services_view.isRequired')]"
                        variant="outlined"
                        required
                    ></v-text-field>
                    <v-text-field
                        v-model="serviceData.duration"
                        :label="$t('services_view.duration')"
                        :rules="[v => !!v || $t('services_view.duration') + ' ' + $t('services_view.isRequired')]"
                        variant="outlined"
                        required
                    ></v-text-field>
                </v-form>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" @click="cancel">{{ $t('buttons.cancel') }}</v-btn>
                <v-btn color="blue darken-1" @click="save">{{ $t('buttons.submit') }}</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
import axios from 'axios';
import axiosInstance from '@/axios.js'

export default {
    name: 'ServiceForm',
    props: {
        service: Object
    },
    data() {
        return {
            dialog: true,
            valid: false,
            serviceData: this.service ? { ...this.service } : { name: '', desc: '', image: '', price: '', duration: '' },
            imageFile: null
        }
    },
    watch: {
        service(newVal) {
            this.serviceData = newVal ? { ...newVal } : { name: '', desc: '', image: '', price: '', duration: '' };
            this.imageFile = null;
        },
        imageFile() {
            if (this.imageFile) {
                this.serviceData.image = null;
            }
        }
    },
    methods: {
        cancel() {
            this.$emit('cancel');
        },
        async save() {
            if (await this.$refs.form.validate()) {
                try {
                    const token = this.$cookies.get('token');
                    const config = {
                        headers: {
                            'Authorization': `Bearer ${decodeURIComponent(token)}`,
                            'Content-Type': 'multipart/form-data'
                        }
                    };

                    const formData = new FormData();
                    formData.append('name', this.serviceData.name);
                    formData.append('desc', this.serviceData.desc);
                    formData.append('price', this.serviceData.price);
                    formData.append('duration', this.serviceData.duration);

                    if (this.imageFile) {
                        formData.append('image', this.imageFile);
                    }

                    if (this.serviceData.id) {
                        formData.append('_method', 'PATCH');
                    }

                    await this.sendData(formData, config);
                } catch (error) {
                    console.error(error);
                }
            }
        },
        async sendData(formData, config) {
            let response;
            if (this.serviceData.id) {
                response = await axiosInstance.post(`/services/${this.serviceData.id}`, formData, config);
            } else {
                response = await axiosInstance.post(`/services`, formData, config);
            }
            this.$emit('save', response.data);
        },
        getImageUrl(image) {
            return image ? `http://localhost:8000/storage/${image}` : '';
        }
    }
}
</script>

<style scoped>
</style>
