<?php 
if (!isset($_SESSION['email'])) {
  session_destroy();
  redirect('auth/sign_out');
  exit();
}
  ?>
<div class="page-loader-wrapper">

</div>

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<!-- Main Search -->
<div id="search">
    <button id="close" type="button" class="close btn btn-primary btn-icon btn-icon-mini btn-round">x</button>
    <form>
        <input type="search" value="" placeholder="Search..." />
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<!-- Right Icon menu Sidebar -->


<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <!-- <a href="index.html"><img src="<?php //echo base_url('assets/images/logo.svg'); ?>" width="25" alt="Aero"><span class="m-l-10">Aero</span></a> -->
    </div>
    <div class="menu">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="<?php echo base_url('dashboard/index'); ?>">
                        <img src="<?php 
        echo isset($_SESSION['hospital_url']) && !empty($_SESSION['hospital_url']) 
            ? $_SESSION['hospital_url'] 
            : base_url('assets/images/profile_av.jpg'); 
    ?>" alt="Hospital Profile">
                    </a>
                    <div class="detail">
                        <h4><?php echo $_SESSION['hospital_name'] ?></h4>
                        <!-- <small>Super Admin</small> -->
                    </div>
                </div>
            </li>
            <li class="active open"><a href="<?php echo base_url('dashboard/index'); ?>"><i
                        class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>


            <li class="open_top"><a href="javascript:void(0);" class="menu-toggle"><i
                        class="zmdi zmdi-map"></i><span>Patient</span></a>
                <ul class="ml-menu">
                    <li><a href="<?php echo base_url('patient_wallet/index'); ?>">Patient</a></li>
                    <li><a href="<?php echo base_url('patient_wallet/adds_manual_funding'); ?>">Patient Manual
                            Funding</a></li>
                    <li><a href="<?php echo base_url('patient_wallet/adds_refund'); ?>">Patient Refund</a></li>
                    <li><a href="<?php echo base_url('patient_wallet/patient_wallet_index'); ?>">Patient Wallet
                            Transactions</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i
                        class="zmdi zmdi-apps"></i><span>Settlement</span></a>
                <ul class="ml-menu">
                    <li><a href="<?php echo base_url('settlement/index'); ?>">Settlements Details</a></li>
                    <li><a href="<?php echo base_url('settlement/partner_index'); ?>">Partner Settlement Summary</a>
                    </li>
                    <!-- <li><a href="<?php  //echo base_url('settlement/index'); ?>">settlements</a></li>
                    <li><a href="<?php //echo base_url('wallet_funding/index'); ?>">wallet funding</a></li> -->
                </ul>
            </li>
            <li class="open_top"><a href="javascript:void(0);" class="menu-toggle"><i
                        class="zmdi zmdi-map"></i><span>Collection</span></a>
                <ul class="ml-menu">
                    <li><a href="<?php echo base_url('collection/index'); ?>"> Summary Collection Details
                        </a></li>
                    <li><a href="<?php echo base_url('settlement/bank_settlement_index'); ?>">Bank Transfer
                            Collection Details</a></li>
                    <!-- <li><a href="<?php // echo base_url('hospital/index'); ?>">Hospital</a></li> -->
                </ul>
            </li>


            <li class="open_top"><a href="javascript:void(0);" class="menu-toggle"><i
                        class="zmdi zmdi-map"></i><span>Audit</span></a>
                <ul class="ml-menu">
                    <li><a href="<?php echo base_url('audit/index'); ?>">Audit</a></li>
                    <!-- <li><a href="<?php //echo base_url('user_profile/index'); ?>">User Profile</a></li>
                    <li><a href="<?php // echo base_url('hospital/index'); ?>">Hospital</a></li> -->
                </ul>
            </li>
            <li class="open_top"><a href="javascript:void(0);" class="menu-toggle"><i
                        class="zmdi zmdi-map"></i><span>Settings</span></a>
                <ul class="ml-menu">
                    <li><a href="<?php echo base_url('user/index'); ?>">User</a></li>
                    <li><a href="<?php echo base_url('user_profile/index'); ?>">User Profile</a></li>
                    <li><a href="<?php echo base_url('hospital/index'); ?>">Hospital</a></li>
                </ul>
            </li>
            <a href="<?php echo site_url('auth/sign_out') ?>" class="dropdown-item">
                <i data-feather="power"></i>
                <span>Logout</span>
            </a>
            <!-- <li>
                <div class="progress-container progress-primary m-t-10">
                    <span class="progress-badge">Traffic this Month</span>
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="67"
                            aria-valuemin="0" aria-valuemax="100" style="width: 67%;">
                            <span class="progress-value">67%</span>
                        </div>
                    </div>
                </div>
                <div class="progress-container progress-info">
                    <span class="progress-badge">Server Load</span>
                    <div class="progress">
                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="86"
                            aria-valuemin="0" aria-valuemax="100" style="width: 86%;">
                            <span class="progress-value">86%</span>
                        </div>
                    </div>
                </div>
            </li>  -->
        </ul>
    </div>
</aside>