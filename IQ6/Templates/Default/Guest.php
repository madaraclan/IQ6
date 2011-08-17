<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?> / Educeus&trade;</title>
<!--CSS-->
<link href="<?php echo Path::Template('CSS/Login.css')?>" type="text/css" rel="stylesheet" media="all" />

<!--Javascripts-->
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/jQuery.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/Login.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/LoginCustom.js')?>"></script>
</head>

<body>

	<!--Top Wrapper-->
    <div id="TopWrapper">
            
        <!--Top-->
        <div id="Top" class="BgX">
        	
            <!--ContentWrapper-->
        	<div class="ContentWrapper">
            
                <!--Header-->
                <div id="Header"></div>
                <!--End Header-->
                
                <!--Top Navigation-->
                <div id="TopNavigation">
                    <div id="Logo">
                        <a href=""><img src="<?php echo Path::Template('Images/logo.jpg')?>" alt="Educeus&trade;" title="Educeus&trade;" /></a>
                    </div>
                    
                    <div class="Navigation">
                        <ul>
                            <li><a href="" class="Current">
                                <span class="Icon16 IconLogin16"></span>
                                <span class="Label">Login</span>
                                <span class="Description">enter your page</span>
                            </a></li>
                            
                            <li><a href="">
                                <span class="Icon16 IconAbout16"></span>
                                <span class="Label">About</span>
                                <span class="Description">what is educeus?</span>
                            </a></li>
                            
                            <li><a href="">
                                <span class="Icon16 IconDevelopers16"></span>
                                <span class="Label">Developers</span>
                                <span class="Description">the people behind educeus</span>
                            </a></li>
                            
                            <li><a href="">
                                <span class="Icon16 IconHelp16"></span>
                                <span class="Label">Help</span>
                                <span class="Description">need some help?</span>
                            </a></li>
                        </ul>
                    </div>
            	</div>
                
            </div>
            <!--End Top Navigation-->
            
            </div>
            <!--End Content Wrapper-->
            
        </div>
        <!--End Top-->
        
        <!--Middle-->
        <div id="Middle">
            
            <!--Content Wrapper-->
            <div class="ContentWrapper">
            
            <?php echo $contentDataLayout; ?>
            
           	</div>
            <!--End Content Wrapper-->
        </div>
        <!--End Middle-->
        </div>
        <!--End Content Wrapper-->
        
    </div>
    <!--End Top Wrapper-->
    
    <!--Bottom Wrapper-->
    <div id="BottomWrapper" class="BgX">
    	
        <div class="ContentWrapper">
            <!--Footer-->
            <div id="Footer">
                <div id="CopyrightInfo">
                	
                    <div>Copyrighted &copy; Educeus&trade; 2011.</div>
                    
                    <ul>
                    	<li><a href="">Privacy</a></li>
                        <li><a href="">Terms</a></li>
                        <li><a href="">Legal Notice</a></li>
                    </ul>
                </div>
                
                <div id="Language">
                	<ul>
                    	<li><a href="" class="Current">English (US)</a></li>
                        <li><a href="">Bahasa Indonesia</a></li>
                    </ul>
                </div>
            </div>
            <!--End Footer-->
        </div>
    
    </div>
    <!--End Bottom Wrapper-->
    
</body>
</html>