<template>
  <CCol class="mb-3 mt-2" style="border-left: 5px solid #28a745; padding-left: 4px;">
    <CWidgetStatsA>
      <template #value>
        <h5>DASHBOARD</h5>
      </template>
      <template #title>
        Selamat datang <b style="color: #28a745;">{{ user?.pegawai?.nama_pegawai }}</b> di Aplikasi Persuratan! Anda login
        sebagai <span class="btn btn-success mr-1 btn-sm text-white rounded" style="margin-bottom: 8px;">{{ user?.role}}</span>
      </template>
    </CWidgetStatsA>
  </CCol>

  <CRow class="mb-2" :xs="{ gutter: 4 }">
    <!-- <CCol :sm="12" :xl="4" :xxl="3" col> -->
    <CCol :xl="4" class="mb-2">
      <CWidgetStatsA color="primary" class="h-100 d-flex flex-column justify-content-between">
        <template #value>
          <!-- <CIcon name="cil-people" class="me-2" size="xl"/> -->
          JUMLAH PEGAWAI
        </template>
        <template #title>
          <span style="font-size: 20px;">{{ jmlpgw.total_pgw }}</span>
        </template>
        <br>
      </CWidgetStatsA>
    </CCol>
    <!-- <CCol :sm="12" :xl="4" :xxl="3" col> -->
    <CCol :xl="4" class="mb-2">
      <CWidgetStatsA color="info" class="h-100 d-flex flex-column justify-content-between">
        <template #value>
          <!-- <CIcon name="cil-envelope-open" class="me-2" size="xl"/> -->
          SURAT MASUK
        </template>
        <template #title>
          <span style="font-size: 20px;">{{ totalsm.total_sm }}</span>
        </template>
        <br>
      </CWidgetStatsA>
    </CCol>
    <!-- <CCol :sm="12" :xl="4" :xxl="3" col> -->
    <CCol :xl="4" class="mb-2">
      <CWidgetStatsA color="warning" class="h-100 d-flex flex-column justify-content-between">
        <template #value>
          <!-- <CIcon name="cil-envelope-closed" class="me-2" size="xl"/> -->
          SURAT KELUAR
        </template>
        <template #title>
          <span style="font-size: 20px;">{{ totalsk.total_sk }}</span>
        </template>
        <br>
      </CWidgetStatsA>
    </CCol>
  </CRow>

</template>

<script>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import router from '@/router'
import { CChart } from '@coreui/vue-chartjs'
import { getStyle } from '@coreui/utils'

export default {
  name: 'WidgetsStatsA',
  components: {
    CChart,
  },
  setup() {
    const widgetChartRef1 = ref()
    const widgetChartRef2 = ref()

    const user = ref(null)
    const jmlpgw = ref(0)
    const totalsm = ref(0)
    const totalsk = ref(0)

    const fetchData = () => {
      const token = localStorage.getItem('token')
      axios
        .get('/api/user', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          if (response && response.data && response.data.user) {
            user.value = response.data.user
          } else {
            console.error('Invalid response structure:', response)
          }
        })
        .catch((error) => {
          console.error('Error fetching data:', error)
          if (error.response && error.response.status === 401) {
            router.push('/login')
          }
        })
    }

    const fetchTotalpgw = () => {
      axios
        .get(`/api/pegawai/total`)
        .then((response) => {
          jmlpgw.value = response.data.data
        })
        .catch((error) => {
          console.error(
            'Error fetching data:',
            error.response ? error.response.data : error.message,
          )
        })
    }

    const fetchTotalsm = () => {
      axios
        .get(`/api/suratmasuk/total`)
        .then((response) => {
          totalsm.value = response.data.data
        })
        .catch((error) => {
          console.error(
            'Error fetching data:',
            error.response ? error.response.data : error.message,
          )
        })
    }

    const fetchTotalsk = () => {
      axios
        .get(`/api/suratkeluar/total`)
        .then((response) => {
          totalsk.value = response.data.data
        })
        .catch((error) => {
          console.error(
            'Error fetching data:',
            error.response ? error.response.data : error.message,
          )
        })
    }


    onMounted(() => {
      document.documentElement.addEventListener('ColorSchemeChange', () => {
        if (widgetChartRef1.value) {
          widgetChartRef1.value.chart.data.datasets[0].pointBackgroundColor =
            getStyle('--cui-primary')
          widgetChartRef1.value.chart.update()
        }

        if (widgetChartRef2.value) {
          widgetChartRef2.value.chart.data.datasets[0].pointBackgroundColor =
            getStyle('--cui-info')
          widgetChartRef2.value.chart.update()
        }
      })

      fetchData()
      fetchTotalpgw()
      fetchTotalsm()
      fetchTotalsk()
    })

    return { 
      getStyle, 
      widgetChartRef1, 
      widgetChartRef2,
      user,
      jmlpgw,
      totalsm,
      totalsk
    
    }
  },
}
</script>