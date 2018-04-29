<script src="<?php echo base_url(); ?>/assets/js/Chart.bundle.js"></script>
<link href="<?php echo base_url(); ?>/assets/css/custom1.css" rel="stylesheet">
<section id="main-content">
  <section class="wrapper">            
    <!--overview start-->
    <div class="row">
      <div class="col-lg-12">

        <h3 class="page-header text-center" style="margin-top: 0;">Beranda</h3>
        <!-- <ol class="breadcrumb">
          <li><i class="fa fa-home"></i><a href="#">Beranda</a></li>
        </ol> -->
      </div>
    </div>
    
    <div class="row">
     <div class="col-lg-12">
      <section class="panel">
                      <!-- <header class="panel-heading">
                          <h3> </Char>
                          </header> -->
                          <div class="panel-body">
                            <div class="tab-pane" id="chartjs">
                              <div class="row">
                                <div class="col-lg-6">
                                  <section class="panel">
                                    <header class="panel-heading">
                                      Grafik Jumlah Pelamar berdasarkan jenis kelamin
                                    </header>
                                    <div class="panel-body text-center">
                                      <canvas id="grafik1" width="300" height="200"></canvas>
                                    </div>
                                  </section>
                                </div>  
                                <div class="col-lg-6">
                                  <section class="panel">
                                    <header class="panel-heading">
                                      Grafik Jumlah Pelamar berdasarkan Bidang yang dilamar
                                    </header>
                                    <div class="panel-body text-center">
                                      <canvas id="grafik2" height="200" width="300"></canvas>
                                    </div>
                                  </section>
                                </div>
                                <div class="col-lg-12">
                                  <section class="panel">
                                    <header class="panel-heading">
                                      Grafik Jumlah pengguna berdasarkan Tingkatan Pendidikan
                                    </header>
                                    <div class="panel-body text-center">
                                      <canvas id="grafik3" height="300" width="600"></canvas>
                                    </div>
                                  </section>
                                </div> 
                              </div>
                            </div>
                          </div> 
                        </section>
                      </div>

                    </div>
                    <!-- project team & activity end -->

                  </section>
                  <div class="text-center">
                    <div class="credits">
                      <a href="https://bootstrapmade.com/free-business-bootstrap-themes-website-templates/">Business Bootstrap Themes</a> by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                    </div>
                  </div>
                </section>

                <?php

                $cewRow = '15';
                $cowRow ='10';
                $saRow = '17';
                $feRow = '19';
                $beRow = '34';
                $smaRow = '56';
                $dipRow = '78';
                $sarRow = '13';
                $magRow = '66';






                ?>

                <script>
                  var ctx = document.getElementById("grafik1");
                  var myChart = new Chart(ctx, {
                    type: 'pie',
                    data: {
                      labels: ["Perempuan", "Laki-laki"],
                      datasets: [{
                        label: 'Jumlah layanan',
                        data: [<?php echo $cewRow?>, <?php echo $cowRow?>],
                        backgroundColor: [
                                // 'rgba(255, 206, 86, 1)', //kuning
                                'rgba(54, 162, 235, 1)', //biru
                                // 'rgba(255, 99, 132, 0.2)', //pink
                                // 'rgba(75, 192, 192, 0.2)', //h
                                // 'rgba(153, 102, 255, 0.2)', //u
                                'rgba(255, 159, 64, 1)' //o
                                ],
                                borderColor: [
                                // 'rgba(255, 206, 86, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                // 'rgba(255,99,132,1)',
                                // 'rgba(75, 192, 192, 1)',
                                // 'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                              }]
                            },
                            options: {
                              scales: {
                                yAxes: [{
                                  ticks: {
                                    beginAtZero: true
                                  }
                                }]
                              }
                            }
                          });
                        </script>

                        <script>
                          var ctx = document.getElementById("grafik2");
                          var myChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                              labels: ["System Analyst", "Front-End Developer","Back-End Developer" ],
                              datasets: [{
                                label: 'Bidang',
                                data: [<?php echo $saRow?> , <?php echo $feRow?> , <?php echo $beRow?>],
                                backgroundColor: [
                                'rgba(255, 206, 86, 1)', //kuning
                                // 'rgba(54, 162, 235, 1)', //biru
                                // 'rgba(255, 99, 132, 1)', //pink
                                'rgba(75, 192, 192, 1)', //hijau
                                // 'rgba(153, 102, 255, 1)',//ungu
                                // 'rgba(255, 159, 64, 1)'//orange
                                ],
                                borderColor: [
                                'rgba(255, 206, 86, 0.2)',
                                // 'rgba(54, 162, 235, 0.2)',
                                // 'rgba(255,99,132,1)',
                                'rgba(75, 192, 192, 1)',
                                // 'rgba(153, 102, 255, 1)',
                                // 'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                              }]
                            },
                            options: {
                              scales: {
                                yAxes: [{
                                  ticks: {
                                    beginAtZero: true
                                  }
                                }]
                              }
                            }
                          });
                        </script>

                        <script>
                          var ctx = document.getElementById("grafik3");
                          var myChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                              labels: ["SMA/SMK/SEDERAJAT", "DIPLOMA","SARJANA","MAGISTER"],
                              datasets: [{
                                label: 'Tingkatan',
                                data: [<?php echo $smaRow ?>,<?php echo $dipRow ?>,<?php echo $sarRow ?>,<?php echo $magRow ?>],
                                backgroundColor: [
                                // 'rgba(255, 206, 86, 1)', //kuning
                                // 'rgba(54, 162, 235, 1)', //biru
                                // 'rgba(255, 99, 132, 1)', //pink
                                'rgba(75, 192, 192, 1)', //hijau
                                // 'rgba(153, 102, 255, 1)',//ungu
                                // 'rgba(255, 159, 64, 1)'//orange
                                ],
                                borderColor: [
                                'rgba(255, 206, 86, 0.2)',
                                // 'rgba(54, 162, 235, 0.2)',
                                // 'rgba(255,99,132,1)',
                                'rgba(75, 192, 192, 1)',
                                // 'rgba(153, 102, 255, 1)',
                                // 'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                              }]
                            },
                            options: {
                              scales: {
                                yAxes: [{
                                  ticks: {
                                    beginAtZero: true
                                  }
                                }]
                              }
                            }
                          });
                        </script>