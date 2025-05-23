<template>
  <h5>DISPOSISI SAYA</h5>
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
                <CDropdownItem @click="changeFilter('harian')">Hari Ini</CDropdownItem>
              </CDropdownMenu>
            </CDropdown>
          </CInputGroupPrepend>
          <span class="me-2"></span>
        </CInputGroup>
      </div>
    </CCardHeader>

    <CCardBody>
      <CTable align="middle" class="mb-0 border" hover="hover" responsive="responsive">
        <CTableHead class="text-nowrap">
          <CTableRow>
            <CTableHeaderCell class="bg-body-secondary text-center"></CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">No.</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Tanggal Disposisi</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Nomor Surat</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Pengirim Disposisi</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Perihal</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Penerima Disposisi</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
          </CTableRow>
        </CTableHead>
        <CTableBody>
          <CTableRow v-for="(disposisi, index) in disposisiData" :key="index">
            <CTableDataCell class="text-center"></CTableDataCell>
            <CTableDataCell>{{ index + 1 }}</CTableDataCell>
            <CTableDataCell>{{ formatDate(disposisi.created_at) }}</CTableDataCell>
            <CTableDataCell>{{ disposisi.surat.no_surat }}</CTableDataCell>
            <CTableDataCell>{{ disposisi.pendispo }}</CTableDataCell>
            <CTableDataCell>{{ disposisi.surat.perihal }}</CTableDataCell>
            <CTableDataCell>{{ disposisi.penerimadispo }}</CTableDataCell>
            <CTableDataCell>
              <CButton
                color="warning"
                @click="$router.push(`/detailsm/${disposisi.id_surat_masuk}`)"
              >
                <CIcon icon="cilInfo" />
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
            <button class="page-link" @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
              Previous
            </button>
          </li>
          <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: page === currentPage }">
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
import { ref, onMounted } from 'vue'
import axios from 'axios'
import router from '@/router'

export default {
  setup() {
    const disposisiData = ref([])
    let currentPage = ref(1);
    let totalPages = ref(1);
    const itemsPerPage = 10;
    let searchQuery = ref('');
    let filter = ref('')

    const fetchData = () => {
    const token = localStorage.getItem('token');
    const params = { page: currentPage.value, search: searchQuery.value, input: filter.value };
    axios
      .get('/api/cekdisposisi', {
        params: params,
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      .then((response) => {
        if (response && response.data && response.data.data) {
          disposisiData.value = response.data.data;
          totalPages.value = response.data.meta.last_page;
        } else {
          console.error('Invalid response structure:', response);
        }
      })
      .catch((error) => {
        console.error('Error fetching data:', error);
        if (error.response && error.response.status === 401) {
          router.push('/login');
        }
      });
  };


    const formatDate = (dateString) => {
      const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
      const date = new Date(dateString);
      return date.toLocaleDateString('id-ID', options);
      };
    
    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchData();
      }
    };

    const search = () => {
      const token = localStorage.getItem('token')
      axios
        .get(`/api/disposisi/search`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
          params: { keywords: searchQuery.value },
        })
        .then((response) => {
          if (response && response.data) {
            disposisiData.value = response.data.data;
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

    const changeFilter = (selectedFilter) => {
      filter.value = selectedFilter
      fetchData()
    };

    onMounted(() => {
      fetchData()
    })

    return {
      disposisiData,
      formatDate,
      currentPage,
      totalPages,
      itemsPerPage,
      changePage,
      searchQuery,
      search,
      filter,
      changeFilter
    }
  },
}
</script>
