    <?php 
        $className = $this->router->fetch_class();
        $methodName = $this->router->fetch_method();
     ?>
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile">
            <!-- User profile image -->
            <div class="profile-img"> <img class="img img-responsive img-user-login" src="<?php echo base_url();?>assets/images/users/owner.jpeg" style="height: 85px; width: 85px;" alt="user" />
                <!-- this is blinking heartbit-->
                <!-- <div class="notify setpos"> <span class="heartbit"></span> <span class="point"></span> </div> -->
            </div>
            <!-- User profile text-->
            <div class="profile-text">
                <h5 id="nameUserLogin">Andil Ong</h5>
                <a href="javascript:void();" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-settings"></i></a>
                <!-- <a href="app-email.html" class="" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a> -->
                <a href="<?php echo site_url('auth/logout1'); ?>" class="" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
                <div class="dropdown-menu animated flipInY">
                    <a href="<?php echo site_url('umum/profile'); ?>" class="dropdown-item"><i class="ti-user"></i> My Profile</a>
                    <input type="hidden" id="userIdLogin" value="">
                </div>
            </div>
            <script type="text/javascript">

                var userIdLogin = <?php echo $this->user->id; ?>


                profilePhoto();
                function profilePhoto(){$.post('/master/users/getbyid/'+userIdLogin,function(json){if(json.status==!0){$("#nameUserLogin").text(json.data.full_name);srcPhoto=json.data.photo==""?'/assets/images/default/user_image.png':'/uploads/admin/users/'+json.data.photo;$(".img-user-login").attr("src",srcPhoto)}})}

                loadLogoIcon();
                function loadLogoIcon() {
                    $.post("/umum/getIdUmum",function(json) {
                        if (json.status == true) {
                            $("#titleLogoIcon").attr("href",json.data.logo_icon);
                            $("#imgLogoIcon").attr("src",json.data.logo_icon);
                            $("#logoName").html(json.data.nama_perusahaan);
                        }
                    });
                }

            </script>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>
                <li> 
                    <a class="waves-effect waves-dark" href="<?php echo site_url('dashboard'); ?>">
                        <i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span>
                    </a>
                </li>

                <li class="nav-small-cap">PERFORMA</li>
                <li> 
                    <a class="waves-effect waves-dark" href="<?php echo site_url('performa/armadastatus'); ?>">
                        <i class="mdi mdi-bus"></i><span class="hide-menu">Armada Status</span>
                    </a>
                </li>
                <?php if ($this->user != null && ( $this->user_role == "bengkel"  || $this->user_role == "owner"  ||  $this->user_role == "dev" )) { ?>
                <li> 
                    <a class="waves-effect waves-dark" href="<?php echo site_url('performa/bengkel'); ?>">
                        <i class="mdi mdi-brightness-7"></i><span class="hide-menu">Bengkel</span>
                    </a>
                </li>
                <?php } ?>
                <?php if ($this->user != null && ( $this->user_role == "supervisor"  || $this->user_role == "owner"  ||  $this->user_role == "dev" )) { ?>
                <li> 
                    <a class="waves-effect waves-dark" href="<?php echo site_url('performa/suratjalan'); ?>">
                        <i class="mdi mdi-clipboard-text"></i><span class="hide-menu">Surat Jalan/Trip</span>
                    </a>
                </li>
                <li> 
                    <a class="waves-effect waves-dark" href="<?php echo site_url('performa/perjalananarmada'); ?>">
                        <i class="mdi mdi-highway"></i><span class="hide-menu">Perjalanan Armada</span>
                    </a>
                </li>
                <?php } ?>
                <?php if ($this->user != null && ( $this->user_role == "kasir"  || $this->user_role == "owner"  ||  $this->user_role == "dev" )) { ?>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-credit-card-multiple"></i><span class="hide-menu">Pendapatan</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo site_url('pendapatan/armada'); ?>">Armada</a></li>
                        <li><a href="<?php echo site_url('pendapatan/supir'); ?>">Supir</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-credit-card"></i><span class="hide-menu">Transaksi</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo site_url('transaksi/penjualan'); ?>">Penjualan/Pemakaian</a></li>
                        <li><a href="<?php echo site_url('transaksi/pembelian'); ?>">Pembelian</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if (($this->user != null && $this->user_role == "owner" ) || ($this->user != null && $this->user_role == "dev" )) { ?>
                <li class="nav-small-cap">MASTER DATA</li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-subway"></i><span class="hide-menu">Master Armada</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo site_url('master/armada'); ?>">Armada</a></li>
                        <li><a href="<?php echo site_url('master/chassis'); ?>">Merk Chassis & Tipe</a></li>
                        <li><a href="<?php echo site_url('master/karoseri'); ?>">Karoseri & Tipe</a></li>
                        <li><a href="<?php echo site_url('master/kps'); ?>">KPS</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-credit-card-plus"></i><span class="hide-menu">Master Cicilan / Kredit</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo site_url('master/kreditchassis'); ?>">Chassis</a></li>
                        <li><a href="<?php echo site_url('master/kreditkaroseri'); ?>">Karoseri</a></li>
                    </ul>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-multiple"></i><span class="hide-menu">Master Karyawan</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo site_url('master/karyawan'); ?>">Karyawan</a></li>
                        <li><a href="<?php echo site_url('master/jabatan'); ?>">Jabatan</a></li>
                        <li><a href="<?php echo site_url('master/bank'); ?>">Bank</a></li>
                    </ul>
                </li>
                <li> 
                    <a class="waves-effect" href="<?php echo site_url('master/jadwal'); ?>"><i class="mdi mdi-calendar-text"></i><span class="hide-menu">Master Jadwal</span></a>
                </li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu">Master Inventory</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo site_url('master/produk'); ?>">Produk</a></li>
                        <li><a href="<?php echo site_url('master/gudang'); ?>">Gudang</a></li>
                        <li><a href="<?php echo site_url('master/produkkategori'); ?>">Kategori & Unit Produk</a></li>
                    </ul>
                </li>
                <li> 
                    <a class="waves-effect" href="<?php echo site_url('master/vendor'); ?>"><i class="mdi mdi-sitemap"></i><span class="hide-menu">Master Vendor</span></a>
                </li>
                <li> 
                    <a class="waves-effect" href="<?php echo site_url('master/accountkas'); ?>"><i class="mdi mdi-book-open"></i><span class="hide-menu">Master Account Kas</span></a>
                </li>
                <?php } ?>
                <?php if ($this->user != null && ( $this->user_role == "kasir"  || $this->user_role == "owner"  ||  $this->user_role == "dev" )) { ?>
                <li class="nav-small-cap">LAPORAN</li>
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bulletin-board"></i><span class="hide-menu">Laporan History</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="<?php echo site_url('laporan/armada'); ?>">Armada</a></li>
                        <li><a href="<?php echo site_url('laporan/supir'); ?>">Supir</a></li>
                        <li><a href="<?php echo site_url('laporan/gudang'); ?>">Gudang</a></li>
                        <li><a href="<?php echo site_url('laporan/accountkas'); ?>">Account Kas</a></li>
                    </ul>
                </li>
                <?php } ?>
                <?php if (($this->user != null && $this->user_role == "owner" ) || ($this->user != null && $this->user_role == "dev" )) { ?>
                <li class="nav-small-cap">PENGATURAN</li>
                 <li> 
                    <a class="waves-effect" href="<?php echo site_url('master/users'); ?>"><i class="mdi mdi-account-switch"></i><span class="hide-menu">Pengguna</span></a>
                </li>
                <li> 
                    <a class="waves-effect waves-dark" href="<?php echo site_url('umum'); ?>"><i class="mdi mdi-receipt"></i><span class="hide-menu">Umum</span></a>
                </li>
                <?php } ?>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>