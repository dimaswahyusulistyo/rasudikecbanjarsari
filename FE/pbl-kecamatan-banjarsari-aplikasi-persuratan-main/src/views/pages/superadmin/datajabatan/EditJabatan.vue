<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader style="background-color: #003083; color: white;">
          <strong>EDIT DATA JABATAN</strong>
        </CCardHeader>
        <CCardBody>
          <CForm @submit.prevent="submitForm">
            <CRow class="mb-3">
              <CFormLabel for="jabatan" class="col-sm-2 col-form-label">Jabatan</CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="jabatan" v-model="post.nama_jabatan" type="text" />
                <div v-if="validation.nama_jabatan" class="mt-2 alert alert-danger">
                  {{ validation.nama_jabatan[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="tier" class="col-sm-2 col-form-label">Tier</CFormLabel>
              <div class="col-sm-10">
                <CFormSelect v-model="post.id_tier" id="tier">
                  <option value="">Pilih Tier</option>
                  <option v-for="tier in tiers" :key="tier.id_tier" :value="tier.id_tier">{{ tier.tier_name }}</option>
                </CFormSelect>
                <div v-if="validation.id_tier" class="mt-2 alert alert-danger">
                  {{ validation.id_tier[0] }}
                </div>
              </div>
            </CRow>
            <CRow class="mb-3">
              <div class="col-sm-10 offset-sm-2">
                <CButton color="danger" @click="$router.push('/datajabatan')">Cancel</CButton>
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
      nama_jabatan: "",
      id_tier: null,
    });

    const toast = useToast();
    const validation = ref({});
    const tiers = ref([]);
    const router = useRouter();
    const route = useRoute();

    onMounted(() => {
      axios
        .get(`/api/jabatan/${route.params.id}`)
        .then((response) => {
          post.nama_jabatan = response.data.nama_jabatan;
          post.id_tier = response.data.id_tier;
        })
        .catch((error) => {
          console.log(error.response.data);
        });

      axios
        .get(`/api/tiers`)
        .then((response) => {
          tiers.value = response.data.data;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });

    function submitForm() {
      axios
        .put(`/api/jabatan/${route.params.id}`, {
          nama_jabatan: post.nama_jabatan,
          id_tier: post.id_tier,
        })
        .then(() => {
          router.push({
            name: "Data Jabatan",
          });
          toast.success('Data Jabatan berhasil diedit', { duration: 5000 });
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
    return {
      post,
      validation,
      tiers,
      router,
      submitForm,
    };
  },
};
</script>
