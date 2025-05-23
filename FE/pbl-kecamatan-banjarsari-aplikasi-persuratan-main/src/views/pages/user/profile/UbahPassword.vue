<template>
    <CRow class="justify-content-center align-items-center" style="height: 100vh;">
        <CCol :xs="12" :md="8">
            <CCard class="mb-4">
                <CCardHeader>
                    <strong>UBAH PASSWORD</strong>
                </CCardHeader>
                <CCardBody>

                    <CForm @submit.prevent="changePassword">
                        <CRow class="mb-3 align-items-center">
                            <CFormLabel for="oldPassword" class="col-sm-2 col-form-label">
                                Password Lama
                            </CFormLabel>
                            <div class="col-sm-10">
                                <CFormInput id="oldPassword" v-model="oldPassword" type="password" />
                            </div>
                        </CRow>
                        <CRow class="mb-3 align-items-center">
                            <CFormLabel for="password" class="col-sm-2 col-form-label">
                                Password Baru
                            </CFormLabel>
                            <div class="col-sm-10">
                                <CFormInput id="password" v-model="password" type="password" />
                            </div>
                        </CRow>
                        <CRow class="mb-3 align-items-center">
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
                            <CButton color="danger" @click="$router.push('/profile')">Cancel</CButton>
                            <CButton color="primary" class="ms-2" @click="changePassword">Submit</CButton>
                        </div>
                    </CRow>

                </CCardBody>
            </CCard>
        </CCol>
    </CRow>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import router from '@/router'

export default {
  setup() {
    const user = ref(null);
    const oldPassword = ref('');
    const password = ref('');
    const confirmPassword = ref('');

    const fetchData = () => {
      const token = localStorage.getItem('token')
      axios
        .get('/api/user', {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          if (response && response.data && response.data.user) {
            user.value = response.data.user
          } else {
            console.error('Invalid response structure:', response)
          }
        })
        .catch((error) => {
          console.error('Error fetching data:', error)
          if (error.response && error.response.status === 401) {
            router.push('/login')
          }
        })
    }

    const changePassword = () => {
    const formData = new FormData();
    formData.append('_method', 'PUT');
    if (password.value) {
        formData.append('password', password.value);
    }

    const token = localStorage.getItem('token');
    const userId = user.value.id; 

    if (password.value !== confirmPassword.value) {
        alert("Pastikan Password Baru dan Password Konfirmasi Sudah Sama!");
        console.error('New password and confirm password do not match');
        return;
    }

    axios
        .post(`/api/users/${userId}`, formData, {
            headers: {
                Authorization: `Bearer ${token}`,
                'Content-Type': 'multipart/form-data',
            },
        })
        .then((response) => {
            alert("Password Berhasil Diubah!");
            console.log('Password changed successfully');
            router.push('/profile');
            
        })
        .catch((error) => {
            alert("Terjadi Kesalahan Saat Mengubah Password");
            console.error('Error changing password:', error);
        });
};


    onMounted(fetchData);

    return {
    oldPassword,
    password,
    confirmPassword,
    changePassword,
    }
}
}
</script>
