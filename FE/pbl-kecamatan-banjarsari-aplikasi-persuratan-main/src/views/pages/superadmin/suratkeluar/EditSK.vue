<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader style="background-color: #003083; color: white;">
          <strong>EDIT SURAT KELUAR</strong>
        </CCardHeader>
        <CCardBody>
          <CForm @submit.prevent="submitForm">
            <CRow class="mb-3">
              <CFormLabel for="tertujuKepada" class="col-sm-2 col-form-label">
                Tertuju Kepada
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="tertujuKepada" v-model="post.tertuju_kepada" type="text" />
                <div v-if="validation.tertuju_kepada" class="mt-2 alert alert-danger">
                  {{ validation.tertuju_kepada[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="noSurat" class="col-sm-2 col-form-label">
                Nomor Surat
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="noSurat" v-model="post.no_surat" type="text" />
                <div v-if="validation.no_surat" class="mt-2 alert alert-danger">
                  {{ validation.no_surat[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tanggalSurat" class="col-sm-2 col-form-label">
                Tanggal Surat
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="tanggalSurat" v-model="post.tanggal_keluar" type="date" />
                <div v-if="validation.tanggal_keluar" class="mt-2 alert alert-danger">
                  {{ validation.tanggal_keluar[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tempatAgenda" class="col-sm-2 col-form-label">
                Tempat Agenda
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="tempatAgenda" v-model="post.tempat_agenda" type="text" />
                <div v-if="validation.tempat_agenda" class="mt-2 alert alert-danger">
                  {{ validation.tempat_agenda[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tanggalAgenda" class="col-sm-2 col-form-label">
                Tanggal Agenda
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="tanggalAgenda" v-model="post.tanggal_agenda" type="datetime-local" :required="false" />
                <div v-if="validation.tanggal_agenda" class="mt-2 alert alert-danger">
                  {{ validation.tanggal_agenda[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="perihal" class="col-sm-2 col-form-label">
                Kategori Perihal
              </CFormLabel>
              <div class="col-sm-10">
                <CFormSelect
                  id="perihal"
                  v-model="post.perihal"
                  @change="handleKategoriChange"
                  required
                >
                  <option value="">Pilih Kategori Perihal</option>
                  <option
                    v-for="kategori in kategoriPerihalList"
                    :key="kategori.perihal"
                    :value="kategori.perihal"
                  >
                    {{ kategori.perihal }}
                  </option>
                  <option value="Lainnya">Lainnya</option>
                </CFormSelect>
              </div>
            </CRow>
            <CRow class="mb-3" v-if="post.perihal === 'Lainnya'">
              <CFormLabel for="perihal_lainnya" class="col-sm-2 col-form-label">
                Perihal Lainnya
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput
                  id="perihal_lainnya"
                  v-model="post.perihal_lainnya"
                  type="text"
                  required
                />
              </div>
            </CRow>
            <div class="mb-3">
              <CFormLabel for="isiSurat">Isi Surat Ringkas</CFormLabel>
              <CFormTextarea id="isiSurat" v-model="post.isi_ringkas" rows="3"></CFormTextarea>
              <div v-if="validation.isi_ringkas" class="mt-2 alert alert-danger">
                  {{ validation.isi_ringkas[0] }}
              </div>
            </div>
            <CRow class="mb-3">
              <CFormLabel for="fileSurat" class="col-sm-2 col-form-label">
                File Surat
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="fileSurat" type="file" @change="handleFileUpload"/>
                <div v-if="validation.file_surat" class="mt-2 alert alert-danger">
                  {{ validation.file_surat[0] }}
                </div>
              </div>
            </CRow>

            <CRow class="mb-3">
              <div class="col-sm-10 offset-sm-2">
                <CButton color="danger" @click="cancel">Cancel</CButton>
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
import { reactive, ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import axios from "axios";
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export default {
  setup() {
    const post = reactive({
      no_surat: "",
      tanggal_keluar: "",
      tertuju_kepada: "",
      tempat_agenda: "",
      tanggal_agenda: "",
      perihal: "",
      isi_ringkas: "",
      perihal_lainnya: "",
      file_surat: null
    });

    const validation = ref({});
    const router = useRouter();
    const route = useRoute();
    const toast = useToast();
    const kategoriPerihalList = ref([]);

    const loadKategoriPerihal = async () => {
      try {
        const response = await axios.get('/api/kategoriperihal');
        kategoriPerihalList.value = response.data;
      } catch (error) {
        console.error('Error loading kategori perihal:', error);
        alert("Gagal memuat data kategori perihal. Silakan coba lagi nanti.");
      }
    };

    const loadSuratKeluar = async () => {
      try {
        const response = await axios.get(`/api/suratkeluar/${route.params.id}`);
        post.no_surat = response.data.no_surat;
        post.tanggal_keluar = response.data.tanggal_keluar;
        post.tertuju_kepada = response.data.tertuju_kepada;
        post.tempat_agenda = response.data.tempat_agenda;
        post.tanggal_agenda = response.data.tanggal_agenda;
        post.isi_ringkas = response.data.isi_ringkas;
        post.perihal = response.data.perihal.includes('Lainnya') ? 'Lainnya' : response.data.perihal;
        if (post.perihal === 'Lainnya') {
          post.perihal_lainnya = response.data.perihal.replace('Lainnya: ', '');
        }
      } catch (error) {
        console.error('Error loading surat keluar:', error);
      }
    };

    onMounted(() => {
      loadKategoriPerihal();
      loadSuratKeluar();
    });

    const handleKategoriChange = () => {
      if (post.perihal !== 'Lainnya') {
        post.perihal_lainnya = '';
      }
    };

    const submitForm = async () => {
      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('no_surat', post.no_surat);
      formData.append('tanggal_keluar', post.tanggal_keluar);
      formData.append('tertuju_kepada', post.tertuju_kepada);
      formData.append('tempat_agenda', post.tempat_agenda);
      if (post.tanggal_agenda) {
        formData.append('tanggal_agenda', post.tanggal_agenda);
      } else {
        formData.append('tanggal_agenda', '');
      }
      formData.append('perihal', post.perihal === 'Lainnya' ? `Lainnya: ${post.perihal_lainnya}` : post.perihal);
      formData.append('isi_ringkas', post.isi_ringkas);

      if (post.file_surat) {
        formData.append('file_surat', post.file_surat);
      }

      try {
        await axios.post(`/api/suratkeluar/${route.params.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        router.push(`/detailsk/${route.params.id}`);
        console.log("Surat Keluar berhasil diedit");
        toast.success('Surat Keluar berhasil diedit')
      } catch (error) {
        if (error.response && error.response.status === 422) {
          validation.value = error.response.data.errors;
          toast.error('Terjadi kesalahan pada server. Silakan coba lagi nanti', { duration: 5000 });
        } else {
          console.error('Error updating surat keluar:', error);
          toast.error('Terjadi kesalahan. Silakan coba lagi nanti', { duration: 5000 });
        }
      }
    };

    const handleFileUpload = (event) => {
      if (event.target.files.length > 0) {
        post.file_surat = event.target.files[0];
      } else {
        post.file_surat = null;
      }
    };

    const cancel = () => {
      router.push(`/detailsk/${route.params.id}`);
    };

    return {
      post,
      validation,
      kategoriPerihalList,
      submitForm,
      handleFileUpload,
      handleKategoriChange,
      cancel
    };
  },
};
</script>