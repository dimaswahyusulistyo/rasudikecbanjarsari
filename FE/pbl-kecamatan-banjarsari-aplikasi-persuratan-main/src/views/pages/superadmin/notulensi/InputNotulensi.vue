<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader>
          <strong>INPUT NOTULENSI</strong>
        </CCardHeader>
        <CCardBody>
          <CForm>
            <!-- Form untuk notulensi -->
            <CRow class="mb-3 align-items-center">
              <CFormLabel for="notulensi" class="col-sm-2 col-form-label"> Notulensi </CFormLabel>
              <div class="col-sm-10">
                <CInputGroup>
                  <CFormInput v-model="notulensi" id="notulensi" placeholder="Masukkan Notulensi" />
                </CInputGroup>
              </div>
            </CRow>

            <!-- Form untuk upload foto -->
            <CRow class="mb-3 align-items-center" v-for="(file, index) in fileList" :key="index">
              <CFormLabel :for="'file_foto_' + index" class="col-sm-2 col-form-label">
                {{ index === 0 ? 'Upload Foto' : '' }}
              </CFormLabel>
              <div class="col-sm-10">
                <CInputGroup>
                  <CFormInput type="file" :id="'file_foto_' + index" @change="(event) => handleFileUpload(event, index)" />
                  <span class="me-2"></span>
                  <CInputGroupAppend v-if="index === fileList.length - 1 && fileList.length < 3">
                    <CButton color="success" @click="addFileInput">
                      <CIcon icon="cilPlus" />
                    </CButton>
                  </CInputGroupAppend>
                </CInputGroup>
              </div>
            </CRow>

            <!-- Tombol untuk submit -->
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
      notulensi: '',
      idSuratMasuk: '',
      penerimaDisposisi: '',
      statusPegawai: 'Aktif',
      fileList: [{ file: null }],
      idDisposisi: '',
    }
  },
  created() {
    this.fetchDisposisiData()
  },
  methods: {
    fetchDisposisiData() {
      axios
        .get(`/api/disposisi/${this.id}`, {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })
        .then((response) => {
          const disposisiData = response.data
          this.notulensi = disposisiData.notulensi
          this.idSuratMasuk = disposisiData.id_surat_masuk
          this.penerimaDisposisi = disposisiData.penerimadispo
          this.idDisposisi = disposisiData.id_disposisi
        })
        .catch((error) => {
          console.error('Error fetching disposisi data:', error)
        })
    },
    handleFileUpload(event, index) {
      this.fileList[index].file = event.target.files[0]
    },
    addFileInput() {
      if (this.fileList.length < 3) {
        this.fileList.push({ file: null })
      }
    },
    cancel() {
      this.$router.push(`/detailsm/${this.idSuratMasuk}`)
    },
    async submit() {
      try {
        if (!this.idDisposisi) {
          console.error('ID Disposisi is required.')
          return
        }

        const payload = {
          notulensi: this.notulensi,
          id_surat_masuk: this.idSuratMasuk,
          penerimadispo: this.penerimaDisposisi,
          status_pegawai: this.statusPegawai,
        }

        const response = await axios.put(`/api/notulensi/${this.id}`, payload, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })

        console.log('Response:', response.data)

        const formData = new FormData()
        let hasFiles = false

        this.fileList.forEach((fileObj, index) => {
          if (fileObj.file) {
            formData.append(`file_foto[${index}]`, fileObj.file)
            hasFiles = true
          }
        })

        if (hasFiles) {
          formData.append('id_disposisi', this.idDisposisi)

          const fileResponse = await axios.post(`/api/foto_notulensi`, formData, {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
              'Content-Type': 'multipart/form-data',
            },
          })

          console.log('File Response:', fileResponse.data)
        }

        this.$router.push(`/detailsm/${this.idSuratMasuk}`)
      } catch (error) {
        console.error('Error submitting notulensi:', error)
        if (error.response) {
          console.error('Error Response:', error.response.data)
        }
      }
    },
  },
}
</script>
