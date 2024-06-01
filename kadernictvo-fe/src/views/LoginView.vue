<template>
    <section class="vh-100 d-flex align-items-center justify-content-center">
        <div class="container d-flex justify-content-center">
            <div class="card position-relative">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <LoginForm></LoginForm>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import LoginForm from "@/components/login/LoginForm.vue";

export default {
    name: "LoginView",
    components: {LoginForm}
};
</script>

<style lang="scss" scoped>
.card {
    border-radius: 20px;
    background-color: #000000;
    box-shadow: 0 0 20px rgb(0, 0, 0);
}
</style>
