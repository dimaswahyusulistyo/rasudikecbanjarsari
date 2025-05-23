<template>
    <div>
        <h5 class="mb-4">DETAIL SURAT KELUAR</h5>
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
                                        role="img">
                                        <CIcon icon="cilInfo"/>
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
                                    class="btn btn-lg btn-white">
                                    <i class="fa fa-file fa-4x text-primary"></i>
                                </a>
                                <div class="mt-3">
                                    <a href="javascript:;" class="btn btn-default btn-block btn-sm">SURAT KELUAR</a>
                                </div>
                                <div
                                    class="btn-group d-flex justify-content-center mt-2"
                                    role="group"
                                    aria-label="Basic example">
                                </div>
  
                                <div class="text-center mt-3">
                                    <strong>AKSI</strong>
                                </div>
                                <div
                                    class="btn-group d-flex justify-content-center mt-2"
                                    role="group"
                                    aria-label="Basic example">
                                    <button
                                        type="button"
                                        class="btn btn-warning mr-1"
                                        @click="editSurat(detailSurat.id_surat_keluar)">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                    <button type="button" class="btn btn-danger" @click="deleteSurat">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-8 justify-content-between">
                            <table class="table table-profile mb-0">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Tertuju Kepada</td>
                                        <td>{{ detailSurat.tertuju_kepada }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tanggal Surat</td>
                                        <td>
                                            <i class="fa fa-calendar fa-lg text-warning mr-2"></i>
                                            {{ formatDate(detailSurat.tanggal_keluar) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Perihal</td>
                                        <td>{{ getPerihalName(detailSurat.perihal) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tempat Agenda</td>
                                        <td>
                                            <i class="fa fa-map-marker-alt fa-lg mr-2" style="color: red; margin-right: 5px;"></i>
                                            <span>{{ detailSurat.tempat_agenda ? detailSurat.tempat_agenda : ' -' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Waktu Agenda</td>
                                        <td>
                                            <i class="fa fa-calendar fa-lg text-warning mr-2" style="margin-right: 5px;"></i>
                                            <span>{{ detailSurat.tanggal_agenda ? formatAgenda(detailSurat.tanggal_agenda) : ' -' }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <br>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                            <tr>
                                <br>
                            </tr>
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
                                                        role="img">
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
                                            class="img-fluid"/>
                                        <embed
                                            v-if="isPDF(detailSurat.file_surat)"
                                            :src="fileUrl(detailSurat.file_surat)"
                                            type="application/pdf"
                                            class="w-100"
                                            style="height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
  
    <script>
        import axios from 'axios'
        import { useToast } from 'vue-toast-notification';
        import 'vue-toast-notification/dist/theme-sugar.css';
        import { ASSET_BASE_URL } from '@/config'

        export default {
            name: 'DetailSuratKeluar',
            data() {
                return {detailSurat: {}, kategoris: []}
            },
            methods: {
                editSurat(id_surat_keluar) {
                    this
                        .$router
                        .push(`/editsk/${id_surat_keluar}`)
                },
                deleteSurat() {
                    const toast = useToast();
                    if (confirm('Apakah Anda yakin ingin menghapus surat ini?')) {
                        const id_surat_keluar = this
                            .$route
                            .params
                            .id
                            axios
                            .delete(`/api/suratkeluar/${id_surat_keluar}`)
                            .then((response) => {
                                toast.success('Surat berhasil dihapus', { duration: 5000 });
                                this
                                    .$router
                                    .go(-1) 
                            })
                            .catch((error) => {
                                console.error('Error deleting data:', error)
                                toast.error('Terjadi kesalahan saat menghapus surat', { duration: 5000 });
                            })
                        }
                },
                openSurat() {
                    const id_surat_keluar = this.$route.params.id;
                    const documentUrl = `/api/suratkeluar/viewsurat/${id_surat_keluar}`;
                    window.open(documentUrl, '_blank');
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
                    const id_surat_keluar = this
                        .$route
                        .params
                        .id
                        axios
                        .get(`/api/suratkeluar/${id_surat_keluar}`)
                        .then((response) => {
                            this.detailSurat = response.data
                        })
                        .catch((error) => {
                            console.error('Error fetching data:', error)
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
                                error.response
                                    ? error.response.data
                                    : error.message,
                            )
                        })
                    },
                getPerihalName(perihal) {
                    if (perihal && perihal.startsWith && perihal.startsWith('Lainnya: ')) {
                        return perihal.replace('Lainnya: ', '');
                    }
                    const kategori = this
                        .kategoris
                        .find((kategori) => kategori.perihal === perihal);
                    return kategori
                        ? kategori.perihal
                        : perihal;
                },
                formatDate(dateString) {
                const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
                const date = new Date(dateString);
                return date.toLocaleDateString('id-ID', options);
                },
                formatAgenda(dateString) {
                const options = {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric',
                };
                const dateParts = dateString.split(' ');
                const date = new Date(`${dateParts[0]}T${dateParts[1]}`);
                const formattedDate = date.toLocaleDateString('id-ID', options);
                const hours = date.getHours().toString().padStart(2, '0');
                const minutes = date.getMinutes().toString().padStart(2, '0');
                return `${formattedDate.replace('', '')} pukul ${hours}.${minutes} WIB`;
                },
            },
            mounted() {
                this.fetchDetailSurat()
                this.fetchPerihal()
            }
        }
    </script>