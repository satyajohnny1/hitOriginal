<?php
include 'analyticstracking.php';  
?>

 <div class="navbar">
                <div class="navbar-inner">
                    <div class="sidebar-pusher">
                        <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                            <i class="fa fa-bars"></i>
                        </a>
                    </div>
                    <div class="logo-box">
							<a href="userdashboard.php" class="logo-text"><span><img src="pic/logo.png" alt="HitandFut" height="30px"></span></a>
                    </div>
                    <!-- Logo Box -->
                 
                    <div class="topmenu-outer">
                        <div class="top-menu">
                            <ul class="nav navbar-nav navbar-left">
                                <li>
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                                </li>
                                <li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                               <li>
                                   <div class="logo-box">
                       					 <a class="logo-text"><i class="fa fa-inr">&nbsp;</i><span id="balcr"><?php echo $_SESSION['s_rs']?></span><span id="bal_id" style="display: none;"><?php include 'balance.php';?></span></a>
                  				  </div>
                                </li>
                           		  
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                        <span class="user-name"><?php echo $_SESSION['s_user']; ?><i class="fa fa-angle-down"></i></span>
                                        <img class="img-circle avatar" src="<?php echo $_SESSION['s_pic']; ?>" width="40" height="40" alt="">
                                    </a>
                                    <ul class="dropdown-menu dropdown-list" role="menu">
                                       
                                        <li role="presentation"><a href="myprofile.php"><i class="fa fa-lock"></i>Settings</a></li>
                                        <li role="presentation"><a href="logoutAjax.php"><i class="fa fa-sign-out m-r-xs"></i>Logout</a></li>
                                         <li role="presentation" style="display: none">
                                         	<i id="uid"><?php echo $_SESSION['s_uid']; ?></i>Display</a>
                                         </li>
                                    </ul>
                                   
                                </li>
                                <li>
                                    <a href="logoutAjax.php" class="log-out waves-effect waves-button waves-classic">
                                        <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="waves-effect waves-button waves-classic" id="showRight">

                                    </a>
                                </li>
                            </ul>
                            <!-- Nav -->
                        </div>
                        <!-- Top Menu -->
                    </div>
                </div>
            </div>
            <!-- Navbar -->
			