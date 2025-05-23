<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader style="background-color: #003083; color: white;">
          <strong>INPUT SURAT KELUAR</strong>
        </CCardHeader>
        <CCardBody>
          <CForm @submit.prevent="submitForm">
            <CRow class="mb-3">
              <CFormLabel for="tertuju_kepada" class="col-sm-2 col-form-label">
                Tertuju Kepada
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="tertuju_kepada" v-model="formData.tertuju_kepada" type="text" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="no_surat" class="col-sm-2 col-form-label">
                Nomor Surat
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="no_surat" v-model="formData.no_surat" type="text" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tanggal_keluar" class="col-sm-2 col-form-label">
                Tanggal Surat
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="tanggal_keluar" v-model="formData.tanggal_keluar" type="date" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tempat_agenda" class="col-sm-2 col-form-label">
                Tempat Agenda
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="tempat_agenda" v-model="formData.tempat_agenda" type="text"/>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tanggal_agenda" class="col-sm-2 col-form-label">
                Waktu Agenda
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="tanggal_agenda" v-model="formData.tanggal_agenda" type="datetime-local" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="perihal" class="col-sm-2 col-form-label"> Kategori Perihal </CFormLabel>
              <div class="col-sm-10">
                <CFormSelect id="perihal" v-model="formData.perihal" @change="handleKategoriChange" required>
                  <option value="">Pilih Kategori Perihal</option>
                  <option v-for="kategori in kategoriPerihalList" :key="kategori.perihal" :value="kategori.perihal">
                    {{ kategori.perihal }}
                  </option>
                  <option value="Lainnya">Lainnya</option>
                </CFormSelect>
              </div>
            </CRow>
            <CRow class="mb-3" v-if="formData.perihal === 'Lainnya'">
              <CFormLabel for="perihal_lainnya" class="col-sm-2 col-form-label"> Perihal Lainnya </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="perihal_lainnya" v-model="formData.perihal_lainnya" type="text" required />
              </div>
            </CRow>
            <div class="mb-3">
              <CFormLabel for="isi_ringkas"> Isi Surat Ringkas</CFormLabel>
              <CFormTextarea id="isi_ringkas" v-model="formData.isi_ringkas" rows="3"></CFormTextarea>
            </div>
            <CRow class="mb-3">
              <CFormLabel for="file_surat" class="col-sm-2 col-form-label">
                 File Surat
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="file_surat" type="file" @change="handleFileUpload"/>
              </div>
            </CRow>
            <CRow class="mb-3">
              <div class="col-sm-10 offset-sm-2">
                <CButton color="danger" @click="$router.push('/suratkeluar')">Cancel</CButton>
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
        no_surat: '',
        tanggal_keluar: '',
        tertuju_kepada: '',
        tempat_agenda:'',
        tanggal_agenda:'',
        perihal:'',
        isi_ringkas: '',
        file_surat: null,
        perihal_lainnya: '' 
      },
      kategoriPerihalList: [] 
    };
  },
  mounted() {
    this.loadKategoriPerihal(); 
  },
  methods: {
    async loadKategoriPerihal() {
      try {
        const response = await axios.get('/api/kategoriperihal');
        this.kategoriPerihalList = response.data; 
      } catch (error) {
        console.error('Error loading kategori perihal:', error);
        alert("Gagal memuat data kategori perihal. Silakan coba lagi nanti.");
      }
    },
    async submitForm() {
      const toast = useToast();

      if (!this.formData.file_surat) {
        toast.error('Masukkan File Surat', { duration: 5000 });
        return;
      }

      const formData = new FormData();
      if (this.formData.no_surat) {
        formData.append('no_surat', this.formData.no_surat);
      }
      formData.append('tanggal_keluar', this.formData.tanggal_keluar);
      formData.append('tertuju_kepada', this.formData.tertuju_kepada);
      formData.append('tempat_agenda', this.formData.tempat_agenda);
      formData.append('tanggal_agenda', this.formData.tanggal_agenda);
      formData.append('isi_ringkas', this.formData.isi_ringkas);
      formData.append('file_surat', this.formData.file_surat);
      if (this.formData.perihal === 'Lainnya') {
        formData.append('perihal', `Lainnya: ${this.formData.perihal_lainnya}`);
      } else {
        formData.append('perihal', this.formData.perihal);
      }
      try {
        const response = await axios.post('/api/suratkeluar', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        console.log("Surat keluar berhasil ditambahkan!");
        toast.success('Surat Keluar berhasil ditambahkan', { duration: 5000});
        this.$router.push("/suratkeluar");
      } catch (error) {
        if (error.response) {
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
          console.log("Gagal menambahkan surat keluar. Silakan cek inputan Anda dan coba lagi");
          toast.error('Gagal menambahkan surat keluar. Silakan cek inputan Anda dan coba lagi', {duration: 5000});
        } else if (error.request) {
          console.log(error.request);
          console.log("Terjadi kesalahan pada server. Silakan coba lagi nanti");
          toast.error('Terjadi kesalahan pada server. Silakan coba lagi nanti', {duration: 5000});
        } else {
          console.log('Error', error.message);
          console.log("Terjadi kesalahan. Silakan coba lagi nanti");
          toast.error('Terjadi kesalahan. Silakan coba lagi nanti', {duration: 5000});
        }
      }
    },
    handleFileUpload(event) {
      this.formData.file_surat = event.target.files[0];
    },
    handleKategoriChange() {
      if (this.formData.id_kp !== 'Lainnya') {
        this.formData.perihal_lainnya = ''; 
      }
    }
  }
};
</script>
