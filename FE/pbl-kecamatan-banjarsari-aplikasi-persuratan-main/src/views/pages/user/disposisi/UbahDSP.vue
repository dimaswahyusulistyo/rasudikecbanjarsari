<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
          <strong>EDIT DISPOSISI</strong>
        </CCardHeader>
        <CCardBody>
          <CForm>
            <CRow class="mb-3 align-items-center">
              <CFormLabel for="penerimaDisposisi" class="col-sm-2 col-form-label">
                Penerima Disposisi
              </CFormLabel>
              <div class="col-sm-10">
                <CInputGroup>
                  <CFormSelect id="penerimaDisposisi" v-model="penerimaDisposisi">
                    <option value="" disabled selected>Pilih Penerima Disposisi</option>
                    <option
                        v-for="pegawai in pegawaiList"
                        :key="pegawai.id_pegawai"
                        :value="pegawai.nama_pegawai"
                      >
                        {{ `${pegawai.jabatan.nama_jabatan} - ${pegawai.nama_pegawai}` }}
                      </option>
                  </CFormSelect>
                </CInputGroup>
              </div>
            </CRow>
            <CRow class="mb-3 align-items-center">
              <CFormLabel for="pesan" class="col-sm-2 col-form-label"> Pesan </CFormLabel>
              <div class="col-sm-10">
                <CInputGroup>
                  <CFormInput v-model="pesan" id="pesan" placeholder="Masukkan Pesan" />
                </CInputGroup>
              </div>
            </CRow>

            <CRow class="mb-3">
              <div class="col-sm-10 offset-sm-2">
                <CButton color="danger" @click="cancel">Cancel</CButton>
                <CButton color="primary" class="ms-2" @click="submit">Submit</CButton>
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

export default {
  props: {
    id: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      penerimaDisposisi: '',
      pegawaiList: [],
      pesan: '', 
      idSuratMasuk: '', 
    }
  },
  created() {
    this.fetchPegawaiList()
    this.fetchDisposisiData()
  },
  methods: {
    fetchPegawaiList() {
      axios
        .get('/api/disposisipegawai', {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })
        .then((response) => {
          this.pegawaiList = response.data.data
        })
        .catch((error) => {
          console.error('Error fetching pegawai list:', error)
        })
    },
    fetchDisposisiData() {
      axios
        .get(`/api/disposisi/${this.id}`, {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })
        .then((response) => {
          const disposisiData = response.data
          this.penerimaDisposisi = disposisiData.penerimadispo
          this.idSuratMasuk = disposisiData.id_surat_masuk 
        })
        .catch((error) => {
          console.error('Error fetching disposisi data:', error)
        })
    },
    cancel() {
      this.$router.push(`/detailsm/${this.idSuratMasuk}`)
    },
    async submit() {
      try {
        const payloadDisposisi = {
          id_surat_masuk: this.idSuratMasuk,
          penerimadispo: this.penerimaDisposisi,
          status_pegawai: 'Aktif',
        }

        console.log('Payload Disposisi:', payloadDisposisi)

        const responseDisposisi = await axios.put(
          `/api/disposisi/${this.id}`,
          payloadDisposisi,
          {
            headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
          },
        )

        console.log('Response Disposisi:', responseDisposisi.data)

        const payloadPesan = {
          id_surat_masuk: this.idSuratMasuk,
          perintah_dispo: this.pesan,
        }

        console.log('Payload Pesan:', payloadPesan)

        const responsePesan = await axios.post('/api/pesan', payloadPesan, {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })

        console.log('Response Pesan:', responsePesan.data)

        this.$router.push(`/detailsm/${this.idSuratMasuk}`)
      } catch (error) {
        console.error('Error submitting disposisi:', error)
        if (error.response) {
          console.error('Error Response:', error.response.data)
        }
      }
    },
  },
}
</script>
