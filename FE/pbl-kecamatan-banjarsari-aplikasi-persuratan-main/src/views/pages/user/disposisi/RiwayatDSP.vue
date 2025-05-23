<template>
  <div>
    <h5 class="mb-4">DETAIL SURAT MASUK</h5>
    <div class="container-fluid d-flex justify-content-center">
      <div class="card border mb-4 w-75">
        <CCardHeader class="d-flex justify-content-between align-items-center">
          <div>
            <ul class="nav nav-underline-border" role="navigation">
              <li class="nav-item">
                <!-- <a class="nav-link" target="_blank" @click="$router.push('/detailsm')"> -->
                  <svg
                    class="icon me-2 me-2"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    role="img"
                  >
                    <CIcon icon="cilInfo" />
                  </svg>
                  Detail Surat
                <!-- </a> -->
              </li>
              <li class="nav-item">
                <a class="active nav-link" aria-current="page" href="#">
                  <svg
                    class="icon me-2 me-2"
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"
                    role="img"
                  >
                    <CIcon icon="cilHistory" />
                  </svg>
                  Riwayat Disposisi
                </a>
              </li>
            </ul>
          </div>
          <div class="d-flex align-items-center">
            <!-- <CButton
              color="success"
              class="me-3"
              style="color: white"
              @click="$router.push('/ubahdsp')"
            >
              <CIcon icon="cil-plus" class="me-1" style="color: white" />
              Ubah Disposisi
            </CButton> -->
            <h4>DSP010114</h4>
          </div>
        </CCardHeader>

        <CCardBody>
          <CTable align="middle" class="mb-0 border" hover="hover" responsive="responsive">
            <CTableHead class="text-nowrap">
              <CTableRow>
                <CTableHeaderCell class="bg-body-secondary text-center"></CTableHeaderCell>
                <CTableHeaderCell class="bg-body-secondary">No.</CTableHeaderCell>
                <CTableHeaderCell class="bg-body-secondary">Tanggal & Waktu</CTableHeaderCell>
                <CTableHeaderCell class="bg-body-secondary">Dari</CTableHeaderCell>
                <CTableHeaderCell class="bg-body-secondary">Tertuju Ke</CTableHeaderCell>
                <CTableHeaderCell class="bg-body-secondary">Perihal</CTableHeaderCell>
              </CTableRow>
            </CTableHead>
            <CTableBody>
              <CTableRow>
                <CTableDataCell class="text-center"></CTableDataCell>
                <CTableDataCell>1.</CTableDataCell>
                <CTableDataCell>01/01/2024 - 12:00</CTableDataCell>
                <CTableDataCell>Camat</CTableDataCell>
                <CTableDataCell>Sekretaris Camat</CTableDataCell>
                <CTableDataCell>Undangan</CTableDataCell>
              </CTableRow>
            </CTableBody>
          </CTable>
        </CCardBody>
      </div>
    </div>
  </div>
</template>
