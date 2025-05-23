<template>
    <div class="card border mb-4">
            <CCardHeader class="d-flex justify-content-between align-items-center">
              <div>
                <ul class="nav nav-underline-border" role="navigation">
                  <li class="nav-item">
                    <a class="active nav-link" aria-current="page">
                      <svg
                        class="icon me-2"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"
                        role="img"
                      >
                        <CIcon icon="cilTag" />
                      </svg>
                      Lembar Disposisi
                    </a>
                  </li>
                </ul>
              </div>
              <div>
                <span class="btn btn-success mr-1 btn-sm" style="color: white">
                    <a class="active nav-link" aria-current="page" @click="cetakLembarDSP">
                    <svg class="icon me-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" role="img">
                        <CIcon icon="cilCloudDownload" />
                    </svg>
                    Download
                    </a>
                </span>
              </div>
            </CCardHeader>
            <CCardBody>
              <body id="printTable" style="margin: 0; padding: 0; display: flex; justify-content: center; background-color: #ffffff;">
                <table  style="margin-left: -0.25pt; border-collapse: collapse; border-color: black;">
                  <tbody style=" color: #000000;">
                    <tr style=" color: #ffffff;">
                      <td
                        style="
                          color: #000000;
                          width: 141.65pt;
                          border-left: 1pt solid black;
                          border-top: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-right: 0pt;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <img
                          src="@\assets\images\logo-jateng.png"
                          alt="Logo"
                          width="auto"
                          height="65"
                        />
                      </td>
                      <td
                        colspan="4"
                        style="
                          color: #000000;
                          width: 233.65pt;
                          border-top: 1pt solid black;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-image: initial;
                          border-left: none;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          PEMERINTAH KOTA SURAKARTA<br />KECAMATAN BANJARSARI
                        </p>
                      </td>
                      <td
                        rowspan="2"
                        style="
                          width: 75.75pt;
                          border-top: 1pt solid black;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-image: initial;
                          border-left: none;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            color: #000000;
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            text-align: center;
                            line-height: normal;
                          "
                        >
                          NO.&nbsp;<br />&nbsp;AGENDA 
                          <br> {{ detailSurat.no_agenda }}
                        </p>
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            text-align: center;
                            line-height: normal;
                          "
                        >
                          
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="5"
                        style="
                          width: 375.3pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            text-align: center;
                            line-height: normal;
                          "
                        >
                          <strong>LEMBAR DISPOSISI</strong>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="2"
                        style="
                          width: 187.75pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Berkas: {{ detailSurat.perihal }}
                        </p>
                      </td>
                      <td
                        colspan="3"
                        style="
                          width: 187.55pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Tgl. Terima: {{ formatDate(detailSurat.created_at) }}
                        </p>
                      </td>
                      <td
                        rowspan="2"
                        style="
                          width: 75.75pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Kode: {{ detailSurat.kode }}
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="2"
                        style="
                          width: 187.75pt;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Sifat: {{ detailSurat.sifat_surat }}
                        </p>
                      </td>
                      <td
                        colspan="3"
                        style="
                          width: 187.55pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="6"
                        style="
                          width: 451.05pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Isi Ringkas: {{ detailSurat.isi_ringkas }}
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="6"
                        style="
                          width: 451.05pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Dari: {{ detailSurat.pengirim }}
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="3"
                        style="
                          width: 225.6pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Tgl. Surat: {{ formatDate(detailSurat.tanggal_diterima) }}
                        </p>
                      </td>
                      <td
                        colspan="3"
                        style="
                          width: 225.45pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          No. Surat: {{ detailSurat.no_surat }}
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="3"
                        style="
                          width: 225.6pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            text-align: center;
                            line-height: normal;
                          "
                        >
                          Keterangan Disposisi:
                        </p>
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            text-align: center;
                            line-height: normal;
                          "
                        >
                            <ol style="text-align: left">
                                <li v-for="msg in filteredPesan" :key="msg.id_pesan">
                                {{ msg.perintah_dispo }}
                                </li>
                            </ol>
                        </p>
                      </td>
                      <td
                        colspan="3"
                        style="
                          width: 225.45pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            text-align: center;
                            line-height: normal;
                          "
                        >
                          Diteruskan Kepada:<br />
                        <ol style="text-align: left">
                            <li v-for="dispo in detailSurat.disposisi" :key="dispo.id_disposisi">
                            {{ dispo.penerimadispo }}
                            </li>
                        </ol>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        style="
                          width: 141.65pt;
                          border-left: 1pt solid black;
                          border-top: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-right: 0pt;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <img
                          src="@\assets\images\logo-jateng.png"
                          alt="Logo"
                          width="auto"
                          height="45"
                        />
                      </td>
                      <td
                        colspan="4"
                        style="
                          width: 233.65pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          PEMERINTAH KOTA SURAKARTA<br />KECAMATAN BANJARSARI
                        </p>
                      </td>
                      <td
                        rowspan="2"
                        style="
                          width: 75.75pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            text-align: center;
                            line-height: normal;
                          "
                        >
                          NO.&nbsp;<br />&nbsp;AGENDA 
                          <br>{{ detailSurat.no_agenda }}
                        </p>
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            text-align: center;
                            line-height: normal;
                          "
                        >
                          
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="5"
                        style="
                          width: 375.3pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            text-align: center;
                            line-height: normal;
                          "
                        >
                          <strong>KARTU KENDALI SURAT MASUK</strong>
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="2"
                        style="
                          width: 187.75pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Berkas: {{ detailSurat.perihal }}
                        </p>
                      </td>
                      <td
                        colspan="3"
                        style="
                          width: 187.55pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Tgl. Terima: {{ formatDate(detailSurat.created_at) }}
                        </p>
                      </td>
                      <td
                        rowspan="2"
                        style="
                          width: 75.75pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Kode: {{ detailSurat.kode }}
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="2"
                        style="
                          width: 187.75pt;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Sifat: {{ detailSurat.sifat_surat }}
                        </p>
                      </td>
                      <td
                        colspan="3"
                        style="
                          width: 187.55pt;
                          border-top: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="6"
                        style="
                          width: 451.05pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          height: 27.35pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Isi ringkas: {{ detailSurat.isi_ringkas }}
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        colspan="6"
                        style="
                          width: 451.05pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Dari: {{ detailSurat.pengirim }}
                        </p>
                      </td>
                    </tr>
                    <tr>
                      <td
                        style="
                          width: 141.65pt;
                          border-right: 1pt solid black;
                          border-bottom: 1pt solid black;
                          border-left: 1pt solid black;
                          border-image: initial;
                          border-top: none;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Tgl. Surat: {{ formatDate(detailSurat.tanggal_diterima) }}
                        </p>
                      </td>
                      <td
                        colspan="3"
                        style="
                          width: 155.9pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          Tgl. Terima: {{ formatDate(detailSurat.created_at) }}
                        </p>
                      </td>
                      <td
                        colspan="2"
                        style="
                          width: 153.5pt;
                          border-top: none;
                          border-left: none;
                          border-bottom: 1pt solid black;
                          border-right: 1pt solid black;
                          padding: 0cm 5.4pt;
                          vertical-align: top;
                        "
                      >
                        <p
                          style="
                            margin-top: 0cm;
                            margin-right: 0cm;
                            margin-bottom: 0cm;
                            margin-left: 0cm;
                            font-size: 11pt;
                            font-family: 'Calibri', sans-serif;
                            line-height: normal;
                          "
                        >
                          No. Surat: {{ detailSurat.no_surat }}
                        </p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </body>
            </CCardBody>
          </div>
