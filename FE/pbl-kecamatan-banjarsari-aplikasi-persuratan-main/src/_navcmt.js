export default [
  {
    component: 'CNavItem',
    name: 'Beranda',
    to: '/dashboardcmt',
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
    name: 'Disposisi',
    to: '/disposisi',
    icon: 'cilPeople',
  },
]
