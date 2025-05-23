<template>
    <h5>DATA JABATAN</h5>
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
                            <CDropdownItem @click="changeFilter('az')">A - Z</CDropdownItem>
                            <CDropdownItem @click="changeFilter('za')">Z - A</CDropdownItem>
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
                        <CButton color="success" @click="$router.push('/inputjabatan')" class="text-white">
                            <CIcon icon="cil-plus"/> TAMBAH
                        </CButton>
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
                        <CTableHeaderCell class="bg-body-secondary">Jabatan</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
                    </CTableRow>
                </CTableHead>
                <CTableBody>
                    <CTableRow v-for="(jabatan, index) in jabatan" :key="index">
                        <CTableDataCell class="text-center"></CTableDataCell>
                        <CTableDataCell>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</CTableDataCell> 
                        <CTableDataCell>{{ jabatan.nama_jabatan }}</CTableDataCell>
                        <CTableDataCell>
                            <CButton color="warning" @click="editJabatan(jabatan.id_jabatan)" class="me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </CButton>
                            <button type="button" class="btn btn-danger" @click="deleteJabatan(jabatan.id_jabatan)">
                                <i class="fas fa-trash"></i>
                            </button>
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
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export default {
  setup() {

    const router = useRouter();
    const route = useRoute();

    const toast = useToast();

    let jabatan = ref([]);
    let currentPage = ref(1);
    let totalPages = ref(1);
    const itemsPerPage = 10;
    let searchQuery = ref('');
    let filter = ref('az'); 

    const fetchData = () => {
      axios
        .get(`/api/jabatan?page=${currentPage.value}&input=${filter.value}`)
        .then((response) => {
          if (response && response.data) {
            jabatan.value = response.data.data;
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

    const changePage = (page) => {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
        fetchData();
      }
    };

    const search = () => {
            axios
                .get(`/api/jabatan/search`, {
                params: { keywords: searchQuery.value }
                })
                .then((response) => {
                if (response && response.data) {
                    jabatan.value = response.data;
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

    onMounted(() => {
      fetchData();
    });

    function deleteJabatan(id_jabatan) {
        if (confirm("Apakah Anda yakin ingin menghapus Jabatan ini?")) {
            axios
                .delete(`/api/jabatan/${id_jabatan}`)
                .then(response => {
                    toast.success('Jabatan berhasil dihapus', { duration: 5000 });
                    router.go('/datajabatan'); 
                })
                .catch(error => {
                    console.error('Error deleting data:', error);
                    toast.error('Terjadi kesalahan saat menghapus jabatan', { duration: 5000 });
                });
        }
    }

    function editJabatan(id_jabatan) {
        router.push(`/editjabatan/${id_jabatan}`);
    }

    return {
      jabatan,
      currentPage,
      totalPages,
      itemsPerPage,
      changePage,
      deleteJabatan,
      editJabatan,
      searchQuery,
      search,
      filter,
      changeFilter
    };
  },
};
</script>
