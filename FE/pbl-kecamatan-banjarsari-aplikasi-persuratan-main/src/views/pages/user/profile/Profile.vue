<template>
  <div>
    <div class="container d-flex justify-content-center align-items-center">
      <div class="card border mb-4 card-auto-width card-custom-width position-relative">
        <div class="position-absolute top-0 start-0 m-3">
          <CButton color="secondary" @click="goToDashboard">
            <i class="fas fa-arrow-left"></i>
          </CButton>
        </div>

        <CCardBody>
          <div class="row align-items-center">
            <div class="text-center mb-4">
              <h5 class="mb-0">PROFILE</h5>
            </div>
            <div class="col-12 col-sm-4 text-center">
              <img :src="profileImageUrl" alt="Profile Picture" class="rounded-circle" width="150" />
            </div>

            <div class="col-12 col-sm-8 mt-4">
              <table class="table table-profile">
                <tbody>
                  <tr>
                    <td class="font-weight-bold">Nama</td>
                    <td>:</td>
                    <td>{{ user?.pegawai?.nama_pegawai }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Email</td>
                    <td>:</td>
                    <td>{{ user?.pegawai?.email }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">NIP/NIK</td>
                    <td>:</td>
                    <td>{{ user?.pegawai?.nip }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Jabatan</td>
                    <td>:</td>
                    <td>{{ getJabatanName(user?.pegawai?.id_jabatan) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </CCardBody>
        <div class="card-footer d-flex justify-content-end align-items-center">
          <div>
            <CButton color="primary" @click="$router.push(`/ubahpassword/${user.id}`)">
              Ubah Password
              <i class="fas fa-key ms-2"></i>
            </CButton>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'
import router from '@/router'
import { ASSET_BASE_URL } from '@/config'

export default {
  setup() {
    const user = ref(null)
    let jabatans = ref([])

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

    const profileImageUrl = computed(() => {
      return user.value?.pegawai?.file_foto
      ? `${ASSET_BASE_URL}foto_pegawai/${user.value.pegawai.file_foto}`
        : ''
    })

    const fetchJabatan = () => {
      axios
        .get(`/api/jabatan?paginate=false`)
        .then((response) => {
          jabatans.value = response.data
        })
        .catch((error) => {
          console.error(
            'Error fetching data:',
            error.response ? error.response.data : error.message,
          )
        })
    }

    const getJabatanName = (id_jabatan) => {
      const nama_jabatan = jabatans.value.find((jabatan) => jabatan.id_jabatan === id_jabatan);
      return nama_jabatan ? nama_jabatan.nama_jabatan : '';
    };

    const goToDashboard = () => {
      const userRole = user.value?.role;
      if (userRole === 'superadmin') {
        router.push('/dashboardsa');
      } else if (userRole === 'admin') {
        router.push('/dashboard');
      } else if (userRole === 'camat') {
        router.push('/dashboardcmt');
      }
    };
      
    onMounted(() => {
      fetchData()
      fetchJabatan()
    })

    return {
      user,
      profileImageUrl,
      getJabatanName,
      goToDashboard
    }
  },
}
</script>

<style>
.container {
  height: 100vh;
}

.card-auto-width {
  width: auto;
  max-width: 90%;
}

.card-custom-width {
  width: 100%;
  max-width: 600px;
}

.position-absolute {
  position: absolute !important;
}

.top-0 {
  top: 0 !important;
}

.end-0 {
  right: 0 !important;
}

.m-3 {
  margin: 1rem !important;
}

.table-profile td {
  padding: 0.5rem;
}

.table-profile .font-weight-bold {
  width: 30%;
  text-align: left;
}

.table-profile td:nth-child(2) {
  text-align: left;
}

.mt-4 {
  margin-top: 1.5rem !important;
}

.ms-2 {
  margin-left: 0.9rem !important;
}
</style>
