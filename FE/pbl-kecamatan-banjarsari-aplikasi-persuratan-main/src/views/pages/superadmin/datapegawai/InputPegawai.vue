<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader style="background-color: #003083; color: white;">
          <strong>INPUT DATA PEGAWAI</strong>
        </CCardHeader>
        <CCardBody>

          <CForm @submit.prevent="submitForm">
            <CRow class="mb-3">
              <CFormLabel for="nama_pegawai" class="col-sm-2 col-form-label">
                Nama Pegawai
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="nama_pegawai" v-model="formData.nama_pegawai" type="text" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="email" class="col-sm-2 col-form-label">
                Email
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="email" v-model="formData.email" type="email" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="nip" class="col-sm-2 col-form-label">
                NIP/NIK
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="nip" v-model="formData.nip" type="text" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="id_jabatan" class="col-sm-2 col-form-label">
                Jabatan
              </CFormLabel>
              <div class="col-sm-10">
                <CFormSelect id="id_jabatan" v-model="formData.id_jabatan">
                  <option value="">Pilih Jabatan</option>
                  <option v-for="jabatan in listJabatan" :key="jabatan.id_jabatan" :value="jabatan.id_jabatan">{{ jabatan.nama_jabatan }}</option>
                </CFormSelect>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="fileFoto" class="col-sm-2 col-form-label">
                Foto
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="file_foto" type="file" @change="handleFileUpload"/>
              </div>
            </CRow>
            <CRow class="mb-3">
              <div class="col-sm-10 offset-sm-2">
                <CButton color="danger" @click="$router.push('/datapegawai')">Cancel</CButton>
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
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export default {
  data() {
    return {
      formData: {
        nama_pegawai: '',
        email: '',
        nip: '',
        id_jabatan: '',
        file_foto: null
      },
      listJabatan: [] 
    };
  },
  mounted() {
    this.loadListJabatan(); 
  },
  methods: {
    async loadListJabatan() {
      try {
        const response = await axios.get('/api/jabatan?paginate=false');
        this.listJabatan = response.data; 
      } catch (error) {
        console.error('Error loading list jabatan:', error);
      }
    },
    async submitForm() {
      const toast = useToast();
      const formData = new FormData();
      formData.append('nama_pegawai', this.formData.nama_pegawai);
      formData.append('email', this.formData.email);
      formData.append('nip', this.formData.nip);
      formData.append('id_jabatan', this.formData.id_jabatan);
      formData.append('file_foto', this.formData.file_foto);

      try {
        const response = await axios.post('/api/pegawai', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        console.log("Data Pegawai berhasil ditambahkan!");
        toast.success('Data Pegawai berhasil ditambahkan', { duration: 5000 });
        this.$router.push("/datapegawai");
      } catch (error) {
        if (error.response) {
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
          toast.error('Gagal menambahkan data pegawai. Silakan cek inputan Anda dan coba lagi', { duration: 5000 });
        } else if (error.request) {
          console.log(error.request);
          toast.error('Terjadi kesalahan pada server. Silakan coba lagi nanti', { duration: 5000 });
        } else {
          console.log('Error', error.message);
          toast.error('Terjadi kesalahan. Silakan coba lagi nanti', { duration: 5000 });
        }
      }
    },
    handleFileUpload(event) {
      this.formData.file_foto = event.target.files[0];
    }
  }
};
</script>
