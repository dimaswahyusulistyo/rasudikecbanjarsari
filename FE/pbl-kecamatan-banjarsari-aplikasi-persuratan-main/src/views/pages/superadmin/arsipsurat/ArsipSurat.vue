<template>
    <h5>ARSIP SURAT</h5>
    <CCard class="mb-4">
        <CCardHeader
            style="background-color: #003083; color: white; font-weight: bold; font-size: 1.2rem;">
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
                </CInputGroup>
            </div>
        </CCardHeader>

        <CCardBody>
            <CTable align="middle" class="mb-0 border" hover="hover" responsive="responsive">
                <CTableHead class="text-nowrap">
                    <CTableRow>
                        <CTableHeaderCell class="bg-body-secondary text-center"></CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">No.</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Perihal</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Tipe Surat</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Nomor Surat</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Tanggal Surat</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
                    </CTableRow>
                </CTableHead>
                <CTableBody>

                    <CTableRow v-for="(arsip, index) in arsip" :key="index" >
                        <CTableDataCell class="text-center"></CTableDataCell>
                        <CTableDataCell>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</CTableDataCell>
                        <CTableDataCell>{{ getPerihalName(arsip.perihal) }}</CTableDataCell>
                        <CTableDataCell>{{ arsip.tipe_surat }}</CTableDataCell>
                        <CTableDataCell>{{ arsip.no_surat ? arsip.no_surat : '-' }}</CTableDataCell>
                        <CTableDataCell>{{ formatDate(arsip.tanggal_surat) }}</CTableDataCell>
                        <CTableDataCell>
                            <CButton color="warning" @click="goToDetailPage(arsip)">
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
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";

export default {
  setup() {
    let arsip = ref([]);
    let currentPage = ref(1);
    let totalPages = ref(1);
    const itemsPerPage = 10;
    let kategoris = ref([]);
    let searchQuery = ref('');
    let filter = ref('terbaru'); 

    const router = useRouter();

    const fetchData = () => {
      axios
        .get(`/api/arsipsurat?page=${currentPage.value}&input=${filter.value}`)
        .then((response) => {
          if (response && response.data) {
            arsip.value = response.data.data;
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
          kategoris.value = response.data;
        })
        .catch((error) => {
          console.error(
            "Error fetching data:",
            error.response ? error.response.data : error.message
          );
        });
    };

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchData();
      }
    };

    const goToDetailPage = (arsip) => {
        let detailPage = '';
            if (arsip.tipe_surat === 'Surat Masuk') {
                detailPage = `/detailarsipmasuk/${arsip.id_surat}`;
            } else if (arsip.tipe_surat === 'Surat Keluar') {
                detailPage = `/detailarsipkeluar/${arsip.id_surat}`;
            }
            if (detailPage) {
                router.push(detailPage);
            } else {
                console.error('Invalid surat type:', arsip.tipe_surat);
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
        .get(`/api/arsipsurat/search`, {
          params: { keywords: searchQuery.value }
        })
        .then((response) => {
          if (response && response.data) {
            arsip.value = response.data;
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
      arsip,
      currentPage,
      totalPages,
      itemsPerPage,
      changePage,
      getPerihalName,
      goToDetailPage,
      searchQuery,
      search,
      filter,
      changeFilter,
      formatDate
    };
  },
};
</script>
