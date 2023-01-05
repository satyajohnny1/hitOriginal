    <div class="page-sidebar-inner slimscroll">

                    <ul class="menu accordion-menu">
                        <li class="active"><a href="userdashboard.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>Dashboard</p></a></li>
                          <!--<li><a href="earn.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-user"></span><p>Earn Money</p></a></li>  -->   
                          <!--<li><a href="distribute.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-user"></span><p>Distribute</p></a></li>  -->                         
                        <li><a href="makemovie.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-th"></span><p>Make Movie</p></a> </li>                       
                        <li><a href="readyforshoot.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-log-in"></span><p>Shoot</p></a>
                          <li><a href="readyforrelease.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-log-in"></span><p>Release</p></a>
                           
						  <!--      <li class="droplink"><a href="readyforrelease.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-stats"></span><p>Release</p><span class="arrow"></span></a>
                                <ul class="sub-menu">
                                    <li><a href="release.php">Own Release</a></li>
                                    <li><a href="relese.php">Distribute</a></li>                                    
                                </ul>
                            </li>
						    -->
                            <li><a href="readyforrun.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-edit"></span><p>Running</p></a> </li>

                            <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-stats"></span><p>My Data</p><span class="arrow"></span></a>
                                <ul class="sub-menu">
				      <li><a href="http://185.27.134.10/db_structure.php?db=epiz_28768808_javabo">Database</a></li>	
                                    <li><a href="mydata.php">Released</a></li>                                   
                                    <li><a href="myprofile.php">Settings</a></li> 
                                    <li><a href="logoutAjax.php">Logout</a></li>
				  	
                                   <!--  <li><a href="mydistributeddata.php">Distributed</a></li>
                                    <li><a href="myfinancedata.php">Finance</a></li>
                                    <li><a href="introduce.php">Introduce</a></li> -->
                                </ul>
                            </li>
                            <li class="droplink"><a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-log-in"></span><p>BoxOffice</p><span class="arrow"></span></a>
                                <ul class="sub-menu">
                                    <li><a href="news.php">News</a></li>
                                    <li><a href="alldata.php">All Movies</a></li>
				     <li><a href="allcollections.php">All Collections</a></li>
                                    <li><a href="listactors.php">Actors</a></li>
                                    <li><a href="listactress.php">Actress</a></li>
                                    <li><a href="listproducers.php">Producers</a></li>
                                    <li><a href="listdirectors.php">Directors</a></li>
                                    <li><a href="listwriters.php">Writers</a></li>
                                    <li><a href="listeditors.php">Editors</a></li>
                                    <li><a href="listmisic.php">MusicDirectors</a></li>
                                    <li><a href="listcine.php">Cinematographers</a></li>

                                </ul>
                            </li>
			    <li><a href="pending.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-random"></span><p>Pending</p></a>
				    <li><a href="thInfo.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-info-sign"></span><p>TheatrInfo</p></a>
							
							      <li><a href="logoutAjax.php" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-edit"></span><p>Logout</p></a> </li>
							
							 <?php 
							
							 if($_SESSION['s_type'] == 'admin')
							 {
									 echo "<li><a href=\"actordata.php\" class=\"waves-effect waves-button\"><span class=\"menu-icon glyphicon glyphicon-log-in\"></span><p>Admin</p></a>";
									 
									 echo "<li><a href=\"pf.php\" class=\"waves-effect waves-button\"><span class=\"menu-icon glyphicon glyphicon-log-in\"></span><p>PF Normalize</p></a>";
									 
							 }
									   ?> 
							
							
                    </ul>
                </div>
