<template>
    <h5>DATA PEGAWAI</h5>
    <CCard class="mb-4">

        <CCardHeader style="background-color: #003083; color: white; font-weight: bold; font-size: 1.2rem;">
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
                        <CFormInput v-model="searchQuery" placeholder="Search" aria-label="Search" CIcon="CIcon"
                            icon="cilSearch" @keydown.enter="search" />
                    </CCol>
                    <CInputGroupPrepend>
                        <span class="me-2"></span>
                        <CButton color="success" @click="$router.push('/inputpegawai')" class="text-white">
                            <CIcon icon="cil-plus" /> TAMBAH
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
                        <CTableHeaderCell class="bg-body-secondary">Nama</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Email</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">NIP</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Jabatan</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
                    </CTableRow>
                </CTableHead>
                <CTableBody>
                    <CTableRow v-for="(pegawai, index) in pegawai" :key="index">
                        <CTableDataCell class="text-center"></CTableDataCell>
                        <CTableDataCell>{{ (currentPage - 1) * itemsPerPage + index + 1 }}</CTableDataCell>
                        <CTableDataCell>{{ pegawai.nama_pegawai }}</CTableDataCell>
                        <CTableDataCell>{{ pegawai.email }}</CTableDataCell>
                        <CTableDataCell>{{ pegawai.nip }}</CTableDataCell>
                        <CTableDataCell>{{ getJabatanName(pegawai.id_jabatan) }}</CTableDataCell>
                        <CTableDataCell>
                            <CButton color="warning" @click="editPegawai(pegawai.id_pegawai)" class="me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </CButton>
                            <button type="button" class="btn btn-danger" @click="deletePegawai(pegawai.id_pegawai)">
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
                    <li class="page-item" v-for="page in totalPages" :key="page"
                        :class="{ active: page === currentPage }">
                        <button class="page-link" @click="changePage(page)">
                            {{ page }}
                        </button>
                    </li>
                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                        <button class="page-link" @click="changePage(currentPage + 1)"
                            :disabled="currentPage === totalPages">
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


        let pegawai = ref([]);
        let currentPage = ref(1);
        let totalPages = ref(1);
        const itemsPerPage = 10;
        let jabatans = ref([]);
        let searchQuery = ref('');
        let filter = ref('az');

        const fetchData = () => {
            axios
                .get(`/api/pegawai?page=${currentPage.value}&input=${filter.value}`)
                .then((response) => {
                    if (response && response.data) {
                        pegawai.value = response.data.data;
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

        const fetchJabatan = () => {
            axios
                .get(`/api/jabatan?paginate=false`)
                .then((response) => {
                    jabatans.value = response.data;
                })
                .catch((error) => {
                    console.error(
                        "Error fetching data:",
                        error.response ? error.response.data : error.message
                    );
                });
        };

        const getJabatanName = (id_jabatan) => {
            const nama_jabatan = jabatans.value.find((jabatan) => jabatan.id_jabatan === id_jabatan);
            return nama_jabatan ? nama_jabatan.nama_jabatan : '';
        };

        const search = () => {
            axios
                .get(`/api/pegawai/search`, {
                    params: { keywords: searchQuery.value }
                })
                .then((response) => {
                    if (response && response.data) {
                        pegawai.value = response.data;
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

        const changePage = (page) => {
            if (page >= 1 && page <= totalPages.value) {
                currentPage.value = page;
                fetchData();
            }
        };

        onMounted(() => {
            fetchData();
            fetchJabatan();
        });

        function deletePegawai(id_pegawai) {
            if (confirm("Apakah Anda yakin ingin menghapus Pegawai ini?")) {
                axios
                    .delete(`/api/pegawai/${id_pegawai}`)
                    .then(response => {
                        toast.success('Pegawai berhasil dihapus', { duration: 5000 });
                        router.go('/datapegawai');
                    })
                    .catch(error => {
                        console.error('Error deleting data:', error);
                        toast.error('Terjadi kesalahan saat menghapus pegawai', { duration: 5000 });
                    });
            }
        }

        function editPegawai(id_pegawai) {
            router.push(`/editpegawai/${id_pegawai}`);
        }

        return {
            pegawai,
            currentPage,
            totalPages,
            itemsPerPage,
            changePage,
            deletePegawai,
            editPegawai,
            getJabatanName,
            searchQuery,
            search,
            filter,
            changeFilter
        };
    },
};
</script>
