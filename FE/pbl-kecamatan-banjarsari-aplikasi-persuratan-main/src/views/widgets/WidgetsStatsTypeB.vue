<template>
    <CCol class="mb-3 mt-2" style="border-left: 5px solid #28a745; padding-left: 4px;">
      <CWidgetStatsA>
        <template #value>
          <h5>DASHBOARD</h5>
        </template>
        <template #title>
          Selamat datang <b style="color: #28a745;">{{user?.pegawai?.nama_pegawai}}</b> di Aplikasi Persuratan! Anda login
          sebagai <span class="btn btn-success mr-1 btn-sm text-white rounded" style="margin-bottom: 8px;">{{ user?.role }}</span>
        </template>
      </CWidgetStatsA>
    </CCol>
  
    <CRow class="mb-2" :xs="{ gutter: 4 }">
      <CCol :xl="4" class="mb-2">
        <CWidgetStatsA color="primary" class="h-100 d-flex flex-column justify-content-between">
          <template #value>
            DISPOSISI SAYA
          </template>
          <template #title>
            <span style="font-size: 20px;">{{totaldispo.total_dispo}}</span>
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

  import { getStyle } from '@coreui/utils'
  
  export default {
    name: 'WidgetsStatsA',
    setup() {
      const widgetChartRef1 = ref()
      const widgetChartRef2 = ref()

      const user = ref(null)
      const totaldispo = ref(0)

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
    const fetchTotalDispo = () => {
      const token = localStorage.getItem('token')
      axios
        .get('/api/disposisi/total', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          if (response && response.data && response.data.data) {
            totaldispo.value = response.data.data
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
        fetchTotalDispo()
      })
  
      return { 
        getStyle, 
        widgetChartRef1, 
        widgetChartRef2,
        user,
        totaldispo
      }
    },
  }
  </script>
  