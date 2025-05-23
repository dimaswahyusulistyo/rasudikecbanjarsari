import { h, resolveComponent } from 'vue'
import { createRouter, createWebHashHistory } from 'vue-router'
import { roleGuard } from './middleware'
import DynamicRouter from '@/layouts/DynamicRouter'
import LandingLayout from '@/layouts/LandingLayout'
import CamatLayout from '@/layouts/CamatLayout'

const routes = [
  {
    path: '/',
    name: 'Landingpage',
    redirect: '/landingpage',
    component: LandingLayout,
    children: [
      {
        path: '',
        name: 'Landing Page',
        component: () => import('@/views/pages/LandingPage.vue'),
      },
      {
        path: 'login',
        name: 'Login',
        component: () => import('@/views/pages/Login'),
      },
    ],
  },
  // ---------------------------------- ADMIN ---------------------------------- //
  {
    path: '/',
    name: 'Home',
    component: DynamicRouter,
    redirect: '/dashboard',
    children: [
      {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('@/views/dashboard/Dashboard.vue'),
        beforeEnter: roleGuard(['admin']),
      },
      {
        path: '/disposisi',
        name: 'Disposisi Saya',
        component: () => import('@/views/pages/user/disposisi/Disposisi.vue'),
        beforeEnter: roleGuard(['superadmin', 'admin', 'camat']),
      },
      {
        path: '/detaildsp/:id',
        name: 'Detail Disposisi',
        component: () => import('@/views/pages/user/disposisi/DetailDSP.vue'),
        beforeEnter: roleGuard(['superadmin', 'admin', 'camat']),
      },
      {
        path: '/riwayatdsp',
        name: 'Riwayat Disposisi',
        component: () => import('@/views/pages/user/disposisi/RiwayatDSP.vue'),
        beforeEnter: roleGuard(['superadmin', 'admin', 'camat']),
      },
      {
        path: '/ubahdsp/:id/:suratId',
        name: 'Ubah Disposisi',
        component: () => import('@/views/pages/user/disposisi/UbahDSP.vue'),
        beforeEnter: roleGuard(['superadmin', 'admin', 'camat']),
        props: true,
      },
      {
        path: '/tambahdsp/:id',
        name: 'Tambah Disposisi',
        component: () => import('@/views/pages/user/disposisi/TambahDSP.vue'),
        beforeEnter: roleGuard(['superadmin', 'admin', 'camat']),
      },
      {
        path: '/notulensi/:id',
        name: 'Input Notulensi',
        component: () => import('@/views/pages/superadmin/notulensi/InputNotulensi.vue'),
        beforeEnter: roleGuard(['superadmin', 'admin', 'camat']),
        props: true,
      },      
      {
        path: '/theme/typography',
        name: 'Typography',
        component: () => import('@/views/theme/Typography.vue'),
      },
    ],
  },
  {
    path: '/pages',
    redirect: '/pages/404',
    name: 'Pages',
    component: {
      render() {
        return h(resolveComponent('router-view'))
      },
    },
    children: [
      {
        path: '404',
        name: 'Page404',
        component: () => import('@/views/pages/Page404'),
      },
      {
        path: '500',
        name: 'Page500',
        component: () => import('@/views/pages/Page500'),
      },
      {
        path: '/profile',
        name: 'Profile',
        component: () => import('@/views/pages/user/profile/Profile.vue'),
        beforeEnter: roleGuard(['superadmin', 'admin', 'camat']),
      },
      {
        path: '/ubahpassword/:id',
        name: 'Ubah Password',
        component: () => import('@/views/pages/user/profile/UbahPassword.vue'),
        beforeEnter: roleGuard(['superadmin', 'admin', 'camat']),
      },
    ],
  },
  // ---------------------------------- SUPER ADMIN ---------------------------------- //
  {
    path: '/',
    name: 'Super Admin',
    component: DynamicRouter,
    redirect: '/dashboardsa',
    children: [
      {
        path: '/dashboardsa',
        name: 'Dashboard Super Admin',
        component: () => import('@/views/dashboard/DashboardSA.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/suratmasuk',
        name: 'Surat Masuk',
        component: () => import('@/views/pages/superadmin/suratmasuk/SuratMasuk.vue'),
        beforeEnter: roleGuard(['superadmin', 'camat']),
      },
      {
        path: '/inputsm',
        name: 'Input Surat Masuk',
        component: () => import('@/views/pages/superadmin/suratmasuk/InputSM.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/detailsm/:id',
        name: 'Detail Surat Masuk',
        component: () => import('@/views/pages/superadmin/suratmasuk/DetailSM.vue'),
        beforeEnter: roleGuard(['superadmin', 'admin', 'camat']),
      },
      {
        path: '/editsm/:id',
        name: 'Edit Surat Masuk',
        component: () => import('@/views/pages/superadmin/suratmasuk/EditSM.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/suratkeluar',
        name: 'Surat Keluar',
        component: () => import('@/views/pages/superadmin/suratkeluar/SuratKeluar.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/inputsk',
        name: 'Input Surat Keluar',
        component: () => import('@/views/pages/superadmin/suratkeluar/InputSK.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/detailsk/:id',
        name: 'Detail Surat Keluar',
        component: () => import('@/views/pages/superadmin/suratkeluar/DetailSK.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/editsk/:id',
        name: 'Edit Surat Keluar',
        component: () => import('@/views/pages/superadmin/suratkeluar/EditSK.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/arsipsurat',
        name: 'Arsip',
        component: () => import('@/views/pages/superadmin/arsipsurat/ArsipSurat.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/detailarsip/:id',
        name: 'Detail Surat',
        component: () => import('@/views/pages/superadmin/arsipsurat/DetailArsip.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/detailarsipmasuk/:id',
        name: 'Detail Arsip Surat Masuk',
        component: () => import('@/views/pages/superadmin/arsipsurat/DetailArsipMasuk.vue'),
      },
      {
        path: '/detailarsipkeluar/:id',
        name: 'Detail Arsip Surat Keluar',
        component: () => import('@/views/pages/superadmin/arsipsurat/DetailArsipKeluar.vue'),
      },
      {
        path: '/disposisiarsip',
        name: 'Disposisi Surat',
        component: () => import('@/views/pages/superadmin/arsipsurat/DisposisiArsip.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/datapegawai',
        name: 'Data Pegawai',
        component: () => import('@/views/pages/superadmin/datapegawai/DataPegawai.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/inputpegawai',
        name: 'Input Data Pegawai',
        component: () => import('@/views/pages/superadmin/datapegawai/InputPegawai.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/editpegawai/:id',
        name: 'Edit Data Pegawai',
        component: () => import('@/views/pages/superadmin/datapegawai/EditPegawai.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/datauser',
        name: 'Data User',
        component: () => import('@/views/pages/superadmin/datauser/DataUser.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/inputuser',
        name: 'Input Data User',
        component: () => import('@/views/pages/superadmin/datauser/InputUser.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/edituser/:id',
        name: 'Edit Data User',
        component: () => import('@/views/pages/superadmin/datauser/EditUser.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/datajabatan',
        name: 'Data Jabatan',
        component: () => import('@/views/pages/superadmin/datajabatan/DataJabatan.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/inputjabatan',
        name: 'Input Data Jabatan',
        component: () => import('@/views/pages/superadmin/datajabatan/InputJabatan.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/editjabatan/:id',
        name: 'Edit Data Jabatan',
        component: () => import('@/views/pages/superadmin/datajabatan/EditJabatan.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/datapangkat',
        name: 'Data Pangkat',
        component: () => import('@/views/pages/superadmin/pangkat/DataPangkat.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/editpangkat/:id',
        name: 'Edit Pangkat',
        component: () => import('@/views/pages/superadmin/pangkat/EditPangkat.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
      {
        path: '/inputpangkat',
        name: 'Input Pangkat',
        component: () => import('@/views/pages/superadmin/pangkat/InputPangkat.vue'),
        beforeEnter: roleGuard(['superadmin']),
      },
    ],
  },
  // ---------------------------------- CAMAT ---------------------------------- //
  {
    path: '/',
    name: 'Camat',
    component: CamatLayout,
    redirect: '/dashboardcmt',
    children: [
      {
        path: '/dashboardcmt',
        name: 'Dashboard Camat',
        component: () => import('@/views/dashboard/DashboardCMT.vue'),
        beforeEnter: roleGuard(['admin', 'camat']),
      },
    ],
  },
]

const router = createRouter({
  history: createWebHashHistory(process.env.BASE_URL),
  routes,
  scrollBehavior() {
    return { top: 0 }
  },
})

export default router
