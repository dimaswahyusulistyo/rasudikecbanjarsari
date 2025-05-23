<template>
  <CFooter class="text-white p-3" style="background-color: #003083;">
    <div class="container text-center text-md-left mt-auto">
      <hr class="h">
      <div class="row text-center">
        <div class="col-md-6">
          <img src="@/assets/images/logo-footer.png" alt="Logo" width="300" height="auto">
        </div>
        <div class="col-md-6 text-left">
          <div class="p-3" style="text-align: left;">
            <p>
              <CIcon icon="cilLocationPin" />
              Jl. Adi Sumarmo No. 136, Surakarta, Jawa Tengah, Indonesia
            </p>
            <p>
              <CIcon icon="cilPhone" />
              (0271) 740775
            </p>
            <p>
              <CIcon icon="cilEnvelopeClosed" />
              kec-banjarsari@surakarta.go.id
            </p>
          </div>
        </div>
      </div>
      <hr class="h2">
      <div class="row align-items-center justify-content-md-center">
        <div class="col-md-7 col-lg-8 text-center">
          <p>Copyright © 2024 • Kecamatan Banjarsari
          </p>
        </div>
      </div>
    </div>
  </CFooter>
</template>

<script>
export default {
  name: 'AppFooter',
}
</script>
