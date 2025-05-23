<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader style="background-color: #003083; color: white">
          <strong>INPUT DATA JABATAN</strong>
        </CCardHeader>
        <CCardBody>
          <CForm @submit.prevent="submitJabatan">
            <CRow class="mb-3">
              <CFormLabel for="jabatan" class="col-sm-2 col-form-label"> Jabatan </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="jabatan" v-model="inputJabatan.nama_jabatan" type="text" />
              </div>
            </CRow>

            <CRow class="mb-3">
              <CFormLabel for="tier" class="col-sm-2 col-form-label"> Tier </CFormLabel>
              <div class="col-sm-10">
                <CFormSelect id="tier" v-model="inputJabatan.id_tier">
                  <option value="">Pilih Tier</option>
                  <option v-for="tier in tiers" :value="tier.id_tier" :key="tier.id_tier">
                    {{ tier.tier_name }}
                  </option>
                </CFormSelect>
              </div>
            </CRow>
          </CForm>

          <CRow class="mb-3">
            <div class="col-sm-10 offset-sm-2">
              <CButton color="danger" @click="$router.push('/datajabatan')">Cancel</CButton>
              <CButton color="primary" class="ms-2" @click="submitJabatan">Submit</CButton>
            </div>
          </CRow>
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
      inputJabatan: {
        nama_jabatan: '',
        id_tier: null,
      },
      tiers: [],
    }
  },
  created() {
    this.fetchTiers()
  },
  methods: {
    async fetchTiers() {
      try {
        const response = await axios.get('/api/tiers')
        this.tiers = response.data.data
      } catch (error) {
        console.error('Error fetching tiers:', error)
      }
    },
    async submitJabatan() {
      const toast = useToast()
      const formData = new FormData()
      formData.append('nama_jabatan', this.inputJabatan.nama_jabatan)
      formData.append('id_tier', this.inputJabatan.id_tier)

      try {
        const response = await axios.post('/api/jabatan', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        console.log('Jabatan Berhasil Ditambahkan!')
        toast.success('Jabatan Berhasil Ditambahkan', { duration: 5000 });
        this.$router.push('/datajabatan')
      } catch (error) {
        if (error.response) {
          console.log(error.response.data);
          console.log(error.response.status);
          console.log(error.response.headers);
          toast.error('Gagal menambahkan data jabatan. Silakan cek inputan Anda dan coba lagi', { duration: 5000 });
        } else if (error.request) {
          console.log(error.request);
          toast.error('Terjadi kesalahan pada server. Silakan coba lagi nanti', { duration: 5000 });
        } else {
          console.log('Error', error.message);
          toast.error('Terjadi kesalahan. Silakan coba lagi nanti', { duration: 5000 });
        }
      }
    },
  },
}
</script>
