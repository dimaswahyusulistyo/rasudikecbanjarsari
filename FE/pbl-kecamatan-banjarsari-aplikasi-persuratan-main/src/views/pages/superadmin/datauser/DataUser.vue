<template>
    <h5>DATA USER</h5>
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
                            placeholder="Search"
                            aria-label="Search"
                            v-model="searchQuery"
                            @input="fetchData"
                        />
                    </CCol>
                    <span class="me-2"></span>
                    <CInputGroupPrepend>
                        <CButton color="success" @click="$router.push('/inputuser')" class="text-white">
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
                        <CTableHeaderCell class="bg-body-secondary text-center">No.</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Username</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Nama Pegawai</CTableHeaderCell>
                        <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
                    </CTableRow>
                </CTableHead>
                <CTableBody>
                    <CTableRow v-for="(user, index) in filteredUsers" :key="user.id">
                        <CTableDataCell class="text-center">{{ (currentPage - 1) * itemsPerPage + index + 1 }}</CTableDataCell>
                        <CTableDataCell>{{ user.username }}</CTableDataCell>
                        <CTableDataCell>{{ getPegawaiName(user.id_pegawai) }}</CTableDataCell>
                        <CTableDataCell>
                            <CButton color="warning" @click="editUser(user.id)" class="me-1">
                                <i class="fas fa-pencil-alt"></i>
                            </CButton>
                            <span class="me-2"></span>
                            <CButton color="danger" @click="deleteUser(user.id)">
                                <i class="fas fa-trash"></i>
                            </CButton>
                        </CTableDataCell>
                    </CTableRow>
                </CTableBody>
            </CTable>
        </CCardBody>

        <CPagination align="center">
            <CPaginationItem
                :disabled="currentPage === 1"
                @click="changePage(currentPage - 1)"
            >
                Previous
            </CPaginationItem>
            <CPaginationItem
                v-for="page in totalPages"
                :key="page"
                :active="page === currentPage"
                @click="changePage(page)"
            >
                {{ page }}
            </CPaginationItem>
            <CPaginationItem
                :disabled="currentPage === totalPages"
                @click="changePage(currentPage + 1)"
            >
                Next
            </CPaginationItem>
        </CPagination>
    </CCard>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';


export default {
    setup() {

        const toast = useToast();
        const router = useRouter();
        const users = ref([]);
        const pegawais = ref([]);
        const currentPage = ref(1);
        const totalPages = ref(1);
        const itemsPerPage = 10;
        const searchQuery = ref('');
        const filter = ref('az');

        const fetchData = () => {
            const params = { page: currentPage.value, search: searchQuery.value, input: filter.value };
            axios
                .get('/api/users', { params })
                .then((response) => {
                    users.value = response.data.data;
                    totalPages.value = response.data.meta.last_page;
                })
                .catch((error) => {
                    console.error("Error fetching data:", error.response ? error.response.data : error.message);
                });
        };


        const fetchPegawais = () => {
            axios
                .get('/api/pegawai?paginate=false')
                .then((response) => {
                    pegawais.value = response.data;
                })
                .catch((error) => {
                    console.error("Error fetching data:", error.response ? error.response.data : error.message);
                });
        };

        const getPegawaiName = (id_pegawai) => {
            const pegawai = pegawais.value.find((p) => p.id_pegawai === id_pegawai);
            return pegawai ? pegawai.nama_pegawai : '';
        };

        const changePage = (page) => {
            if (page >= 1 && page <= totalPages.value) {
                currentPage.value = page;
                fetchData();
            }
        };

        onMounted(() => {
            fetchData();
            fetchPegawais();
        });

        const filteredUsers = computed(() => {
            if (searchQuery.value) {
                return users.value.filter(u =>
                    u.username.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
                    getPegawaiName(u.id_pegawai).toLowerCase().includes(searchQuery.value.toLowerCase())
                );
            }
            return users.value;
        });

        const deleteUser = (id) => {
            if (confirm("Apakah Anda yakin ingin menghapus User ini?")) {
                axios
                    .delete(`/api/users/${id}`)
                    .then(() => {
                        toast.success('User berhasil dihapus', { duration: 5000 });
                        fetchData();
                    })
                    .catch(error => {
                        console.error('Error deleting data:', error);
                        toast.error('Terjadi kesalahan saat menghapus user', { duration: 5000 });
                    });
            }
        };

        const editUser = (id) => {
            router.push(`/edituser/${id}`);
        };

        const changeFilter = (selectedFilter) => {
            filter.value = selectedFilter;
            fetchData();
        };

        return {
            users,
            pegawais,
            currentPage,
            totalPages,
            itemsPerPage,
            changePage,
            deleteUser,
            editUser,
            getPegawaiName,
            searchQuery,
            filteredUsers,
            filter,
            changeFilter
        };
    },
};
</script>

<style scoped>
.pagination {
    display: flex;
    justify-content: center;
}
</style>
