<template>
    <CRow>
      <CCol :xs="12">
        <CCard class="mb-4">
          <CCardHeader style="background-color: #003083; color: white;">
            <strong>EDIT DATA PANGKAT</strong>
          </CCardHeader>
          <CCardBody>
  
            <CForm @submit.prevent="submitForm">
              <CRow class="mb-3">
                <CFormLabel for="jabatan" class="col-sm-2 col-form-label">
                  Jabatan
                </CFormLabel>
                <div class="col-sm-10">
                <CFormInput id="jabatan" v-model="post.nama_jabatan" type="text" />
                <div v-if="validation.nama_jabatan" class="mt-2 alert alert-danger">
                  {{ validation.nama_jabatan[0] }}
                </div>
              </div>
              </CRow>
              
              <CRow class="mb-3">
                <CFormLabel for="tier" class="col-sm-2 col-form-label">
                  Tier
                </CFormLabel>
                <div class="col-sm-10">
                <CFormInput id="tier" v-model="post.nama_tier" type="text" />
                <div v-if="validation.nama_tier" class="mt-2 alert alert-danger">
                  {{ validation.nama_tier[0] }}
                </div>
              </div>
              </CRow>
              <CRow class="mb-3">
              <div class="col-sm-10 offset-sm-2">
                <CButton color="danger" @click="$router.push('/datapangkat')">Cancel</CButton>
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
import { useRouter, useRoute } from "vue-router";
import axios from "axios";

export default {
    setup() {
        const post = reactive({
            nama_jabatan: "",
        });
        const validation = ref({});
        const router = useRouter();
        const route = useRoute();
        onMounted(() => {
            axios
                .get(`/api/jabatan/${route.params.id}`)
                .then((response) => {
                    post.nama_jabatan = response.data.nama_jabatan;
                })
                .catch((error) => {
                    console.log(error.response.data);
                });
        });

        function submitForm() {
            let nama_jabatan = post.nama_jabatan;

            axios
                .put(`/api/jabatan/${route.params.id}`, {
                    nama_jabatan: nama_jabatan,
                })
                .then(() => {
                    router.push({
                        name: "Data Pangkat",
                    });
                    alert("Data Pangkat berhasil diupdate");
                    console.log("Data Pangkat Berhasil Di Update");
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        validation.value = error.response.data.errors;
                    } else {
                        console.error(error);
                    }
                });
        }

        return {
            post,
            validation,
            router,
            submitForm,
        };
    },
};
</script>
