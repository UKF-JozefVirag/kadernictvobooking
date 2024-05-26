<template>
    <main class="main">
        <section class="inner text-center" id="inner">
            <div class="container-fluid inner-content">
                <div class="sub-title mb-3">
                    <span>vaše vlasy sú naše plátno</span>
                </div>
                <div class="title">
                    <span>Barbershop Bratislava</span>
                </div>
                <div class="row sub-title justify-content-center">
                    <div class="col-md-3"></div>
                    <div class="col-md-3 col-sm-12 mb-3 mb-md-0">
                        <RouterLink
                            class="btn btn-cus btn-fill mx-2 border border-2 p-2 text-white"
                            to="/reservation"
                            replace
                        >
                            Rezervovať online termín
                        </RouterLink>
                    </div>
                    <div class="col-md-3 col-sm-12 mb-3 mb-md-0 ">
                        <a class="btn btn-cus btn-fill mx-2 border border-2 p-2 text-white" href="tel:0950444555">Zavolajte na 0987 123 456</a>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <span class="inner-decor-down rhomb-icon white-icon"><a href="#about-us"><i class="fa fa-chevron-down" aria-hidden="true"></i></a></span>
            </div>
        </section>
    </main>
    <RouterView />
</template>

<script>
import '../assets/js/bootstrap.min.js'

export default {
    name: "HeaderComponent"
}
</script>

<style>

</style>
