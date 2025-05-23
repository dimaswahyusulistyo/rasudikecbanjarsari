<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader style="background-color: #003083; color: white;">
          <strong>EDIT SURAT MASUK</strong>
        </CCardHeader>
        <CCardBody v-if="dataLoaded">
          <CForm @submit.prevent="submitForm">
            <CRow class="mb-3">
              <CFormLabel for="pengirim" class="col-sm-2 col-form-label"> Pengirim </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="pengirim" v-model="post.pengirim" type="text" />
                <div v-if="validation.pengirim" class="mt-2 alert alert-danger">
                  {{ validation.pengirim[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tanggalDiterima" class="col-sm-2 col-form-label">
                Tanggal Surat
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput
                  id="tanggalDiterima"
                  v-model="post.tanggal_diterima"
                  type="date"
                />
                <div v-if="validation.tanggal_diterima" class="mt-2 alert alert-danger">
                  {{ validation.tanggal_diterima[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="noSurat" class="col-sm-2 col-form-label"> Nomor Surat </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="noSurat" v-model="post.no_surat" type="text" />
                <div v-if="validation.no_surat" class="mt-2 alert alert-danger">
                  {{ validation.no_surat[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tanggalAgenda" class="col-sm-2 col-form-label">
                Waktu Agenda
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput
                  id="tanggalAgenda"
                  v-model="post.tanggal_agenda"
                  type="datetime-local"
                  :required="false"
                />
                <div v-if="validation.tanggal_agenda" class="mt-2 alert alert-danger">
                  {{ validation.tanggal_agenda[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tempatAgenda" class="col-sm-2 col-form-label"> Tempat Agenda </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="tempatAgenda" v-model="post.tempat_agenda" type="text" />
                <div v-if="validation.tempat_agenda" class="mt-2 alert alert-danger">
                  {{ validation.tempat_agenda[0] }}
                </div>
              </div>
            </CRow>

            <CRow class="mb-3">
              <CFormLabel for="kode" class="col-sm-2 col-form-label"> Kode </CFormLabel>
              <div class="col-sm-10">
              <CFormInput id="kode" v-model="post.kode" type="text" />
                <div v-if="validation.kode" class="mt-2 alert alert-danger">
                  {{ validation.kode[0] }}
                </div>  
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="sifat_surat_edit" class="col-sm-2 col-form-label"> Sifat </CFormLabel>
              <div class="col-sm-10">
                <CFormSelect id="sifat_surat_edit" v-model="post.sifat_surat">
                  <option value="">Pilih Kategori Sifat</option>
                  <option value="Penting">Penting</option>
                  <option value="Segera">Segera</option>
                  <option value="Amat Segera">Amat Segera</option>
                  <option value="Biasa">Biasa</option>
                </CFormSelect>
                <div v-if="validation.sifat_surat" class="mt-2 alert alert-danger">
                  {{ validation.sifat_surat[0] }}
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
              <CFormLabel for="fileSurat" class="col-sm-2 col-form-label"> File Surat </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="fileSurat" type="file" @change="handleFileUpload" />
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
        <CCardBody v-else>
          <CSpinner color="primary" />
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import { reactive, ref, onMounted } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import axios from 'axios';
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export default {
  setup() {
    const post = reactive({
      no_surat: '',
      tanggal_diterima: '',
      tanggal_agenda: '',
      tempat_agenda: '',
      pengirim: '',
      perihal: '',
      perihal_lainnya: '',
      isi_ringkas: '',
      kode: '',
      sifat_surat: '',
      file_surat: null,
    });

    const validation = ref({});
    const router = useRouter();
    const route = useRoute();
    const dataLoaded = ref(false);
    const toast = useToast();

    onMounted(async () => {
      try {
        const response = await axios.get(`/api/suratmasuk/${route.params.id}`);
        post.no_surat = response.data.no_surat;
        post.tanggal_diterima = response.data.tanggal_diterima;
        post.tanggal_agenda = response.data.tanggal_agenda;
        post.tempat_agenda = response.data.tempat_agenda;
        post.pengirim = response.data.pengirim;
        post.kode = response.data.kode;
        post.sifat_surat = response.data.sifat_surat;
        post.perihal = response.data.perihal.includes('Lainnya') ? 'Lainnya' : response.data.perihal;
        if (post.perihal === 'Lainnya') {
          post.perihal_lainnya = response.data.perihal.replace('Lainnya: ', '');
        }
        post.isi_ringkas = response.data.isi_ringkas;
        dataLoaded.value = true;
      } catch (error) {
        console.error(error.response.data);
      }
    });

    const kategoriPerihalList = ref([]);

    const loadKategoriPerihal = async () => {
      try {
        const response = await axios.get('/api/kategoriperihal');
        kategoriPerihalList.value = response.data;
      } catch (error) {
        console.error('Error loading kategori perihal:', error);
      }
    };

    const submitForm = async () => {
      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('no_surat', post.no_surat);
      formData.append('tanggal_diterima', post.tanggal_diterima);
      if (post.tanggal_agenda) {
        formData.append('tanggal_agenda', post.tanggal_agenda);
      } else {
        formData.append('tanggal_agenda', '');
      }
      formData.append('tempat_agenda', post.tempat_agenda);
      formData.append('pengirim', post.pengirim);
      formData.append('perihal', post.perihal === 'Lainnya' ? `Lainnya: ${post.perihal_lainnya}` : post.perihal);
      formData.append('isi_ringkas', post.isi_ringkas);
      if (post.kode) {
        formData.append('kode', post.kode);
      }
      if (post.sifat_surat) {
        formData.append('sifat_surat', post.sifat_surat);
      }
      if (post.file_surat) {
        formData.append('file_surat', post.file_surat);
      }

      try {
        await axios.post(`/api/suratmasuk/${router.currentRoute.value.params.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        });
        router.push(`/detailsm/${route.params.id}`);
        toast.success('Surat Masuk berhasil diedit', { duration: 5000 });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          validation.value = error.response.data.errors;
          toast.error('Terjadi kesalahan pada server. Silakan coba lagi nanti', { duration: 5000 });
        } else {
          console.error(error);
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
      const id = router.currentRoute.value.params.id;
      router.push(`/detailsm/${id}`);
    };

    const handleKategoriChange = () => {
      if (post.perihal !== 'Lainnya') {
        post.perihal_lainnya = '';
      }
    };

    onMounted(() => {
      loadKategoriPerihal();
    });

    return {
      post,
      validation,
      router,
      submitForm,
      handleFileUpload,
      kategoriPerihalList,
      cancel,
      handleKategoriChange,
      dataLoaded
    };
  }
};
</script>
