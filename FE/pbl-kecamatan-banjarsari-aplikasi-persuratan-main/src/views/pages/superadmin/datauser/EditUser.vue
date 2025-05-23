<template>
  <CRow>
    <CCol :xs="12">
      <CCard class="mb-4">
        <CCardHeader style="background-color: #003083; color: white;">
          <strong>EDIT DATA USER</strong>
        </CCardHeader>
        <CCardBody>

          <CForm @submit.prevent="submitForm">
            <CRow class="mb-3">
              <CFormLabel for="username" class="col-sm-2 col-form-label">
                Username
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="username" v-model="username" type="text" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="password" class="col-sm-2 col-form-label">
                Password
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="password" v-model="password" type="password" />
              </div>
            </CRow>
            <CRow class="mb-3">
              <CFormLabel for="confirmPassword" class="col-sm-2 col-form-label">
                Konfirmasi Password
              </CFormLabel>
              <div class="col-sm-10">
                <CFormInput id="confirmPassword" v-model="confirmPassword" type="password" />
              </div>
            </CRow>
          </CForm>

          <CRow class="mb-3">
            <div class="col-sm-10 offset-sm-2">
              <CButton color="danger" @click="$router.push('/datauser')">Cancel</CButton>
              <CButton color="primary" class="ms-2" @click="submitForm">Submit</CButton>
            </div>
          </CRow>

        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
</template>

<script>
import { ref, onMounted } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';

export default {
  setup() {

    const toast = useToast();
    const username = ref("");
    const password = ref("");
    const confirmPassword = ref("");
    const router = useRouter();

    const userId = router.currentRoute.value.params.id;

    onMounted(() => {
      axios
        .get(`/api/users/${userId}`)
        .then((response) => {
          const userData = response.data;
          username.value = userData.username;
        })
        .catch((error) => {
          console.error(error);
        });
    });

    function submitForm() {
      if (password.value !== confirmPassword.value) {
        toast.error('Password dan Konfirmasi Password tidak cocok', { duration: 5000 });
        return;
      }

      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('username', username.value);
      if (password.value) {
        formData.append('password', password.value);
      }

      axios
        .post(`/api/users/${userId}`, formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
        .then(() => {
          router.push({
            name: "Data User",
          });
          console.log("Data User berhasil diedit");
          toast.success('Data User berhasil diedit', { duration: 5000 });
        })
        .catch((error) => {
          console.error(error);
          toast.error('Cek lagi inputan anda', { duration: 5000 });
        });
    }

    return {
      username,
      password,
      confirmPassword,
      submitForm,
      userId
    };
  },
};
</script>
