<template>
  <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center justify-content-center">
    <CCard class="text-white bg-primary py-5 w-100" style="max-width: 600px">
      <CCardBody class="text-center">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-10 mt-3 mb-4 d-flex justify-content-center">
              <img src="@/assets/images/logo-footer.png" alt="Logo" class="img-fluid">
            </div>
          </div>
        </div>

        <CCard class="p-4">
          <CCardBody>
            <CForm>
              <h1>Login</h1>
              <p class="text-body-secondary">Sign In to your account</p>
              <CInputGroup class="mb-3">
                <CInputGroupText>
                  <CIcon icon="cil-user"/>
                </CInputGroupText>
                <CFormInput placeholder="Username" autocomplete="username" v-model="username"/>
              </CInputGroup>
              <CInputGroup class="mb-4">
                <CInputGroupText>
                  <CIcon icon="cil-lock-locked"/>
                </CInputGroupText>
                <CFormInput type="password" placeholder="Password" autocomplete="current-password" v-model="password"/>
              </CInputGroup>
              <div v-if="errorMessage" class="alert alert-danger" role="alert">
                {{ errorMessage }}
              </div>
              <CRow class="justify-content-center">
                <CCol class="text-center">
                  <CButton v-if="!isLoggedIn" color="primary" class="px-4" @click="login">Login</CButton>
                  <CButton v-else color="primary" class="px-4" @click="logout">Logout</CButton>
                </CCol>
              </CRow>
            </CForm>
          </CCardBody>
        </CCard>
      </CCardBody>
    </CCard>
  </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  data() {
    return {
      username: '',
      password: '',
      isLoggedIn: false,
      errorMessage: ''
    };
  },
  created() {
    this.checkTokenValidity();
  },
  methods: {
    async checkTokenValidity() {
      const token = localStorage.getItem('token');
      if (token) {
        try {
          await axios.get('/api/validate-token', {
            headers: { Authorization: 'Bearer ' + token }
          });
          this.isLoggedIn = true;
        } catch (error) {
          this.handleLogout();
        }
      }
    },
    async login() {
      try {
        const response = await axios.post('/api/login', {
          username: this.username,
          password: this.password
        });

        localStorage.setItem('token', response.data.token);
        localStorage.setItem('role', response.data.user.role);
        
        this.isLoggedIn = true;
        this.errorMessage = '';

        const userRole = response.data.user.role;
        if (userRole === 'superadmin') {
          this.$router.push('/dashboardsa');
        } else if (userRole === 'admin') {
          this.$router.push('/dashboard');
        } else if (userRole === 'camat') {
          this.$router.push('/dashboardcmt');
        } else {
          this.errorMessage = 'Invalid user role';
          this.isLoggedIn = false;
        }
      } catch (error) {
        this.errorMessage = 'Login failed. Please try again.';
      }
    },
    async logout() {
      try {
        await axios.get('/api/logout', {
          headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
        });
        this.handleLogout();
      } catch (error) {
        this.errorMessage = 'Failed to logout'; 
      }
    },
    handleLogout() {
      localStorage.removeItem('token');
      localStorage.removeItem('role');
      this.isLoggedIn = false;
      this.$router.push('/login');
    }
  },
  watch: {
    isLoggedIn(val) {
      if (!val) {
        this.username = '';
        this.password = '';
      }
    }
  }
};
</script>

<style scoped>
.img-fluid {
  max-width: 100%;
  height: auto;
}
</style>