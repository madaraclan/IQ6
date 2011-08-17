<div class="BoxContentBordered GettingStarted">

    <div class="Title">
        <h1>New in Educeus? Let's Getting Started</h1>
        <span class="Description">Please complete your information step by step bellow</span>
    </div>

    <div class="HrGrayWhite"></div>

    <div class="GettingStartedStep">

        <ul class="GettingStartedNavigation">

            <li>
                <span class="NumStep">1</span>
                <span class="Text">
                    <span class="Title">Profile</span>
                    <span class="Description">Complete your profile</span>
                </span>
            </li>

            <li class="Current">
                <span class="NumStep">2</span>
                <span class="Text">
                    <span class="Title">Profile Picture</span>
                    <span class="Description">Upload your profile picture</span>
                </span>
            </li>

            <li class="LastStep">
                <span class="NumStep">3</span>
                <span class="Text">
                    <span class="Title">Friends</span>
                    <span class="Description">Find and follow friends</span>
                </span>
            </li>

        </ul>

        <span class="WelcomeLogo"><img src="<?php echo Path::Template('Images/logo_small.gif')?>" /></span>
        <span class="WelcomeText">connected and welcome to</span>

    </div>

    <div class="ClearFix"></div>
    <div class="HrGrayWhite"></div>

    <div id="profilePictureContainer">

        <div class="thumbProfilePicture">
        	<?php if (!$Avatar){ ?>
            <img src="<?php echo Path::Template('Images/wizard_profile_picture1.jpg')?>" />
    		<?php }else{ ?>
    		<img src="<?php echo Config::Instance('default')->photos; ?>p_big_<?php echo $Avatar; ?>.jpg" />
    		<?php } ?>  
        </div>
	
        <div class="leftArrow"></div>

        <div class="UploadForm">
            <div class="uploadFromComputer">
            	<div class="uploadFromComputerContainer">
                <input type="file" name="profilePicture" id="profilePicture" />
                <span class="description">Upload an image from your computer (Max 3GB).</span>
                </div>
               	<div class="loading" style="display:none;"></div>
            </div>


            <span class="orText">OR</span>
            <div class="HrGrayWhite"></div>
            

            <div class="takeAPhoto">
                <a href="#" id="TakeWebCam"><h2>Take a Photo</h2></a>
                <span class="description">Take an image from your webcam.</span>
            </div>

            <div class="actionContainer">
                
                <div class="Left">
                    <span class="buttonGray"><a href="<?php URI::WriteURI('App=Account&Com=GettingStarted')?>" class="button"><img src="<?php echo Path::Template('Images/back_arrow.png')?>" />&nbsp;Back</a></span>
                </div>
                <div class="Right">
                    <span class="buttonBlue"><input type="submit" name="save" id="save" value="Save & Continue" class="button" /></span>
                    <span class="Left">&nbsp;</span>
                    <span class="buttonGray"><a href="<?php URI::WriteURI('App=Account&Com=GettingStarted&Act=FindFriends')?>" class="button">Skip&nbsp;<img src="<?php echo Path::Template('Images/next_arrow.png')?>" /></a></span>
                </div>
                <div class="ClearFix"></div>
            </div>

            <div class="ClearFix"></div>
        </div>

        <div class="help"></div>

        <div class="tipsDescription" style="width:140px;">
            Your Educeus profile picture helps instantly identify you to those following you—and tells those who aren't more about you.
        </div>
        
        <div class="ClearFix"></div>
        
    </div>



    <div class="ClearFix"></div>
    <br />

</div>
<div class="Left"></div>

<div id="messageBoxOverlay" style="display: none;"></div>
<div class="popupBox" style="display: none; min-width:inherit;" >
    <div class="top">
        <div class="leftTop bgX">
            <div class="rightTop bgX">
                <div class="centerTop bgX">
                    <div class="title">Take Picture</div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="leftMidle bgY">
            <div class="rightMidle bgY">
                <div class="centerMidle">
                    <div class="boxContent">
                        <div id="screen"></div>

                        <div class="ClearFix"></div>
                        <div class="buttonContent">
                            <div class="buttonPosition" style="float:left">
                                <span class="buttonBlue" style="display: none;" id="uploadButton">
                                    <input type="button" class="button" value="Upload">
                                </span>
                                <span id="leftLoading" style="display: none" class="Left">
                                    <img src="<?php echo Path::Template('Images/loading_med.gif')?>" />
                                </span>
                            </div>

                            <div class="buttonPosition">
                                <span id="rightLoading" style="display: none" class="Left">
                                    <img src="<?php echo Path::Template('Images/loading_med.gif')?>" />
                                </span>
                                <span class="buttonOrange">
                                    <input type="button" class="button" value="Shoot" id="shootButton">
                                </span>

                                <span class="buttonOrange" style="display: none;" id="reShootButton">
                                    <input type="button" class="button" value="Re Shoot">
                                </span>

                                <span class="buttonGray">
                                    <input type="button" class="button" value="Cancel" id="cancelButton">
                                </span>

                            </div>
                            <div class="ClearFix"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bottom"><div class="bottomLeft bgX"><div class="bottomRight bgX"><div class="bottomCenter bgX"></div></div></div></div></div>

