<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
          <strong>TAMBAH DISPOSISI</strong>
        </CCardHeader>
        <CCardBody>
          <CForm>
            <div v-for="(disposisi, index) in disposisiList" :key="index">
              <CRow class="mb-3 align-items-center">
                <CFormLabel
                  v-if="index === 0"
                  :for="'disposisi' + index"
                  class="col-sm-2 col-form-label"
                >
                  Disposisi
                </CFormLabel>
                <div :class="index === 0 ? 'col-sm-10' : 'offset-sm-2 col-sm-10'">
                  <CInputGroup>
                    <CFormSelect :id="'disposisi' + index" v-model="disposisi.value">
                      <option value="" disabled selected>Pilih Penerima Disposisi</option>
                      <option
                        v-for="pegawai in pegawaiList"
                        :key="pegawai.id_pegawai"
                        :value="pegawai.nama_pegawai"
                      >
                        {{ `${pegawai.jabatan.nama_jabatan} - ${pegawai.nama_pegawai}` }}
                      </option>
                    </CFormSelect>
                    <span class="me-2"></span>
                    <CInputGroupAppend
                      v-if="index === disposisiList.length - 1 && disposisiList.length < 3"
                    >
                      <CButton color="success" @click="addDisposisi">
                        <CIcon icon="cilPlus" />
                      </CButton>
                    </CInputGroupAppend>
                  </CInputGroup>
                </div>
              </CRow>
            </div>
            <CRow class="mb-3 align-items-center">
              <CFormLabel class="col-sm-2 col-form-label" for="pesan">
                Pesan
              </CFormLabel>
              <div class="col-sm-10">
                <CInputGroup>
                  <CFormInput
                    v-model="pesan"
                    id="pesan"
                    placeholder="Masukkan Pesan"
                  />
                </CInputGroup>
              </div>
            </CRow>
          </CForm>

          <CRow class="mb-3">
            <div class="col-sm-10 offset-sm-2">
              <CButton color="danger" @click="cancel">Cancel</CButton>
              <CButton color="primary" class="ms-2" @click="submit">Submit</CButton>
            </div>
          </CRow>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      disposisiList: [{ value: '' }],
      pegawaiList: [],
      pesan: '',
    }
  },
  created() {
    this.fetchPegawaiList()
  },
  methods: {
    fetchPegawaiList() {
      axios
        .get('/api/disposisipegawai', {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })
        .then((response) => {
          this.pegawaiList = response.data.data.map((pegawai) => ({
            ...pegawai,
            jabatan: pegawai.jabatan,
          }))
        })
        .catch((error) => {
          console.error('Error fetching pegawai list:', error)
        })
    },
    addDisposisi() {
      if (this.disposisiList.length < 3) {
        this.disposisiList.push({ value: '' })
      }
    },
    cancel() {
      this.$router.push(`/detailsm/${this.$route.params.id}`)
    },
    async submit() {
      try {
        const payloadDisposisi = {
          id_surat_masuk: this.$route.params.id,
          disposisiList: this.disposisiList.map((disposisi) => ({
            penerimadispo: disposisi.value,
          })),
          status_pegawai: 'Aktif',
        }

        const responseDisposisi = await axios.post(
          '/api/disposisi',
          payloadDisposisi,
          {
            headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
          },
        )

        console.log('Response Disposisi:', responseDisposisi.data)

        const payloadPesan = {
          id_surat_masuk: this.$route.params.id,
          perintah_dispo: this.pesan,
        }

        const responsePesan = await axios.post('/api/pesan', payloadPesan, {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })

        console.log('Response Pesan:', responsePesan.data)

        this.$router.push(`/detailsm/${this.$route.params.id}`)
      } catch (error) {
        console.error('Error submitting disposisi:', error)
      }
    },
  },
}
</script>
