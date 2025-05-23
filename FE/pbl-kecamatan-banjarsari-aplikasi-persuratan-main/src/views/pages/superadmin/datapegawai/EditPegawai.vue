<template>
    <CRow>
      <CCol :xs="12">
        <CCard class="mb-4">
          <CCardHeader style="background-color: #003083; color: white;">
            <strong>EDIT DATA PEGAWAI</strong>
          </CCardHeader>
          <CCardBody>
            <CForm>
              <CRow class="mb-3">
                <CFormLabel for="nama_pegawai" class="col-sm-2 col-form-label">
                  Nama
                </CFormLabel>
                <div class="col-sm-10">
                  <CFormInput id="nama_pegawai" v-model="post.nama_pegawai" type="text" />
                  <div v-if="validation.nama_pegawai" class="mt-2 alert alert-danger">
                    {{ validation.nama_pegawai[0] }}
                  </div>
                </div>
              </CRow>
              <CRow class="mb-3">
                <CFormLabel for="email" class="col-sm-2 col-form-label">
                  Email
                </CFormLabel>
                <div class="col-sm-10">
                  <CFormInput id="email" v-model="post.email" type="text" />
                  <div v-if="validation.email" class="mt-2 alert alert-danger">
                    {{ validation.email[0] }}
                  </div>
                </div>
              </CRow>
              <CRow class="mb-3">
                <CFormLabel for="nip" class="col-sm-2 col-form-label">
                  NIP/NIK
                </CFormLabel>
                <div class="col-sm-10">
                  <CFormInput id="nip" v-model="post.nip"  type="text" />
                  <div v-if="validation.nip" class="mt-2 alert alert-danger">
                    {{ validation.nip[0] }}
                  </div>
                </div>
              </CRow>
              <CRow class="mb-3">
                <CFormLabel for="id_jabatan" class="col-sm-2 col-form-label">
                  Jabatan
                </CFormLabel>
                <div class="col-sm-10">
                  <CFormSelect id="id_jabatan" v-model="post.id_jabatan">
                    <option value="">Pilih Jabatan</option>
                    <option v-for="jabatan in listJabatan" :key="jabatan.id_jabatan" :value="jabatan.id_jabatan">{{ jabatan.nama_jabatan }}</option>
                  </CFormSelect>
                  <div v-if="validation.id_jabatan" class="mt-2 alert alert-danger">
                    {{ validation.id_jabatan[0] }}
                  </div>
                </div>
              </CRow>
              <CRow class="mb-3">
              <CFormLabel for="file_foto" class="col-sm-2 col-form-label">
                File Foto
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="file_foto" type="file" @change="handleFileUpload"/>
                <div v-if="validation.file_foto" class="mt-2 alert alert-danger">
                  {{ validation.file_foto[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <div class="col-sm-10 offset-sm-2">
                <CButton color="danger" @click="$router.push('/datapegawai')">Cancel</CButton>
                <CButton color="primary" class="ms-2" @click="submitForm">Submit</CButton>
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
import { useRouter } from "vue-router";
import axios from "axios";
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export default {
  setup() {
    const post = reactive({
      nama_pegawai: "",
      email: "",
      nip: "",
      id_jabatan: "",
      file_foto: null 
    });

    const validation = ref({});
    const router = useRouter();
    const toast = useToast();

    onMounted(() => {
      axios
        .get(`/api/pegawai/${router.currentRoute.value.params.id}`)
        .then((response) => {
          post.nama_pegawai = response.data.nama_pegawai;
          post.email = response.data.email;
          post.nip = response.data.nip;
          post.id_jabatan = response.data.id_jabatan;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });

    const listJabatan = ref([]);

    const loadListJabatan = async () => {
      try {
        const response = await axios.get('/api/jabatan?paginate=false');
        listJabatan.value = response.data; 
      } catch (error) {
        console.error('Error loading list jabatan:', error);
      }
    };

    function submitForm() {
      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('nama_pegawai', post.nama_pegawai);
      formData.append('email', post.email);
      formData.append('nip', post.nip);
      formData.append('id_jabatan', post.id_jabatan);

      if (post.file_foto) {
        formData.append('file_foto', post.file_foto);
      }

      axios
        .post(`/api/pegawai/${router.currentRoute.value.params.id}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(() => {
          router.push({
            name: "Data Pegawai",
          });
          console.log("Data Pegawai berhasil diedit");
          toast.success('Data Pegawai berhasil diedit', { duration: 5000 });
        })
        .catch((error) => {
          if (error.response && error.response.status === 422) {
            validation.value = error.response.data.errors;
            toast.error('Terjadi kesalahan pada server. Silakan coba lagi nanti', { duration: 5000 });
          } else {
            console.error(error);
            toast.error('Terjadi kesalahan. Silakan coba lagi nanti', { duration: 5000 });
          }
        });
    }

    function handleFileUpload(event) {
      if (event.target.files.length > 0) {
        post.file_foto = event.target.files[0];
      } else {
        post.file_foto = null;
      }
    }

    onMounted(() => {
      loadListJabatan();
    });

    return {
      post,
      validation,
      router,
      submitForm,
      handleFileUpload,
      listJabatan
    };
  },
};
</script>
