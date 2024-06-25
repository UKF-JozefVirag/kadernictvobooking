<template>
    <main class="main" id="home">
        <section class="inner text-center" id="inner">
            <div class="container-fluid inner-content">
                <div class="sub-title mb-3">
                    <span>{{ $t('header.slogan') }}</span>
                </div>
                <div class="title">
                    <span>{{ $t('header.title') }}</span>
                </div>
                <div class="row sub-title justify-content-center">
                    <div class="col-md-3"></div>
                    <div class="col-md-3 col-sm-12 mb-3 mb-md-0">
                        <router-link to="/reservation" class="btn btn-cus btn-fill mx-2 border border-2 p-2 text-white" href="#">
                            {{ $t('header.book_online') }}
                        </router-link>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-3 mb-md-0">
                        <a class="btn btn-cus btn-fill mx-2 border border-2 p-2 text-white" href="tel:0950444555">
                            {{ $t('header.call_us') }}
                        </a>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <span class="inner-decor-down rhomb-icon white-icon">
                    <a href="#about-us"><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                </span>
            </div>
        </section>
    </main>
</template>

<script>

export default {
    name: "HeaderComponent"
}
</script>

<style>

</style>
