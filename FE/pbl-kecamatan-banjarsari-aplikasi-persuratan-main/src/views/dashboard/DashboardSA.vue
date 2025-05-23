<template>
  <div>
    <WidgetsStatsA class="mb-4" />
    <CRow>
      <CCol :md="12">
        <CCard class="mb-4">
          <CCardHeader style="background-color: #003083; color: white; font-weight: bold; font-size: 1.2rem; text-align: center;">SURAT MASUK HARI INI</CCardHeader>
          <CCardBody>
            <CTable
                align="middle"
                class="mb-0 border"
                hover
                responsive>
                <CTableHead class="text-nowrap">
                    <CTableRow>
                        <CTableHeaderCell class="bg-body-secondary text-center">No.</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Tanggal Surat</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Nomor Surat</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Pengirim</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Perihal</CTableHeaderCell>
                    </CTableRow>
                </CTableHead>
                <CTableBody>
                  <CTableRow v-for="(surat, index) in suratMasuk.slice(0, 15)" :key="index">
                        <CTableDataCell class="text-center">{{ index + 1 }}</CTableDataCell>
                        <CTableDataCell>{{ formatDate(surat.tanggal_diterima) }}</CTableDataCell>
                        <CTableDataCell>{{ surat.no_surat }}</CTableDataCell>
                        <CTableDataCell>{{ surat.pengirim }}</CTableDataCell>
                        <CTableDataCell>{{ surat.isi_ringkas }}</CTableDataCell>
                    </CTableRow>
                </CTableBody>
            </CTable>
          </CCardBody>
        </CCard>
      </CCol>
    </CRow>
  </div>
</template>

<script>
import WidgetsStatsA from './../widgets/WidgetsStatsTypeA.vue'
import axios from 'axios'
import { ref, onMounted } from 'vue'

export default {
  name: 'Dashboard',
  components: {
    WidgetsStatsA,
  },

  setup() {
    const suratMasuk = ref([]);
    const kategoris = ref([]);

    const fetchData = () => {
      axios
        .get(`/api/suratmasuk/today?limit=15`)
        .then((response) => {
          if (response && response.data) {
            suratMasuk.value = response.data.data;
          } else {
            console.error('Invalid response structure:', response);
          }
        })
        .catch((error) => {
          console.error(
            'Error fetching data:',
            error.response ? error.response.data : error.message,
          );
        });
    };

    const fetchPerihal = () => {
      axios
        .get(`/api/kategoriperihal`)
        .then((response) => {
          kategoris.value = response.data
        })
        .catch((error) => {
          console.error(
            'Error fetching data:',
            error.response ? error.response.data : error.message,
          )
        })
    }

    const getPerihalName = (perihal) => {
      if (perihal.startsWith('Lainnya: ')) {
        return perihal.replace('Lainnya: ', '');
      }
      const kategori = kategoris.value.find((kategori) => kategori.perihal === perihal);
      return kategori ? kategori.perihal : perihal;
    }

    const formatDate = (dateString) => {
      const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
      const date = new Date(dateString);
      return date.toLocaleDateString('id-ID', options);
    }

    onMounted(() => {
      fetchData();
      fetchPerihal();
    });

    return {
      suratMasuk,
      getPerihalName,
      formatDate,
    };
  },
};
</script>
