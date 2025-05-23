<template>
  <div>
    <h5 class="mb-4">DETAIL SURAT MASUK</h5>
    <div class="container-fluid d-flex justify-content-center">
      <div class="card border mb-4">
        <CCardHeader class="d-flex justify-content-between align-items-center">
          <div>
            <ul class="nav nav-underline-border" role="navigation">
              <li class="nav-item">
                <a class="active nav-link" aria-current="page">
                  <svg
                    class="icon me-2 me-2"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    role="img"
                  >
                    <CIcon icon="cilInfo" />
                  </svg>
                  Detail Surat
                </a>
              </li>
            </ul>
          </div>
          <div>
            <span class="btn btn-primary mr-1 btn-sm">
              <b>{{ detailSurat.no_surat }}</b>
            </span>
          </div>
        </CCardHeader>

        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-xs-12 col-sm-3">
              <div class="text-center">
                <a
                  href="#"
                  @click.prevent="openSurat"
                  target="_blank"
                  title="View"
                  class="btn btn-lg btn-white"
                >
                  <i class="fa fa-file fa-4x text-primary"></i>
                </a>
                <div class="mt-3">
                  <a href="javascript:;" class="btn btn-default btn-block btn-sm">SURAT MASUK</a>
                </div>
                <div
                  class="btn-group d-flex justify-content-center mt-2"
                  role="group"
                  aria-label="Basic example"
                ></div>

                <div class="text-center mt-3" v-if="!isCamatOrAdmin()">
                  <strong>AKSI</strong>
                </div>
                <div
                  class="btn-group d-flex justify-content-center mt-2"
                  role="group"
                  aria-label="Basic example"
                >
                  <button
                    type="button"
                    class="btn btn-warning mr-1"
                    @click="editSurat(detailSurat.id_surat_masuk)"
                    v-if="!isCamatOrAdmin()"
                  >
                    <i class="fas fa-pencil-alt"></i>
                  </button>

                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="deleteSurat"
                    v-if="!isCamatOrAdmin()"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </div>
            </div>
            
            <div class="col-xs-12 col-sm-8 justify-content-between">
              <table class="table table-profile mb-0">
                <tbody>
                  
                  <tr>
                    <td class="font-weight-bold">Tanggal Diterima</td>
                    <td>{{ formatDate(detailSurat.created_at) }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Pengirim</td>
                    <td>{{ detailSurat.pengirim }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Tanggal Surat</td>
                    <td>
                      <i class="fa fa-calendar fa-lg text-warning mr-2"></i>
                      {{ formatDate(detailSurat.tanggal_diterima) }}
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Perihal</td>
                    <td>{{ getPerihalName(detailSurat.perihal) }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Isi Surat Ringkas</td>
                    <td>{{ detailSurat.isi_ringkas }}</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Tempat Agenda</td>
                    <td>
                      <i
                        class="fa fa-map-marker-alt fa-lg mr-2"
                        style="color: red; margin-right: 5px"
                      ></i>
                      <span>{{
                        detailSurat.tempat_agenda ? detailSurat.tempat_agenda : ' -'
                      }}</span>
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Waktu Agenda</td>
                    <td>
                      <i
                        class="fa fa-calendar fa-lg text-warning mr-2"
                        style="margin-right: 5px"
                      ></i>
                      <span>
                        {{
                          detailSurat.tanggal_agenda
                            ? formatAgenda(detailSurat.tanggal_agenda)
                            : ' -'
                        }}</span
                      >
                    </td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Disposisi</td>
                    <td v-if="detailSurat.disposisi && detailSurat.disposisi.length > 0">
                      <ol style="text-align: left">
                        <li v-for="dispo in detailSurat.disposisi" :key="dispo.id_disposisi">
                          {{ dispo.penerimadispo }}
                        </li>
                      </ol>
                    </td>
                    <td v-else>Belum ada disposisi</td>
                  </tr>
                  <tr>
                    <td class="font-weight-bold">Pesan</td>
                    <td v-if="filteredPesan.length > 0">
                      <ol style="text-align: left">
                        <li v-for="msg in filteredPesan" :key="msg.id_pesan">
                          {{ msg.perintah_dispo }}
                          <div>({{ msg.pendispo }})</div>
                        </li>
                      </ol>
                    </td>
                    <td v-else>Belum ada pesan</td>
                  </tr>
                  <tr>
                    <br />
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="card border mb-4">
              <div class="row align-items-center">
                <CCardHeader class="d-flex justify-content-between align-items-center">
                  <div>
                    <ul class="nav nav-underline-border" role="navigation">
                      <li class="nav-item">
                        <a class="active nav-link" aria-current="page">
                          <svg
                            class="icon me-2 me-2"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 512 512"
                            role="img"
                          >
                            <i class="fa fa-file fa-4x text-primary"></i>
                          </svg>
                          Isi Surat
                        </a>
                      </li>
                    </ul>
                  </div>
                </CCardHeader>

                <div class="card-body">
                  <div class="file-preview mb-3">
                    <img
                      v-if="isImage(detailSurat.file_surat)"
                      :src="fileUrl(detailSurat.file_surat)"
                      alt="Surat Image"
                      class="img-fluid"
                    />
                    <embed
                      v-if="isPDF(detailSurat.file_surat)"
                      :src="fileUrl(detailSurat.file_surat)"
                      type="application/pdf"
                      class="w-100"
                      style="height: 400px"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card border mb-4">
            <CCardHeader class="d-flex justify-content-between align-items-center">
              <div>
                <ul class="nav nav-underline-border" role="navigation">
                  <li class="nav-item">
                    <a class="active nav-link" aria-current="page">
                      <svg
                        class="icon me-2 me-2"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        role="img"
                      >
                        <CIcon icon="cilPeople" />
                      </svg>
                      Disposisi
                    </a>
                  </li>
                </ul>
              </div>
              <div>
                <CButton
                  v-if="shouldShowTambahButton()"
                  color="success"
                  @click="$router.push(`/tambahdsp/${detailSurat.id_surat_masuk}`)"
                  class="text-white"
                >
                  <CIcon icon="cil-plus" /> TAMBAH
                </CButton>
              </div>
            </CCardHeader>
            <CCardBody>
              <CTable align="middle" class="mb-0 border" hover="hover" responsive="responsive">
                <CTableHead class="text-nowrap">
                  <CTableRow>
                    <CTableHeaderCell class="bg-body-secondary text-center">No.</CTableHeaderCell>
                    <CTableHeaderCell class="bg-body-secondary">Tanggal Disposisi</CTableHeaderCell>
                    <CTableHeaderCell class="bg-body-secondary"
                      >Pengirim Disposisi</CTableHeaderCell
                    >
                    <CTableHeaderCell class="bg-body-secondary"
                      >Penerima Disposisi</CTableHeaderCell
                    >
                    <CTableHeaderCell class="bg-body-secondary">Perihal</CTableHeaderCell>
                    <CTableHeaderCell class="bg-body-secondary">Aksi</CTableHeaderCell>
                  </CTableRow>
                </CTableHead>
                <CTableBody>
                  <CTableRow
                    v-for="(dispo, index) in detailSurat.disposisi"
                    :key="dispo.id_disposisi"
                  >
                    <CTableDataCell class="text-center">{{ index + 1 }}</CTableDataCell>
                    <CTableDataCell>{{ formatDate(dispo.created_at) }}</CTableDataCell>
                    <CTableDataCell>{{ dispo.pendispo }}</CTableDataCell>
                    <CTableDataCell>{{ dispo.penerimadispo }}</CTableDataCell>
                    <CTableDataCell>{{ getPerihalName(detailSurat.perihal) }}</CTableDataCell>
                    <CTableDataCell>
                      <CButton
                        color="warning"
                        v-if="
                          currentUser &&
                          currentUser.pegawai &&
                          currentUser.pegawai.nama_pegawai === dispo.penerimadispo
                        "
                        @click="
                          $router.push({
                            name: 'Ubah Disposisi',
                            params: {
                              id: dispo.id_disposisi,
                              suratId: detailSurat.id_surat_masuk,
                            },
                          })
                        "
                      >
                        <CIcon icon="cil-info" />
                      </CButton>
                    </CTableDataCell>
                  </CTableRow>
                </CTableBody>
              </CTable>
            </CCardBody>
          </div>
          <LembarDisposisi v-if="detailSurat.disposisi && detailSurat.disposisi.length > 0" />
          <Notulensi />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import LembarDisposisi from './LembarDSP.vue'
import Notulensi from '../notulensi/Notulensi.vue'
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { ASSET_BASE_URL } from '@/config'

export default {
  name: 'DetailSuratMasuk',
  components: {
    LembarDisposisi,
    Notulensi,
  },
  data() {
    return {
      detailSurat: {},
      kategoris: [],
      currentUser: null,
      pesan: [],
    }
  },
  computed: {
    filteredPesan() {
      return this.pesan.filter((msg) => msg.id_surat_masuk === this.detailSurat.id_surat_masuk)
    },
  },
  methods: {
    editSurat(id_surat_masuk) {
      this.$router.push(`/editsm/${id_surat_masuk}`)
    },
    deleteSurat() {
      const toast = useToast();
      if (confirm('Apakah Anda yakin ingin menghapus surat ini?')) {
        const id_surat_masuk = this.$route.params.id
        axios
          .delete(`/api/suratmasuk/${id_surat_masuk}`)
          .then((response) => {
            toast.success('Surat berhasil dihapus', { duration: 5000 });
            this.$router.go(-1)
          })
          .catch((error) => {
            console.error('Error deleting data:', error)
            toast.error('Terjadi kesalahan saat menghapus surat', { duration: 5000 });
          })
      }
    },
    isCamatOrAdmin() {
      return (
        this.currentUser && (this.currentUser.role === 'camat' || this.currentUser.role === 'admin')
      )
    },
    shouldShowTambahButton() {
      return (
        this.currentUser &&
        (this.currentUser.role === 'camat' ||
          this.detailSurat.disposisi.some(
            (dispo) => dispo.penerimadispo === this.currentUser.pegawai.nama_pegawai,
          ))
      )
    },
    openSurat() {
      const id_surat_masuk = this.$route.params.id
      const documentUrl = `/api/suratmasuk/viewsurat/${id_surat_masuk}`
      window.open(documentUrl, '_blank')
    },
    fileUrl(fileName) {
      return `${ASSET_BASE_URL}uploads/${fileName}`
    },
    isImage(fileName) {
      return /\.(jpg|jpeg|png)$/i.test(fileName)
    },
    isPDF(fileName) {
      return /\.pdf$/i.test(fileName)
    },
    fetchDetailSurat() {
      const id_surat_masuk = this.$route.params.id
      axios
        .get(`/api/suratmasuk/${id_surat_masuk}`)
        .then((response) => {
          this.detailSurat = response.data
        })
        .catch((error) => {
          console.error('Error fetching data:', error)
        })
    },
    fetchPesan() {
      const id_surat_masuk = this.$route.params.id
      const token = localStorage.getItem('token')
      axios
        .get(`/api/pesan?${id_surat_masuk}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          this.pesan = response.data
        })
        .catch((error) => {
          console.error('Error fetching pesan:', error)
        })
    },
    fetchPerihal() {
      axios
        .get(`/api/kategoriperihal`)
        .then((response) => {
          this.kategoris = response.data
        })
        .catch((error) => {
          console.error(
            'Error fetching data:',
            error.response ? error.response.data : error.message,
          )
        })
    },
    fetchCurrentUser() {
      axios
        .get('/api/user', {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })
        .then((response) => {
          this.currentUser = response.data.user
        })
        .catch((error) => {
          console.error('Error fetching current user:', error)
        })
    },
    getPerihalName(perihal) {
      if (perihal && perihal.startsWith && perihal.startsWith('Lainnya: ')) {
        return perihal.replace('Lainnya: ', '')
      }
      const kategori = this.kategoris.find((kategori) => kategori.perihal === perihal)
      return kategori ? kategori.perihal : perihal
    },
    formatDate(dateString) {
      const options = { day: 'numeric', month: 'numeric', year: 'numeric' }
      const date = new Date(dateString)
      return date.toLocaleDateString('id-ID', options)
    },
    formatAgenda(dateString) {
      const options = {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
      }
      const dateParts = dateString.split(' ')
      const date = new Date(`${dateParts[0]}T${dateParts[1]}`)
      const formattedDate = date.toLocaleDateString('id-ID', options)
      const hours = date.getHours().toString().padStart(2, '0')
      const minutes = date.getMinutes().toString().padStart(2, '0')
      return `${formattedDate.replace('', '')} pukul ${hours}.${minutes} WIB`
    },
  },
  mounted() {
    this.fetchDetailSurat()
    this.fetchPerihal()
    this.fetchCurrentUser()
    this.fetchPesan()
  },
}
</script>