</template>

<script>
import html2pdf from 'html2pdf.js';
import axios from 'axios';

export default {
  name: 'LembarDisposisi',
  
  data() {
    return {
      detailSurat: {},
      kategoris: [],
      currentUser: null,
      pesan: [],
      sifat_surat: [],
    };
  },
  
  computed: {
    filteredPesan() {
      return this.pesan.filter((msg) => msg.id_surat_masuk === this.detailSurat.id_surat_masuk);
    },
  },

  methods: {
    cetakLembarDSP() {
      const options = {
        filename: 'Lembar Disposisi.pdf',
        image: { type: 'jpeg', quality: 2 },
        html2canvas: { dpi: 500, letterRendering: true },
        jsPDF: { unit: 'pt', format: 'a4', orientation: 'portrait' },
      };

      const element = document.getElementById('printTable');
      
      element.style.marginTop = '20px';
      element.style.margin = '0';
      element.style.padding = '0';
      element.style.display = 'flex';
      element.style.justifyContent = 'center';

      html2pdf()
        .from(element)
        .set(options)
        .save();
    },

    fetchDetailSurat() {
      const id_surat_masuk = this.$route.params.id;
      axios
        .get(`/api/suratmasuk/${id_surat_masuk}`)
        .then((response) => {
          this.detailSurat = response.data;
        })
        .catch((error) => {
          console.error('Error fetching data:', error);
        });
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
          this.kategoris = response.data;
        })
        .catch((error) => {
          console.error(
            'Error fetching data:',
            error.response ? error.response.data : error.message,
          );
        });
    },

    fetchCurrentUser() {
      axios
        .get('/api/user', {
          headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
        })
        .then((response) => {
          this.currentUser = response.data.user;
        })
        .catch((error) => {
          console.error('Error fetching current user:', error);
        });
    },

    getPerihalName(perihal) {
      if (perihal && perihal.startsWith && perihal.startsWith('Lainnya: ')) {
        return perihal.replace('Lainnya: ', '');
      }
      const kategori = this.kategoris.find((kategori) => kategori.perihal === perihal);
      return kategori ? kategori.perihal : perihal;
    },

    formatDate(dateString){
      const options = { day: 'numeric', month: 'numeric', year: 'numeric' };
      const date = new Date(dateString);
      return date.toLocaleDateString('id-ID', options);
    },

  },
  
  
  mounted() {
    this.fetchDetailSurat();
    this.fetchPerihal();
    this.fetchPesan();
  },
};
</script>

<style scoped>
body {
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  background-color: #ffffff;
}

#printTable {
  margin-left: -0.25pt;
  border-collapse: collapse;
  border: none;
}

@media (prefers-color-scheme: dark) {
  body {
    background-color: #ffffff;
  }
}
</style>
