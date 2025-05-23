<template>
  <div>
    <div class="card border mb-4">
      <CCardHeader class="d-flex justify-content-between align-items-center">
        <div>
          <ul class="nav nav-underline-border" role="navigation">
            <li class="nav-item">
              <a
                :class="{ active: activeTab === 'notulensi' }"
                @click="setActiveTab('notulensi')"
                class="nav-link"
                aria-current="page"
              >
                <svg
                  class="icon me-2"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512"
                  role="img"
                >
                  <CIcon icon="cilPaperclip" />
                </svg>
                Notulensi
              </a>
            </li>
            <li class="nav-item">
              <a
                :class="{ active: activeTab === 'foto' }"
                @click="setActiveTab('foto')"
                class="nav-link"
              >
                <svg
                  class="icon me-2"
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512"
                  role="img"
                >
                  <CIcon :icon="cilImage" />
                </svg>
                Foto
              </a>
            </li>
          </ul>
        </div>
        <div>
          <CButton
            v-if="activeTab === 'notulensi' && shouldShowTambahButton"
            color="success"
            @click="goToInputNotulensi"
            class="text-white"
          >
            <CIcon icon="cil-plus" /> TAMBAH
          </CButton>
        </div>
      </CCardHeader>
      <CCardBody>
        <CTable
          align="middle"
          class="mb-0 border"
          hover
          responsive
          v-if="activeTab === 'notulensi'"
        >
          <CTableHead class="text-nowrap">
            <CTableRow>
              <CTableHeaderCell class="bg-body-secondary text-center">No.</CTableHeaderCell>
              <CTableHeaderCell class="bg-body-secondary">Penerima Disposisi</CTableHeaderCell>
              <CTableHeaderCell class="bg-body-secondary">Catatan Notulensi</CTableHeaderCell>
              <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
            </CTableRow>
          </CTableHead>
          <CTableBody>
            <CTableRow v-for="(dispo, index) in detailSurat.disposisi" :key="dispo.id_disposisi">
              <CTableDataCell class="text-center">{{ index + 1 }}</CTableDataCell>
              <CTableDataCell>{{ dispo.penerimadispo }}</CTableDataCell>
              <CTableDataCell>{{ dispo.notulensi || 'Belum ada notulensi' }}</CTableDataCell>
              <CTableDataCell>
                <CButton
                  v-if="dispo.notulensi && isCurrentUserRecipient(dispo)"
                  color="warning"
                  class="me-1"
                  @click="goToInputNotulensi(dispo.id_disposisi)"
                >
                  <i class="fas fa-pencil-alt"></i>
                </CButton>
              </CTableDataCell>
            </CTableRow>
          </CTableBody>
        </CTable>
        <div v-if="activeTab === 'foto'">
          <CTable align="middle" class="mb-0 border" hover responsive>
            <CTableHead class="text-nowrap">
              <CTableRow>
                <CTableHeaderCell class="bg-body-secondary text-center">No.</CTableHeaderCell>
                <CTableHeaderCell class="bg-body-secondary">Gambar</CTableHeaderCell>
                <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
              </CTableRow>
            </CTableHead>
            <CTableBody>
              <CTableRow v-for="(foto, index) in fotos" :key="foto.id_foto_notulensi">
                <CTableDataCell class="text-center">{{ index + 1 }}</CTableDataCell>
                <CTableDataCell>
                  <img
                    :src="getFotoUrl(foto.file_foto)"
                    alt="Foto"
                    style="max-width: 100px; max-height: 100px"
                  />
                </CTableDataCell>
                <CTableDataCell>
                  <CButton color="primary" @click="downloadFoto(foto.id_foto_notulensi)">
                    Download
                  </CButton>
                  <CButton color="danger" @click="confirmDeleteFoto(foto.id_foto_notulensi)">
                    Hapus
                  </CButton>
                </CTableDataCell>
              </CTableRow>
            </CTableBody>
          </CTable>
        </div>
      </CCardBody>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import { ASSET_BASE_URL } from '@/config'
import { useToast } from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'
import { CIcon } from '@coreui/icons-vue'
import { cilImage } from '@coreui/icons'

