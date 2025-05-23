<template>
  <h5>SURAT KELUAR</h5>
  <CCard class="mb-4">
    <CCardHeader
      style="background-color: #003083; color: white; font-weight: bold; font-size: 1.2rem;"
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
            <CButton
              color="success"
              @click="$router.push('/inputsk')"
              class="text-white"
            >
              <CIcon icon="cil-plus" /> TAMBAH
            </CButton>
          </CInputGroupPrepend>
        </CInputGroup>
      </div>
    </CCardHeader>

    <CCardBody>
      <CTable align="middle" class="mb-0 border" hover responsive>
        <CTableHead class="text-nowrap">
          <CTableRow>
            <CTableHeaderCell class="bg-body-secondary text-center"></CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">No.</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Tanggal Surat</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Nomor Surat</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Tertuju Kepada</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Perihal</CTableHeaderCell>
            <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
          </CTableRow>
        </CTableHead>
        <CTableBody>
          <CTableRow v-for="(surat, index) in suratKeluar" :key="index">
            <CTableDataCell class="text-center"></CTableDataCell>
            <CTableDataCell>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</CTableDataCell>
            <CTableDataCell>{{ formatDate(surat.tanggal_keluar) }}</CTableDataCell>
            <CTableDataCell>{{ surat.no_surat ? surat.no_surat : '-' }}</CTableDataCell>
            <CTableDataCell>{{ surat.tertuju_kepada }}</CTableDataCell>
            <CTableDataCell>{{ getPerihalName(surat.perihal) }}</CTableDataCell>
            <CTableDataCell>
              <CButton color="warning" @click="$router.push(`/detailsk/${surat.id_surat_keluar}`)">
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
import axios from "axios";
import { ref, onMounted, watch } from "vue";

export default {
  setup() {
    let suratKeluar = ref([]);
    let currentPage = ref(1);
    let totalPages = ref(1);
    const itemsPerPage = 10;
    let kategoris = ref([]);
    let searchQuery = ref('');
    let filter = ref('terbaru');

    const fetchData = () => {
      let url = `/api/suratkeluar?page=${currentPage.value}&input=${filter.value}`;
      axios
        .get(url)
        .then((response) => {
          if (response && response.data) {
            suratKeluar.value = response.data.data;
            totalPages.value = response.data.meta.last_page;
          } else {
            console.error("Invalid response structure:", response);
          }
        })
        .catch((error) => {
          console.error(
            "Error fetching data:",
            error.response ? error.response.data : error.message
          );
        });
    };

    const changeFilter = (selectedFilter) => {
      filter.value = selectedFilter;
      fetchData();
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

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchData();
      }
    };

    const getPerihalName = (perihal) => {
      if (perihal.startsWith('Lainnya: ')) {
        return perihal.replace('Lainnya: ', '');
      }
      const kategori = kategoris.value.find((kategori) => kategori.perihal === perihal);
      return kategori ? kategori.perihal : perihal;
    }

    const search = () => {
      axios
        .get(`/api/suratkeluar/search`, {
          params: { keywords: searchQuery.value }
        })
        .then((response) => {
          if (response && response.data) {
            suratKeluar.value = response.data;
          } else {
            console.error("Invalid response structure:", response);
          }
        })
        .catch((error) => {
          console.error(
            "Error fetching data:",
            error.response ? error.response.data : error.message
          );
        });
    };

    const formatDate = (dateString) => {
      const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
      const date = new Date(dateString);
      return date.toLocaleDateString('id-ID', options);
    };

    onMounted(() => {
      fetchData();
      fetchPerihal();
    });


    return {
      suratKeluar,
      currentPage,
      totalPages,
      itemsPerPage,
      changePage,
      getPerihalName,
      searchQuery,
      search,
      filter,
      changeFilter,
      formatDate
    };
  },
};
</script>
