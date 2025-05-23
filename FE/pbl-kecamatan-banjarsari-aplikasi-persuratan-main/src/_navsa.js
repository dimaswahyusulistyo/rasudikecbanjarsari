export default [
  {
    component: 'CNavItem',
    name: 'Beranda',
    to: '/dashboardsa',
    icon: 'cilHome',
    badge: {
      color: 'primary',
      // text: 'NEW',
    },
  },
  {
    component: 'CNavTitle',
    name: 'Aktivitas',
  },
  {
    component: 'CNavItem',
    name: 'Surat Masuk',
    to: '/suratmasuk',
    icon: 'cilEnvelopeOpen',
  },
  {
    component: 'CNavItem',
    name: 'Surat Keluar',
    to: '/suratkeluar',
    icon: 'cilEnvelopeClosed',
  },
  {
    component: 'CNavItem',
    name: 'Arsip Surat',
    to: '/arsipsurat',
    icon: 'cilFolderOpen',
  },
  {
    component: 'CNavItem',
    name: 'Data Pegawai',
    to: '/datapegawai',
    icon: 'cibSlideshare',
  },

  {
    component: 'CNavItem',
    name: 'Data Jabatan',
    to: '/datajabatan',
    icon: 'cilSitemap',
  },
  {
    component: 'CNavItem',
    name: 'Pangkat',
    to: '/datapangkat',
    icon: 'cibMyspace',
  },
  // {
  //   component: 'CNavItem',
  //   name: 'Hak Akses',
  //   to: '/hakakses',
  //   icon: 'cibOpenAccess',
  // },
  {
    component: 'CNavItem',
    name: 'Daftar User',
    to: '/datauser',
    icon: 'cilUserPlus',
  },
]
