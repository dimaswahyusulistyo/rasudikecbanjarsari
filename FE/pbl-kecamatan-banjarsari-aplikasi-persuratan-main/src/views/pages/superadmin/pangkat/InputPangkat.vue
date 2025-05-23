<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader style="background-color: #003083; color: white">
          <strong>INPUT DATA PANGKAT</strong>
        </CCardHeader>
        <CCardBody>
          <CForm @submit.prevent="submitJabatan">
            <CRow class="mb-3">
              <CFormLabel for="jabatan" class="col-sm-2 col-form-label"> Jabatan </CFormLabel>
              <div class="col-sm-10">
                <CFormSelect v-model="inputJabatan.id_jabatan" id="jabatan">
                  <option value="">Pilih Jabatan</option>
                  <option
                    v-for="jabatan in jabatans"
                    :key="jabatan.id_jabatan"
                    :value="jabatan.id_jabatan"
                  >
                    {{ jabatan.nama_jabatan }}
                  </option>
                </CFormSelect>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tier" class="col-sm-2 col-form-label"> Tier </CFormLabel>
              <div class="col-sm-10">
                <CFormSelect v-model="inputJabatan.id_tier" id="tier">
                  <option value="">Pilih Tier</option>
                  <option v-for="tier in tiers" :key="tier.id_tier" :value="tier.id_tier">
                    {{ tier.tier_name }}
                  </option>
                </CFormSelect>
              </div>
            </CRow>
            <input type="hidden" v-model="inputJabatan.nama_jabatan" />
            <CRow class="mb-3">
              <div class="col-sm-10 offset-sm-2">
                <CButton color="danger" @click="$router.push('/datapangkat')">Cancel</CButton>
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
import { ref, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'

export default {
  setup() {
    const inputJabatan = ref({
      id_jabatan: '',
      id_tier: '',
    })
    const jabatans = ref([])
    const tiers = ref([])
    const router = useRouter()

    const fetchJabatansAndTiers = async () => {
      try {
        const jabatansResponse = await axios.get('/api/jabatannotier')
        jabatans.value = jabatansResponse.data.data

        const tiersResponse = await axios.get('/api/tiers')
        tiers.value = tiersResponse.data.data
      } catch (error) {
        console.error('Error fetching data:', error)
      }
    }

    const submitJabatan = async () => {
  try {
    const idJabatan = inputJabatan.value.id_jabatan;
    const idTier = inputJabatan.value.id_tier;
    const namaJabatan = inputJabatan.value.id_jabatan.nama_jabatan;
    const response = await axios.put(
      `/api/jabatan/${idJabatan}?id_tier=${idTier}&nama_jabatan=${encodeURIComponent(namaJabatan)}` 
    );
    console.log('Pangkat Berhasil Diupdate!');
    alert('Data Pangkat Berhasil Diupdate!');
    router.push('/datapangkat');
  } catch (error) {
    if (error.response) {
      console.log(error.response.data);
      console.log(error.response.status);
      console.log(error.response.headers);
      alert('Gagal mengupdate pangkat. Silakan cek inputan Anda dan coba lagi.');
    } else if (error.request) {
      console.log(error.request);
      alert('Terjadi kesalahan pada server. Silakan coba lagi nanti.');
    } else {
      console.log('Error', error.message);
      alert('Terjadi kesalahan. Silakan coba lagi nanti.');
    }
  }
};


    onMounted(() => {
      fetchJabatansAndTiers()
    })

    return {
      inputJabatan,
      jabatans,
      tiers,
      submitJabatan,
      router,
    }
  },
}
</script>
