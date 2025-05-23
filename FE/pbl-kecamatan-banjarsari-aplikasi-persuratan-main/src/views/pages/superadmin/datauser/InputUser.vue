<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader style="background-color: #003083; color: white">
          <strong>INPUT DATA USER</strong>
        </CCardHeader>
        <CCardBody>
          <CForm @submit.prevent="submitForm">
            <CRow class="mb-3">
              <CFormLabel for="username" class="col-sm-2 col-form-label"> Username </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="username" v-model="formData.username" type="text" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="id_pegawai" class="col-sm-2 col-form-label">
                Nama Pegawai
              </CFormLabel>
              <div class="col-sm-10">
                <CFormSelect id="id_pegawai" v-model="formData.id_pegawai">
                  <option value="">Pilih Pegawai</option>
                  <option
                    v-for="pegawai in listPegawai"
                    :key="pegawai.id_pegawai"
                    :value="pegawai.id_pegawai"
                  >
                    {{ pegawai.nama_pegawai }}
                  </option>
                </CFormSelect>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="password" class="col-sm-2 col-form-label"> Password </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="password" v-model="formData.password" type="password" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="confirmPassword" class="col-sm-2 col-form-label">
                Konfirmasi Password
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput
                  id="confirmPassword"
                  v-model="formData.confirmPassword"
                  type="password"
                />
              </div>
            </CRow>
            <CRow class="mb-3">
              <div class="col-sm-10 offset-sm-2">
                <CButton color="danger" @click="$router.push('/datauser')">Cancel</CButton>
                <CButton color="primary" class="ms-2" type="submit">Submit</CButton>
              </div>
            </CRow>
          </CForm>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';


export default {
  data() {
    return {
      formData: {
        username: '',
        id_pegawai: '',
        password: '',
        confirmPassword: '',
      },
      listPegawai: [],
    }
  },
  mounted() {
    this.loadListPegawai()
  },
  methods: {
    async loadListPegawai() {
      try {
        const response = await axios.get('/api/pegawai?paginate=false')
        this.listPegawai = response.data
      } catch (error) {
        console.error('Error loading list pegawai:', error)
        alert('Gagal memuat data pegawai. Silakan coba lagi nanti.')
      }
    },
    async submitForm() {
      const toast = useToast();
      if (this.formData.password !== this.formData.confirmPassword) {
        toast.error('Password dan Konfirmasi Password tidak cocok', { duration: 5000 });
        return
      }

      try {
        const response = await axios.post('/api/register', {
          username: this.formData.username,
          id_pegawai: this.formData.id_pegawai,
          password: this.formData.password,
        })
        toast.success('User berhasil ditambahkan', { duration: 5000 });
        this.$router.push('/datauser')
      } catch (error) {
        if (error.response) {
          console.log(error.response.data)
          console.log(error.response.status)
          console.log(error.response.headers)
          toast.error('Gagal menambahkan user. Silakan cek inputan Anda dan coba lagi', { duration: 5000 });
        } else if (error.request) {
          console.log(error.request)
          toast.error('Terjadi kesalahan pada server. Silakan coba lagi nanti', { duration: 5000 });
        } else {
          console.log('Error', error.message)
          toast.error('Terjadi kesalahan. Silakan coba lagi nanti', { duration: 5000 });
        }
      }
    },
  },
}
</script>