export default {
  name: 'Notulensi',
  data() {
    return {
      activeTab: 'notulensi',
      detailSurat: {},
      currentUser: null,
      fotos: [],
      shouldShowTambahButton: false,
    }
  },
  components: {
    CIcon,
  },
  methods: {
    setActiveTab(tab) {
      this.activeTab = tab
      if (tab === 'foto') {
        this.fetchFotos()
      }
    },
    fetchDetailSurat() {
      const id_surat_masuk = this.$route.params.id
      axios
        .get(`/api/suratmasuk/${id_surat_masuk}`)
        .then((response) => {
          this.detailSurat = response.data
          this.checkUserNotulensi()
        })
        .catch((error) => {
          console.error('Error fetching data:', error)
        })
    },
    fetchCurrentUser() {
      axios
        .get('/api/user', {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })
        .then((response) => {
          this.currentUser = response.data.user
          this.checkUserNotulensi()
        })
        .catch((error) => {
          console.error('Error fetching current user:', error)
        })
    },
    checkUserNotulensi() {
      if (this.currentUser && this.detailSurat.disposisi) {
        const currentUserName = this.currentUser.pegawai.nama_pegawai
        this.shouldShowTambahButton = this.detailSurat.disposisi.some(
          (dispo) => dispo.penerimadispo === currentUserName && !dispo.notulensi,
        )
      }
    },
    goToInputNotulensi(id_disposisi) {
      this.$router.push({
        name: 'Input Notulensi',
        params: {
          id: id_disposisi,
          suratId: this.detailSurat.id_surat_masuk,
        },
      })
    },
    isCurrentUserRecipient(dispo) {
      return this.currentUser && dispo.penerimadispo === this.currentUser.pegawai.nama_pegawai
    },
    fetchFotos() {
      if (this.detailSurat.disposisi && this.detailSurat.disposisi.length > 0) {
        const id_disposisi = this.detailSurat.disposisi[0].id_disposisi
        axios
          .get(`/api/foto_notulensi/disposisi/${id_disposisi}`)
          .then((response) => {
            this.fotos = response.data
          })
          .catch((error) => {
            console.error('Error fetching fotos:', error)
          })
      } else {
        console.error('Detail disposisi not found:', this.detailSurat)
      }
    },
    deleteFoto(id_foto_notulensi) {
      axios
        .delete(`/api/foto_notulensi/${id_foto_notulensi}`)
        .then(() => {
          this.fotos = this.fotos.filter((foto) => foto.id_foto_notulensi !== id_foto_notulensi)
          const toast = useToast()
          toast.success('Foto berhasil dihapus', { duration: 5000 })
        })
        .catch((error) => {
          console.error('Error deleting foto:', error)
          const toast = useToast()
          toast.error('Terjadi kesalahan saat menghapus foto', { duration: 5000 })
        })
    },
    confirmDeleteFoto(id_foto_notulensi) {
      if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
        this.deleteFoto(id_foto_notulensi)
      }
    },
    getFotoUrl(filename) {
      return `${ASSET_BASE_URL}foto_notulensi/${filename}`
    },
    downloadFoto(id_foto_notulensi) {
      axios({
        url: `/api/foto_notulensi/download/${id_foto_notulensi}`,
        method: 'GET',
        responseType: 'blob',
      })
        .then((response) => {
          const url = window.URL.createObjectURL(new Blob([response.data]))
          const link = document.createElement('a')
          link.href = url
          link.setAttribute('download', 'foto_notulensi.jpg')
          document.body.appendChild(link)
          link.click()
          link.parentNode.removeChild(link)

          const toast = useToast()
          toast.success('Foto berhasil diunduh', { duration: 5000 })
        })
        .catch((error) => {
          console.error('Error downloading foto:', error)
          const toast = useToast()
          toast.error('Terjadi kesalahan saat mengunduh foto', { duration: 5000 })
        })
    },
  },
  mounted() {
    this.fetchDetailSurat()
    this.fetchCurrentUser()
  },
  setup() {
    return {
      cilImage,
    }
  },
}
</script>