<script type="text/javascript">
$(function(){

	var Educeus_Account = (function(){

		var request;
		var working = false;

		var screen = $('#screen');
		var shootEnabled = false;

		var tmpFile;
		
		var init = function(){
			Init_ProfilePicture();
		};
		
		var Init_ProfilePicture = function(){
			Init_UplaodAjax();
			Init_WebCam();
			EventHandler();
		};

		var EventHandler = function(){
			$('a#TakeWebCam').bind('click', function(e){
				e.preventDefault();
				var top     = $(".popupBox").height() / 2;
                var left    = $(".popupBox").width() / 2;

                $(".popupBox").css({marginTop:-top+'px', marginLeft:-left+'px'});
                $(".popupBox").fadeIn(function() {
                    $("#messageBoxOverlay").fadeIn("slow", function() {
                        $("#messageBoxOverlay").css({opacity:'0.5'});
                    });

                });
                
			});
			$('#skip').bind('click', function(e){
				e.preventDefault();
				$.post('<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=SkipUploadPhoto'); ?>', '', function(res){
					window.location = res.url;
				}, 'json');
			});
			$('#save').bind('click', function(e){
				e.preventDefault();
				window.location = '<?php echo Config::Instance('default')->baseUrl . 'Account/GettingStarted/FindFriends'; ?>';
			});
		};

		var Init_UplaodAjax = function(){
			$('#profilePicture').uploadify({
				'uploader' : '<?php echo Path::Template('Javascripts/ajaxupload/uploadify/uploadify.swf'); ?>',
				'script' : '<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=SavePhotoViaUpload&TokenId='.$TokenId); ?>',
				'cancelImg' : '<?php echo Path::Template('Javascripts/ajaxupload/img/cancel.png'); ?>',
				'folder' : '<?php echo Config::Instance('default')->photos; ?>',
				'multi' : false,
				'auto' : true,
				'height' : '32',
				'width' : '223',
				'wmode' : 'transparent',
				'buttonImg' : '<?php echo Path::Template('Images/uploadbutton.png'); ?>',
				fileExt: '*.jpg',
				fileDesc: 'JPEG Images',
				'sizeLimit' : 3145728, // 3mb,
				onOpen : function(){
					$('.loading').show();
				},
				onProgress : function(){
					$('.loading').show();
				},
				onComplete: function (event, ID, fileObj, response, data) {
					if (response !== null && response !== undefined) {
						tmpFile = response;
						console.log(response);
						//$('.loading').prev().show();
						$('.thumbProfilePicture').find('img').attr('src', tmpFile);
						$('.loading').hide();
					}
				}
			});
		};

		var Init_WebCam = function(){
			webcam.set_swf_url('<?php echo Path::Template('Javascripts/webcam/webcam.swf'); ?>');
			webcam.set_api_url('<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=SavePhotoViaWebCam'); ?>');
			webcam.set_quality(100);
			webcam.set_shutter_sound(true, '<?php echo Path::Template('Javascripts/webcam/shutter.mp3'); ?>');
			screen.html(webcam.get_html(screen.width(), screen.height()));

			webcam.set_hook('onLoad', function(){
				shootEnabled = true;
			});

			webcam.set_hook('onError', function(e){
				screen.html(e);
			});

			webcam.set_hook('onComplete', function(msg){
				msg = $.parseJSON(msg);
				tmpFile = msg.filename;
				$('.thumbProfilePicture').find('img').attr('src', tmpFile);
				$("#messageBoxOverlay").fadeOut();
                $(".popupBox").fadeOut(function() {
                    $('#cancelButton').show();
                    $('#shootButton').show();
                    $('#uploadButton').hide();
                    $('#reShootButton').hide();
                    $("#rightLoading").hide();
                    $("#leftLoading").hide();
                });
			});

			$('#uploadButton .button').bind('click', function(){
				webcam.upload();
				webcam.reset();
                $('#uploadButton').hide();
                $('#shootButton').hide();
                $('#cancelButton').hide();
                $('#leftLoading').show();
				return false;
			});
            $('#reShootButton .button').bind('click', function(){
				webcam.reset();
                $('#reShootButton').hide();
                $('#uploadButton').hide();
                $('#rightLoading').show();
                var initd = setTimeout(function() {
                    $('#shootButton').show();
                    $('#rightLoading').hide();
                }, 2100);
				return false;
			});
			$('#shootButton').bind('click', function(){
				if (!shootEnabled) return false;
				webcam.freeze();
				$('#uploadButton').show();
                $('#reShootButton').show();
				$(this).hide();
				return false;
			});
			$('#cancelButton').bind('click', function(e){
				e.preventDefault();
				webcam.reset();
				$("#messageBoxOverlay").fadeOut();
                $(".popupBox").fadeOut(function() {
                    $('#cancelButton').show();
                    $('#shootButton').show();
                    $('#uploadButton').hide();
                    $('#reShootButton').hide();
                    $("#rightLoading").hide();
                    $("#leftLoading").hide();
                });

			});
			
		};

		return {
			init : init
		}
		
	})();

	Educeus_Account.init();
	
});
</script>
