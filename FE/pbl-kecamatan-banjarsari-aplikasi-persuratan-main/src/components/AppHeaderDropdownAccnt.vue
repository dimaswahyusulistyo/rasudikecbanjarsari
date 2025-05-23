<template>
  <CDropdown placement="bottom-end" variant="nav-item">
    <CDropdownToggle class="py-0 pe-0" :caret="false">
      <img :src="profileImageUrl" alt="Profile Picture" class="img-fluid" style="width: 3.2rem; height: 3.2rem; border-radius: 50%;" />
    </CDropdownToggle>
    <CDropdownMenu class="pt-0">
      <CDropdownHeader
        component="h6"
        class="bg-body-secondary text-body-secondary fw-semibold mb-2 rounded-top"
      >
        Account
      </CDropdownHeader>
      <CDropdownItem @click="$router.push('/profile')">
        <CIcon icon="cilUser"/> Profile
      </CDropdownItem>
      <CDropdownItem @click="logout">
        <CIcon icon="cilLockLocked" /> Logout
      </CDropdownItem>
    </CDropdownMenu>
  </CDropdown>
</template>

<script>
import { ref, onMounted, computed } from 'vue'
import avatar from '@/assets/images/avatars/8.jpg'
import axios from 'axios';
import { useRouter } from 'vue-router';
import { ASSET_BASE_URL } from '@/config'

export default {
  name: 'AppHeaderDropdownAccnt',
  setup() {
    const router = useRouter();
    const user = ref(null);

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
    };

    const profileImageUrl = computed(() => {
      return user.value?.pegawai?.file_foto
      ? `${ASSET_BASE_URL}foto_pegawai/${user.value.pegawai.file_foto}`
        : ''
    })

    const logout = async () => {
      try {
        await axios.get('/api/logout', {
          headers: { Authorization: 'Bearer ' + localStorage.getItem('token') }
        });
        handleLogout();
      } catch (error) {
        console.error('Failed to logout:', error);
      }
    };

    const handleLogout = () => {
      localStorage.removeItem('token');
      localStorage.removeItem('role');
      router.push('/login');
    };

    onMounted(() => {
      fetchData()
    })

    return {
      
      avatar,
      itemsCount: 42,
      logout,
      handleLogout,
      fetchData,
      user,
      profileImageUrl
    }
  },
}
</script>
