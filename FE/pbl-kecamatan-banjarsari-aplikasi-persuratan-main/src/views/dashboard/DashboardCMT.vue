<template>
  <div>
    <WidgetsStatsC class="mb-4" />
    <CRow>
      <CCol :md="12">
        <CCard class="mb-4">
          <CCardHeader style="background-color: #003083; color: white; font-weight: bold; font-size: 1.2rem; text-align: center;">
            AGENDA INTERNAL
          </CCardHeader>
          <CCardBody>
            <CTable align="middle" class="mb-0 border" hover responsive>
              <CTableHead class="text-nowrap" style="background-color: #f0f0f0; font-weight: bold;">
                <CTableRow>
                  <CTableHeaderCell class="text-center"></CTableHeaderCell>
                  <CTableHeaderCell>No.</CTableHeaderCell>
                  <CTableHeaderCell>Perihal</CTableHeaderCell>
                  <CTableHeaderCell>Waktu Agenda</CTableHeaderCell>
                  <CTableHeaderCell>Lokasi</CTableHeaderCell>
                </CTableRow>
              </CTableHead>
              <CTableBody>
                <CTableRow v-for="(agenda, index) in agendainternal" :key="index">
                  <CTableDataCell class="text-center"></CTableDataCell>
                  <CTableDataCell>{{ index + 1 }}.</CTableDataCell>
                  <CTableDataCell>{{ agenda.isi_ringkas }}</CTableDataCell>
                  <CTableDataCell>{{ formatAgenda(agenda.tanggal_agenda) }}</CTableDataCell>
                  <CTableDataCell>{{ agenda.tempat_agenda }}</CTableDataCell>
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
import { ref, onMounted } from 'vue'
import axios from 'axios'

import WidgetsStatsC from './../widgets/WidgetsStatsTypeC.vue'

export default {
  name: 'Dashboard',
  components: {
    WidgetsStatsC,
  },
  setup() {
    const agendainternal = ref([])

    const fetchAgendaInternal = async () => {
      try {
        const response = await axios.get('/api/arsipsurat/agenda/internal')
        agendainternal.value = response.data.data_agenda_internal
      } catch (error) {
        console.error(
          'Error fetching data:',
          error.response ? error.response.data : error.message,
        )
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
    })

    return {
      agendainternal,
      formatAgenda
    }
  },
}
</script>

<style scoped>
/* Add any relevant styling here */
</style>
