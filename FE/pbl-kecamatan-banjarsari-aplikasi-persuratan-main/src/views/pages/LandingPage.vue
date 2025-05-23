<template>
  <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center justify-content-center">
    <CCardBody class="text-center">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <CCarousel ref="carousel" controls indicators>
            <CCarouselItem>
              <div class="carousel-item-inner">
                <img class="d-block w-100 vh-100" style="opacity: 0.5;" src="@/assets/images/kec-banjarsari.jpg" alt="First slide" />
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                  <h1 style="font-size:480%;">RASUDI</h1>
                  <p style="font-size:180%;"><b>(Aplikasi Surat Undangan dan Disposisi)</b></p>
                  <p style="font-size:180%">merupakan layanan disposisi surat dan manajemen arsip milik Kecamatan Banjarsari</p>
                </div>
              </div>
            </CCarouselItem>
            <CCarouselItem>
              <div class="carousel-item-inner">
                <img class="d-block w-100 vh-100" style="opacity: 0.5;" src="@/assets/images/kec-banjarsari-2.jpg" alt="Fourth slide" />
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                  <h1>AGENDA KELUAR</h1>
                  <div class="mt-4 table-container">
                    <CCard class="mb-4">
                      <CCardHeader><b>AGENDA KELUAR</b></CCardHeader>
                      <CCardBody>
                        <CTable align="middle" class="mb-0 border" hover responsive>
                          <CTableHead class="text-nowrap">
                            <CTableRow>
                              <CTableHeaderCell class="bg-body-secondary text-center"></CTableHeaderCell>
                              <CTableHeaderCell class="bg-body-secondary">No.</CTableHeaderCell>
                              <CTableHeaderCell class="bg-body-secondary">Perihal</CTableHeaderCell>
                              <CTableHeaderCell class="bg-body-secondary">Waktu Agenda</CTableHeaderCell>
                              <CTableHeaderCell class="bg-body-secondary">Delegasi</CTableHeaderCell>
                              <CTableHeaderCell class="bg-body-secondary">Lokasi</CTableHeaderCell>
                            </CTableRow>
                          </CTableHead>
                          <CTableBody>
                            <CTableRow v-for="(agendak, index) in agendakeluar" :key="index">
                              <CTableDataCell class="text-center"></CTableDataCell>
                              <CTableDataCell>{{ index + 1 }}.</CTableDataCell>
                              <CTableDataCell>{{agendak.isi_ringkas}}</CTableDataCell>
                              <CTableDataCell>{{formatAgenda(agendak.tanggal_agenda)}}</CTableDataCell>
                              <CTableDataCell>{{agendak.penerima_disposisi}}</CTableDataCell>
                              <CTableDataCell>{{agendak.tempat_agenda}}</CTableDataCell>
                            </CTableRow>
                          </CTableBody>
                        </CTable>
                      </CCardBody>
                    </CCard>
                  </div>
                </div>
              </div>
            </CCarouselItem>
            <CCarouselItem>
              <div class="carousel-item-inner">
                <img class="d-block w-100 vh-100" style="opacity: 0.5;" src="@/assets/images/kec-banjarsari-3.jpg" alt="Fifth slide" />
                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                  <h1>AGENDA INTERNAL</h1>
                  <div class="mt-4 table-container">
                    <CCard class="mb-4">
                      <CCardHeader><b>AGENDA INTERNAL</b></CCardHeader>
                      <CCardBody>
                        <CTable align="middle" class="mb-0 border" hover responsive>
                          <CTableHead class="text-nowrap">
                            <CTableRow>
                              <CTableHeaderCell class="bg-body-secondary text-center"></CTableHeaderCell>
                              <CTableHeaderCell class="bg-body-secondary">No.</CTableHeaderCell>
                              <CTableHeaderCell class="bg-body-secondary">Perihal</CTableHeaderCell>
                              <CTableHeaderCell class="bg-body-secondary">Waktu Agenda</CTableHeaderCell>
                              <CTableHeaderCell class="bg-body-secondary">Lokasi</CTableHeaderCell>
                            </CTableRow>
                          </CTableHead>
                          <CTableBody>
                            <CTableRow v-for="(agendai, index) in agendainternal" :key="index">
                              <CTableDataCell class="text-center"></CTableDataCell>
                              <CTableDataCell>{{ index + 1 }}.</CTableDataCell>
                              <CTableDataCell>{{ agendai.isi_ringkas }}</CTableDataCell>
                              <CTableDataCell>{{ formatAgenda(agendai.tanggal_agenda) }}</CTableDataCell>
                              <CTableDataCell>{{ agendai.tempat_agenda }}</CTableDataCell>
                            </CTableRow>
                          </CTableBody>
                        </CTable>
                      </CCardBody>
                    </CCard>
                  </div>
                </div>
              </div>
            </CCarouselItem>
          </CCarousel>
        </div>
      </div>
    </CCardBody>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'

import LandingLayout from '../../layouts/LandingLayout.vue';

export default {
  name: 'LandingPage',
  components: {
    LandingLayout,
  },
  setup() {
    const agendainternal = ref([])
    const agendakeluar = ref([])

    const fetchAgendaInternal = async () => {
      try {
        const response = await axios.get('/api/arsipsurat/agenda/internal')
        if (response.data && response.data.data_agenda_internal) {
          agendainternal.value = response.data.data_agenda_internal
        }
      } catch (error) {
      }
    }

    const fetchAgendaKeluar = async () => {
      try {
        const response = await axios.get('/api/arsipsurat/agenda/keluar')
        if (response.data && response.data.data_agenda_keluar) {
          agendakeluar.value = response.data.data_agenda_keluar
        }
      } catch (error) {
      }
    }

    const formatAgenda = (dateString) => {
      const options = {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
      };
      const dateParts = dateString.split(' ');
      const date = new Date(`${dateParts[0]}T${dateParts[1]}`);
      const formattedDate = date.toLocaleDateString('id-ID', options);
      const hours = date.getHours().toString().padStart(2, '0');
      const minutes = date.getMinutes().toString().padStart(2, '0');
      return `${formattedDate.replace('', '')} | ${hours}.${minutes} WIB`;
    }

    onMounted(() => {
      fetchAgendaInternal()
      fetchAgendaKeluar()
      startCarousel()
      refreshHalaman()
      setInterval(() => {
        fetchAgendaInternal()
        fetchAgendaKeluar()
      }, 5000);
    })

    const startCarousel = () => {
      const carousel = document.querySelector('.carousel')
      if (carousel) {
        setInterval(() => {
          const nextButton = carousel.querySelector('.carousel-control-next')
          if (nextButton) {
            nextButton.click()
          }
        }, 30000)
      }
    }

    const refreshHalaman = () => {
      setTimeout(function() {
          location.reload();
      }, 95000);
    }

    return {
      agendainternal,
      agendakeluar,
      formatAgenda,
      refreshHalaman
    }
  }
}
</script>

<style>
.carousel-item-inner {
  position: relative;
  height: 100vh;
}

.carousel-item-inner::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.carousel-caption {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
}

.table-container {
  max-width: 1200px;
  width: 100%;
}
</style>