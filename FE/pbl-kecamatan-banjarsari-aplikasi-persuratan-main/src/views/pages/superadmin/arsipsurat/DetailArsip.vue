<template>
    <div>
        <h5 class="mb-4">DETAIL SURAT</h5>
        <div class="container-fluid d-flex justify-content-center">
            <div class="card border mb-4">
                <CCardHeader class="d-flex justify-content-between align-items-center">
                    <div>
                        <ul class="nav nav-underline-border" role="navigation">
                            <li class="nav-item">
                                <a class="active nav-link" aria-current="page" href="#">
                                    <svg class="icon me-2 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                        role="img">
                                        <CIcon icon="cilInfo" />
                                    </svg>
                                    Detail Surat
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" @click="$router.push('/disposisiarsip')" target="_blank">
                                    <svg class="icon me-2 me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                        role="img">
                                        <CIcon icon="cilHistory" />
                                    </svg>
                                    Riwayat Disposisi
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4>DSP010114</h4>
                    </div>
                </CCardHeader>

                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-xs-12 col-sm-3">
                            <div class="text-center">
                                <a href="#" target="_blank" title="View" class="btn btn-lg btn-white">
                                    <i class="fa fa-file fa-4x text-primary"></i>
                                </a>
                                <div class="mt-3">
                                    <a href="javascript:;" class="btn btn-default btn-block btn-sm">SURAT MASUK</a>
                                </div>
                                <div class="btn-group d-flex justify-content-center mt-2" role="group"
                                    aria-label="Basic example">
                                    <button type="button" class="btn btn-primary mr-1 btn-sm" @click="">
                                        BUKA
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-8 justify-content-between">
                            <table class="table table-profile mb-0">
                                <tbody>
                                    <tr>
                                        <td class="font-weight-bold">Waktu Surat Masuk</td>
                                        <td>
                                            <i class="fa fa-calendar fa-lg text-warning mr-2"></i>
                                            2024-02-20 / 22:05
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tanggal Agenda</td>
                                        <td>2024-02-24</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Pengirim</td>
                                        <td>Camat</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Perihal</td>
                                        <td>Pemberitahuan</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Tertuju Kepada</td>
                                        <td>Kelurahan</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Isi Surat Ringkas</td>
                                        <td>Rapat pertemuan lurah se-Kecamatan Banjarsari</td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Disposisi</td>
                                        <td>Lurah</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'DetailSuratMasuk',
    methods: {
        edit: function () {
            alert('Edit button clicked');
        },
        delete: function () {
            alert('Delete button clicked');
        }
    }
}
</script>
