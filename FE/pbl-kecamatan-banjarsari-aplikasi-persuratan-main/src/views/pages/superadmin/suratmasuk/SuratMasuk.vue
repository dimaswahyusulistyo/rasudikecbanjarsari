<template>
  <h5>SURAT MASUK</h5>
  <CCard class="mb-4">
    <CCardHeader
      style="background-color: #003083; color: white; font-weight: bold; font-size: 1.2rem"
    >
      <div class="d-flex justify-content-between align-items-center">
        <CInputGroup>
          <CInputGroupPrepend>
            <CDropdown>
              <CDropdownToggle color="dark">
                <CIcon icon="cil-filter" />
              </CDropdownToggle>
              <CDropdownMenu>
                <CDropdownItem @click="changeFilter('terbaru')">Terbaru</CDropdownItem>
                <CDropdownItem @click="changeFilter('terlama')">Terlama</CDropdownItem>
                <CDropdownItem @click="changeFilter('harian')">Hari Ini</CDropdownItem>
                <CDropdownItem @click="changeFilter('mingguan')">Minggu Ini</CDropdownItem>
                <CDropdownItem @click="changeFilter('bulanan')">Bulan Ini</CDropdownItem>
                <CDropdownItem @click="changeFilter('tahunan')">Tahun Ini</CDropdownItem>
              </CDropdownMenu>
            </CDropdown>
          </CInputGroupPrepend>
          <span class="me-2"></span>
          <CCol xs="xs">
            <CFormInput
              v-model="searchQuery"
              placeholder="Search"
              aria-label="Search"
              CIcon="CIcon"
              icon="cilSearch"
              @keydown.enter="search"
            />
          </CCol>
          <CInputGroupPrepend>
            <span class="me-2"></span>
            <CInputGroupPrepend v-if="currentUser && currentUser.role === 'superadmin'">
              <CButton color="success" @click="$router.push('/inputsm')" class="text-white">
                <CIcon icon="cil-plus" /> TAMBAH
              </CButton>
            </CInputGroupPrepend>
          </CInputGroupPrepend>
        </CInputGroup>
      </div>
    </CCardHeader>

    <CCardBody>
      <CTable align="middle" class="mb-0 border" hover="hover" responsive="responsive">
        <CTableHead class="text-nowrap">
          <CTableRow>
            <CTableHeaderCell class="bg-body-secondary text-center"></CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">No.</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Tanggal Diterima</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Nomor Surat</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Tanggal Surat</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Pengirim</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Perihal</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Disposisi</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
          </CTableRow>
        </CTableHead>
        <CTableBody>
          <CTableRow v-for="(surat, index) in suratMasuk" :key="index">
            <CTableDataCell class="text-center"></CTableDataCell>
            <CTableDataCell>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</CTableDataCell>
            <CTableDataCell>{{ formatDate(surat.created_at) }}</CTableDataCell>
            <CTableDataCell>{{ surat.no_surat ? surat.no_surat : '-' }}</CTableDataCell>
            <CTableDataCell>{{ formatDate(surat.tanggal_diterima) }}</CTableDataCell>
            <CTableDataCell>{{ surat.pengirim }}</CTableDataCell>
            <CTableDataCell>{{ getPerihalName(surat.perihal) }}</CTableDataCell>
            <CTableDataCell>
              <ol style="text-align: left" v-if="surat.disposisi && surat.disposisi.length > 0">
                <li v-for="dispo in surat.disposisi" :key="dispo.id_disposisi">{{ dispo.penerimadispo }}</li>
              </ol>
              <span style="margin-left: 25px;" v-else>Belum Ada Disposisi</span>
            </CTableDataCell>
            <CTableDataCell>
              <CButton color="warning" @click="$router.push(`/detailsm/${surat.id_surat_masuk}`)">
                <CIcon icon="cil-info" />
              </CButton>
            </CTableDataCell>
          </CTableRow>
        </CTableBody>
      </CTable>
    </CCardBody>

    <CPagination align="center">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li class="page-item" :class="{ disabled: currentPage === 1 }">
            <button
              class="page-link"
              @click="changePage(currentPage - 1)"
              :disabled="currentPage === 1"
            >
              Previous
            </button>
          </li>
          <li
            class="page-item"
            v-for="page in totalPages"
            :key="page"
            :class="{ active: page === currentPage }"
          >
            <button class="page-link" @click="changePage(page)">
              {{ page }}
            </button>
          </li>
          <li class="page-item" :class="{ disabled: currentPage === totalPages }">
            <button
              class="page-link"
              @click="changePage(currentPage + 1)"
              :disabled="currentPage === totalPages"
            >
              Next
            </button>
          </li>
        </ul>
      </nav>
    </CPagination>
  </CCard>
</template>

<script>
import axios from 'axios'
import { ref, onMounted } from 'vue'

export default {
  setup() {
    let suratMasuk = ref([])
    let currentPage = ref(1)
    let totalPages = ref(1)
    const itemsPerPage = 10
    let kategoris = ref([])
    let searchQuery = ref('')
    let filter = ref('terbaru')
    let currentUser = ref(null)

    const fetchCurrentUser = () => {
      axios
        .get('/api/user', {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })
        .then((response) => {
          currentUser.value = response.data.user
        })
        .catch((error) => {
          console.error('Error fetching current user:', error)
        })
    }

    const fetchDetailSurat = async (id_surat_masuk) => {
      try {
        const response = await axios.get(`/api/suratmasuk/${id_surat_masuk}`)
        return response.data.disposisi
      } catch (error) {
        console.error('Error fetching detail surat:', error)
        return null
      }
    }

    const fetchData = async () => {
      let url = `/api/suratmasuk?page=${currentPage.value}&input=${filter.value}`
      try {
        const response = await axios.get(url)
        if (response && response.data) {
          const suratData = response.data.data
          for (let surat of suratData) {
            surat.disposisi = await fetchDetailSurat(surat.id_surat_masuk) 
          }
          suratMasuk.value = suratData
          totalPages.value = response.data.meta.last_page
        } else {
          console.error('Invalid response structure:', response)
        }
      } catch (error) {
        console.error(
          'Error fetching data:',
          error.response ? error.response.data : error.message,
        )
      }
    }

    const changeFilter = (selectedFilter) => {
      filter.value = selectedFilter
      fetchData()
    }

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

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page
        fetchData()
      }
    }

    const getPerihalName = (perihal) => {
      if (perihal.startsWith('Lainnya: ')) {
        return perihal.replace('Lainnya: ', '')
      }
      const kategori = kategoris.value.find((kategori) => kategori.perihal === perihal)
      return kategori ? kategori.perihal : perihal
    }

    const search = () => {
      axios
        .get(`/api/suratmasuk/search`, {
          params: { keywords: searchQuery.value },
        })
        .then((response) => {
          if (response && response.data) {
            suratMasuk.value = response.data
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
    }

    const formatDate = (dateString) => {
      const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
      const date = new Date(dateString);
      return date.toLocaleDateString('id-ID', options);
    }

    onMounted(() => {
      fetchData()
      fetchPerihal()
      fetchCurrentUser()
    })

    return {
      suratMasuk,
      currentPage,
      totalPages,
      itemsPerPage,
      changePage,
      getPerihalName,
      searchQuery,
      search,
      filter,
      currentUser,
      changeFilter,
      formatDate
    }
  },
}
</script>
