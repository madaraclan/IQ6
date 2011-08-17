<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?> to Educeus&trade;</title>
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
        <div id="TopLogin" class="bgXLogin">

            <!--ContentWrapper-->
        	<div class="ContentWrapper">
            
                <!--Header-->
                <div id="Header"></div>
                <!--End Header-->
                
                <!--Top Navigation-->
                <div id="TopNavigation">
                    <div id="Logo">
                        <a href=""><img src="<?php echo Path::Template('Images/logo_big.jpg')?>" alt="Educeus&trade;" title="Educeus&trade;" /></a>
                    </div>
                    
                    <div id="FormLogin">
                        <form method="post" action="<?php URI::WriteURI('App=Account&Com=Login&Act=DoLogin', false) ?>">

                            <div class="inputField">
                                <div><input size="20" type="text" name="username" id="username" value="Userid / Email" /></div>
                                <div><input size="20" type="password" class="active" name="password" id="password" value="Password" /></div>
                                <div><span class="buttonOrange" style="border-bottom: none"><input style="color: #fff" type="submit" name="login" value="Login" class="button" /></span></div>
                                <div class="ClearFix"></div>
                                <div style="margin-top: 3px"><input type="checkbox" id="keepLogedIn" name="keepLogedIn" value="true" style="float: left; margin-left: -1px"> <label class="keepLogedIn" for="keepLogedIn">Keep me loged in</label></div>
                                <div style="margin-top: 7px; margin-left: 55px"><a class="forgot" href="">Forgot your password?</a></div>
                            </div>

                        </form>
                    </div>
            	</div>
                
            </div>
            <!--End Top Navigation-->
            
            </div>
            <!--End Content Wrapper-->
            
        </div>
        <!--End Top-->
        
        <!--Middle-->
        <div id="Middle" class="loginMapHandler">
            <div id="people" class="loginMapHandler">
                <!--Content Wrapper-->
                <div class="ContentWrapper">

                <?php  echo $contentDataLayout; ?>

                </div>
                <!--End Content Wrapper-->
            </div>
        </div>
        <!--End Middle-->
        </div>
        <!--End Content Wrapper-->
        
    </div>
    <!--End Top Wrapper-->
    
    <!--Bottom Wrapper-->
    <div id="BottomLogin" class="bgXLogin">
    	
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