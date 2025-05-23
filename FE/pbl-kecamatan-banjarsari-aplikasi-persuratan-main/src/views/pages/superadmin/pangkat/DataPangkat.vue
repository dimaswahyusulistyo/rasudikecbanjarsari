<template>
  <h5>DATA PANGKAT JABATAN</h5>
  <CCard class="mb-4">
    <div v-for="(tier, tierIndex) in tiers" :key="tierIndex" style="text-align: center">
      <CCardHeader>
        <b>{{ tier.tier_name }}</b></CCardHeader
      >
      <CCardBody>
  <CTable align="center" class="mb-0 border" hover responsive>
    <CTableHead class="text-nowrap">
      <CTableRow style="text-align: left">
        <CTableHeaderCell class="bg-body-secondary text-center"></CTableHeaderCell>
        <CTableHeaderCell class="bg-body-secondary">No.</CTableHeaderCell>
        <CTableHeaderCell class="bg-body-secondary">Jabatan</CTableHeaderCell>
        <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
      </CTableRow>
    </CTableHead>
    <CTableBody>
      <CTableRow v-for="(jabatan, index) in tier.jabatans" :key="index" style="text-align: left;">
        <CTableDataCell class="text-center"></CTableDataCell>
        <CTableDataCell style="width: 10%;">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</CTableDataCell>
        <CTableDataCell style="width: 40%;">{{ jabatan.nama_jabatan }}</CTableDataCell>
        <CTableDataCell style="width: 30%;">
          <CButton color="warning" @click="editJabatan(jabatan.id_jabatan)" class="me-1">
            <i class="fas fa-pencil-alt"></i>
          </CButton>
          <CButton color="danger" @click="deleteTierOnJabatan(jabatan.id_jabatan)">
            <i class="fas fa-trash"></i>
          </CButton>
        </CTableDataCell>
      </CTableRow>
    </CTableBody>
  </CTable>
</CCardBody>

    </div>
  </CCard>
</template>

<script>
export default {
  data() {
    return {
      tiers: [],
      searchQuery: '',
      filter: 'az',
      currentPage: 1,
      itemsPerPage: 10,
    }
  },
  mounted() {
    this.fetchTiers()
  },
  methods: {
    fetchTiers() {
      this.$axios
        .get('/tiers')
        .then((response) => {
          this.tiers = response.data.data
        })
        .catch((error) => {
          console.error('There was an error fetching the tiers!', error)
        })
    },
    search() {
      this.$axios
        .get(`/api/jabatan/search`, {
          params: { keywords: this.searchQuery },
        })
        .then((response) => {
          if (response && response.data) {
            this.tiers = response.data 
          } else {
            console.error('Invalid response structure:', response)
          }
        })
        .catch((error) => {
          console.error(
            'Error fetching data:',
            error.response ? error.response.data : error.message,
          )
        })
    },
    changeFilter(selectedFilter) {
      this.filter = selectedFilter
      this.fetchTiers() 
    },
    editJabatan(id) {
      this.$router.push(`/editjabatan/${id}`)
    },
    deleteTierOnJabatan(id_jabatan) {
      if (confirm('Apakah Anda yakin untuk menghapus Pangkat pada Jabatan ini?')) {
        this.$axios
          .put(`/jabatan/${id_jabatan}/removetier`)
          .then((response) => {
            alert('Tiers pada Jabatan berhasil dihapus!')
            this.fetchTiers()
          })
          .catch((error) => {
            console.error('error', error)
          })
      }
    },
  },
}
</script>
