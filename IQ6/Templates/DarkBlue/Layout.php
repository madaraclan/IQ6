<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="<?php echo Path::Template('Images/favicon.ico')?>" />
<title><?php echo $title; ?> / Educeus&trade;</title>
<!--CSS-->
<link href="<?php echo Path::Template('CSS/Layout.css')?>" type="text/css" rel="stylesheet" media="all" />
<link href="<?php echo Path::Template('Javascripts/jquery.shiftenter.css')?>" type="text/css" rel="stylesheet" media="all" />

<!--Javascripts-->
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/jQuery.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/ajaxupload/uploadify/swfobject.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/ajaxupload/uploadify/jquery.uploadify.v2.1.4.min.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/webcam/webcam.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/auto.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/jquery.shiftenter.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/jquery.easing.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/jquery.elastic.source.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/jAutoResize.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/MessageBox.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/Tabs.js')?>"></script>
<script type="text/javascript" src="<?php echo Path::Template('Javascripts/Layout.js')?>"></script>
<link rel="stylesheet" href="<?php echo Path::Template('Javascripts/chosen/chosen.css')?>" />
</head>

<body>

	<!--Top Wrapper-->
    <div id="TopWrapper">
            
        <!--Top-->
        <div id="Top" class="BgX">
        	
            <!--ContentWrapper-->
        	<div class="TopContentWrapper">

                <!--Top Navigation-->
                <div id="TopNavigation">
                    <div id="Logo">
                        <a href=""><img src="<?php echo Path::Template('Images/logo.jpg')?>" alt="Educeus&trade;" title="Educeus&trade;" /></a>
                    </div>
                    <?php
                    $URI    = new URI();
                    $currentCom = array("NewsFeeds"=>"");
                    $currentApp = array("Class"=>"");
                    
                    $currentApp[$URI->GetURI('App')] = 'class="Current"';
                    $currentCom[$URI->GetURI('Com')] = 'class="Current"';

                    ?>
                    <div class="Navigation">
                        <ul>
                            <li><a href="<?php echo URI::WriteURI('App=Account&Com=NewsFeeds')?>" <?php echo $currentCom['NewsFeeds']?>>
                                <!--<span class="Icon16 IconHome16"></span>-->
                                <span class="Label">Friends and Network</span>
                            </a></li>
                            
                            <li><a href="" <?php echo $currentApp['Class']?>>
                                <!--<span class="Icon16 IconClass16"></span>-->
                                <span class="Label">School</span>
                            </a></li>
                            
                            <li><a href="">
                                <!--<span class="Icon16 IconInformation16"></span>-->
                                <span class="Label">Information</span>
                            </a></li>

                            <li><a href="">
                                <!--<span class="Icon16 IconInformation16"></span>-->
                                <span class="Label">Store</span>
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
        <!--<div id="Middle">
            
            <!--Content Wrapper-->
            <!--<div class="ContentWrapper">-->
            
            <?php echo $contentDataLayout; ?>
            
           	<!--</div>
            <!--End Content Wrapper-->
        <!--</div>
        <!--End Middle-->
        <!--</div>
        <!--End Content Wrapper-->

    </div>
    <!--End Top Wrapper-->
    
    <!--Bottom Wrapper-->
    <div id="BottomWrapper" class="BgX">
    	
        <div class="ContentBottomWrapper">
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