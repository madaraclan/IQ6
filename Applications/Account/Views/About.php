<script type="text/javascript">
var ArrMusic = [];
var ArrBooks = [];
var ArrMovie = [];
var ArrHobby = [];
var ArrPhone = [];
<?php echo $_MusicsJS.$_BooksJS.$_MoviesJS.$_HobbyJS.$_PhoneJS; ?>
</script>

<div id="Middle" style="padding-top:100px;">

    <div class="ContentWrapper">

        <div class="ContentTwoLayout">
            <div class="LeftColumn">

                <div class="userProfilePicture">
                    <?php
                    $bigAvatar = ( ! empty($user->AvatarFilePath)) ? "p_big_".$user->AvatarFilePath.".jpg" : "Thumb.gif";
                    ?>
                    <img src="<?php echo Config::Instance(SETTING_USE)->photos.$bigAvatar?>" width="200" height="200" />
                </div>

                <div class="boxWidget">
                    <div class="header"></div>
                    <div class="content">
                       
                        <div class="ClearFix"></div>
                    </div>
                </div>

            </div>
            <div class="RightColumn">

                <div id="DetailProfile">

                    <div class="information">
                        <div class="header"><?php echo $user->FirstName.' '.$user->LastName?></div>
                        <div class="description"><?php echo $user->BriefDescription?></div>
                    </div>

                     <div class="tabInformation">
                        <ul class="tabInformationList">
                            <li><a  href="<?php $URI->WriteURI('App=Account&Com=Profile&Act=Detail&UName='.Encryption::Encrypt($user->UName)); ?>">Posts</a></li>
                            <li><a class="current" href="<?php $URI->WriteURI('App=Account&Com=About&Act=Detail&UName='.$user->UName); ?>">About</a></li>
                            <li><a href="">Diaries</a></li>
                           <?php if ($user->UName == $UNameCurrent){ ?>
                            <li><a href="<?php $URI->WriteURI('App=Account&Com=EditProfile'); ?>">Edit Profile</a></li>
                        	<?php } ?>
                       	</ul>
                        <div class="ClearFix"></div>
                    </div>

                  	<div class="CompleteProfile" style="margin-top:50px;">

        <div id="tabBasicInformation">
			
			<form id="BasicInformation" method="post">
			
			<?php if ($FirstName || $LastName){ ?>
			
			<div class="row" style="border-top:none;">

                <div class="inputRow About">
                    <span class="label">First Name:</span>
                    <span class="inputField" style="line-height:23px;">
                       	<?php echo $FirstName; ?>
                    </span>
                    <div class="ClearFix"></div>
                </div>
                
                <div class="inputRow About">
                    <span class="label">Last Name:</span>
                    <span class="inputField" style="line-height:23px;">
                        <?php echo $LastName; ?>
                    </span>
                    <div class="ClearFix"></div>
                </div>
							
            </div>
            
            <?php } ?>
            
            <?php if ($CurrentCity || $Hometown){ ?>
			
            <div class="row" style="border-top:none;">
				
				<?php if ($CurrentCity){ ?>
                <div class="inputRow About">
                    <span class="label">Current City:</span>
                    <span class="inputField" style="line-height:23px;">
                    	<?php echo $CurrentCity->CTName; ?>
                    </span>
                    <div class="ClearFix"></div>
                </div>
                <?php } ?>

				<?php if ($Hometown){ ?>
                <div class="inputRow About">
                    <span class="label">Hometown:</span>
                    <span class="inputField" style="line-height:23px;">
                        <?php echo $Hometown->CTName; ?>
                    </span>
                    <div class="ClearFix"></div>
                </div>
                <?php } ?>
				
				 <input type="hidden" name="national_Input" size="60" id="national_Input" value="<?php echo ($Nationality ? $Nationality->NID : ''); ?>" />
			
            </div>
            
            <?php } ?>


			<?php if ($Religion || $Gender){ ?>
            <div class="row" style="border-top:none;">

				<?php if ($Religion){ ?>
                <div class="inputRow About">
                    <span class="label">Religion:</span>
                    <span class="inputField" style="line-height:23px;">
                        <?php echo $Religion; ?>
                    </span>
                    <div class="ClearFix"></div>
                </div>
                <?php } ?>

				<?php if ($Gender){ ?>
                <div class="inputRow About" >
                    <span class="label">I Am:</span>
                    <span class="inputField" style="line-height:23px;">
                        <?php echo $Gender; ?>
                    </span>
                    <div class="ClearFix"></div>
                </div>
                <?php } ?>

            </div>
            
            <?php } ?>
            
            <?php if ($Birthday){ ?>

            <div class="row" style="border-top:none;">

                <div class="inputRow About">
                    <span class="label">Birthday:</span>
                    <span class="inputField" style="line-height:23px;">
                    	
                    	 <?php
                        $arrMonthName   = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec");
                        $Birthday = explode('-', $Birthday);
                         $i = 0;
                         $MonthSelected = '';
                        foreach($arrMonthName as $monthName){
                        	$MonthSelected = '';
                            if ($Birthday[1] == ($i+1)) {
                            	$MonthSelected = $monthName;
                            	break;
                            }
                            $i++;
                        }
                        
                        ?>
                    	
                    	<?php
						if ($ShowBirthday == 0){
							echo $MonthSelected . ' ' . $Birthday[2] . ' ' . $Birthday[0];
						}else if ($ShowBirthday == 1){
							echo $MonthSelected . ' ' . $Birthday[2];
						}else{
							echo '';
						}
                    	?>
                    
                       
                        
                    </span>
                    <div class="ClearFix"></div>
                </div>

            </div>

			<?php } ?>
			
			<?php if ($RelationType || $Interest){ ?>

            <div class="row" style="border-top:none;">

				<?php if ($RelationType){ ?>
                <div class="inputRow About">
                    <span class="label">Relation Status:</span>
                    <span class="inputField" style="line-height:23px;">
                    	
                    	<?php 
                    	$Relation = '';
                    	switch($RelationType){
                    		case 1 :
                    			$Relation = 'Single';
                    			break;
                    		case 2 :
                    			$Relation = 'In a relationship with';
                    			break;
                    		case 3 :
                    			$Relation = 'Engaged with';
                    			break;
                    		case 4 :
                    			$Relation = 'Married with';
                    			break;
                    		case 5 :
                    			$Relation = "It's complicated with";
                    			break;
                    	} 
                    	$_RelationURToUName = '';
                    	if ($Relation){
                    		$link = Encryption::Encrypt($RelationURToUName);
                    		$_RelationURToUName = '<a href="'.URI::ReturnURI('App=Account&Com=Profile&Act=Detail&UName='.$link).'">'.$RelationURToUName_FirstName.' '.$RelationURToUName_LastName."</a>";
                    	}
                    	
                    	echo $Relation . ' ' . $_RelationURToUName;
                    	?>

                        
                    </span>
                    <div class="ClearFix"></div>
                </div>
                <?php } ?>

				<?php if ($Interest){ ?>
                <div class="inputRow About">
                    <span class="label">Interested In:</span>
                    <span class="inputField" style="line-height:23px;">
                    	<?php echo $Interest; ?>
                    </span>
                    <div class="ClearFix"></div>
                </div>
                <?php } ?>

            </div>
			<?php } ?>
			
			
			<?php if ($AboutMe){ ?>
            <div class="row" style="border-top:none;">

				<?php if ($AboutMe){ ?>
                <div class="inputRow About" >
                    <span class="label">About Me:</span>
                    <span class="inputField" style="line-height:23px;">
                        <?php echo $AboutMe; ?>
                    </span>
                    <div class="ClearFix"></div>
                </div>
                <?php } ?>

            </div>
            
            <?php } ?>
            
			</form>

        </div>
        
        <div id="tabEducationWork" >
        	
        	<?php if ($EmployersAt){ ?>
        	
        	<form id="EducationWork" method="post">
        	
        		
        		
        		<div class="row" style="border-top:none;">

					<?php if ($EmployersAt){ ?>
	                <div class="inputRow About">
	                    <span class="label">Employers At:</span>
	                    <span class="inputField" style="line-height:23px;">
	                        <?php echo $EmployersAt; ?>
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	                <?php } ?>
	                
	            </div>
        		
        		<?php } ?>
        		
        	</form>
        	
        </div>
        
        <div id="tabArtEntertainment" >
        	
        	<?php if ($Musics || $Books || $Movies){ ?>
        	
        	<form id="ArtEntertainment" method="post">
        	
        		<div class="row" style="border-top:none;">

					<?php if ($Musics){ ?>
	                <div class="inputRow About">
	                    <span class="label">Music:</span>
	                    
	                    
	                    <div class="ListRows" id="ListMusic" >
	                    	<ul>
	                    		<?php echo $Musics; ?>
	                    	</ul>
	                    </div>
	                    
	                </div>
	                <?php } ?>
	                
	            </div>
	            
	            <div class="row" style="border-top:none;">

					<?php if ($Books){ ?>
	                <div class="inputRow About">
	                    <span class="label">Books:</span>

	                    <div class="ListRows" id="ListMusic">
	                    	<ul>
	                    		<?php echo $Books; ?>
	                    	</ul>
	                    </div>
	                </div>
	                <?php } ?>
	                
	            </div>
	            
	            <div class="row" style="border-top:none;">

					<?php if ($Movies){ ?>
	                <div class="inputRow About">
	                    <span class="label">Movies:</span>
	                    <div class="ListRows" id="ListMusic">
	                    	<ul>
	                    		<?php echo $Movies; ?>
	                    	</ul>
	                    </div>
	                </div>
	                <?php } ?>
	                
	            </div>
	           
        		
        	</form>
        	<?php } ?>
        	
        </div>
        
        <div id="tabInterest" >
        	
        	<?php if ($Hobby){ ?>
        	
        	<form id="Interest" method="post">
        	
        		<div class="row" style="border-top:none;">

					<?php if ($Hobby){ ?>
	                <div class="inputRow About">
	                    <span class="label">Hobby:</span>
	                    <div class="ListRows" id="ListMusic">
	                    	<ul>
	                    		<?php echo $Hobby; ?>
	                    	</ul>
	                    </div>
	                </div>
	                <?php } ?>
	                
	            </div>
	            
        		
        	</form>
        	
        	<?php } ?>
        	
        </div>
        
        <div id="tabContactInformartion" >
        	
        	<?php if ($Email || $Phone || $Address){ ?>
        	
        	<form id="ContactInformartion" method="post">
        	
        		<div class="row" style="border-top:none;">

					<?php if ($Email){ ?>
	                <div class="inputRow About">
	                    <span class="label">Email:</span>
	                    <span class="inputField" style="line-height:23px;">
	                        <?php echo $Email; ?>
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	                <?php } ?>
	                
	            </div>
	            
	            <div class="row" style="border-top:none;">

					<?php if ($Phone){ ?>
	                <div class="inputRow About">
	                    <span class="label">Phone:</span>
	                    <div class="ListRows" id="ListMusic">
	                    	<ul>
	                    		<?php echo $Phone; ?>
	                    	</ul>
	                    </div>
	                </div>
	                <?php } ?>
	                
	            </div>
	            
	            <div class="row" style="border-top:none;">

					<?php if ($Address){ ?>
	                <div class="inputRow About">
	                    <span class="label">Address:</span>
	                    <span class="inputField" style="line-height:23px;">
	                       <?php echo $Address; ?>
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	                <?php } ?>
	                
	            </div>
	            
	            
        		
        	</form>
        	
        	<?php } ?>
        	
        </div>

    </div>

                </div>

            </div>
        </div>

    </div>

</div>



<script type="text/javascript">

$(function(){

	var Educeus_Account = (function(){

		var request;
		var working = false;

		var TextBoxIsi = 0;

		var CompleteProfile = $('.CompleteProfile');
		var CompleteProfile_children = CompleteProfile.children('div');
		var profileItemNavigation = $('.profileItemNavigation');
		var profileItemNavigation_children = profileItemNavigation.children('li');
		var profileItemNavigation_children_alink = profileItemNavigation_children.find('a');

		var RelationSelect = $('#relationshipStatus');
		
		var init = function(){
			Init_Profile();
		};
		
		var Init_Profile = function(){
			EventHandler();
		};

		var EventHandler = function(){

			RelationSelect.bind('change', function(){
				var el = $(this);
				var v = el.val();
				var el1 = $('#relationInput');
				var DetailList = el1.next();
				var Lists = DetailList.next();
				DetailList.find('a#RemoveList').parent().hide();
				el1.val('');
                el1.focus();
				if (v > 1) $('#relationInput').show();
				else {
					$('#relationInput').hide();
					$('#relationInput').val('');
				}
				return false;
			});
			
			profileItemNavigation_children_alink.bind('click', function(e){
				e.preventDefault();
				
				var el = $(this);
				//alert(el.parent().index());
				//alert(CompleteProfile_children.eq(el.parent().index()).attr('id'));
				var next_id = el.parent().index();
				var next_id_div = CompleteProfile_children.eq(next_id);

				var current_id = el.closest('ul').find('.current').index();
				el.parent().siblings().removeClass('current');

				
				if (next_id == current_id) return false;

				if (working) return false;
				working = true;

				CompleteProfile_children.eq(current_id).hide(0, function(){
					next_id_div.show(0, function(){
						el.parent().addClass('current');
						working = false;
					});
				});

			});

			$('#relationInput').bind('keyup', function(e){
				e.preventDefault();
				var el = $(this);

				var DetailList = el.next();
				var Lists = DetailList.next();
				
				if (working) request.abort();
				working = true;

				if (Lists.find('li').length > 0){
					if( e.keyCode == 40 ){//down key
						setSelected(+1, Lists);
						e.stopImmediatePropagation();
						e.preventDefault();
						return false;
					}
					if( e.keyCode == 38 ){//up key
						setSelected(-1, Lists);
						e.stopImmediatePropagation();
						e.preventDefault();
						return false;
					}
					if( e.keyCode == 27 ){
						e.stopImmediatePropagation();
						e.preventDefault();
						return false;	
					}
					if( e.keyCode == 13 ){//enter key
						var li = getCurrentSelected(Lists);
						if (li){
							e.stopImmediatePropagation();
							e.preventDefault();
							li.click();
						}
						return false;						
					}
				}
				
				if (el.val() == "" || e.keyCode == 13  ){
					el.val('');
					Lists.empty().hide();
					working = false;
					return false;
				}

					var DataRequest = {
						InputCurrentUser : el.val() 
					};
					request = $.post('<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=GetCurrentUser') ?>', DataRequest, function(res){
						if (res.status){
							Lists.empty().append(res.message).show();
							$(document).bind('click', function(){
								el.val('');
								Lists.empty().hide();
							});
							Lists.find('li').bind('click', function(){
								var _el = $(this);
								var UName = _el.data('UName');
								var AliasingName = _el.attr('data-UAliasingName');
								var FirstName = _el.attr('data-UFirstName');
								var LastName = _el.attr('data-ULastName');
								//alert(el.val());
								el.val(UName);
								DetailList.html(FirstName + " " + LastName + '<a href="#" id="RemoveList"></a>').show();
								DetailList.find('a#RemoveList').bind('click', function(){
									$(this).parent().hide();
									el.val('');
                                    el.focus();
									return false;
								});
								Lists.empty().hide();
								return false;
							});
						}else{
							Lists.empty().hide();
						}
						working = false;
					}, 'json');
				
			});
			
			$('#currentCity, #homeTown').bind('keyup', function(e){
				e.preventDefault();
				
				var el = $(this);
				var TextBoxHidden = el.next();
				var parentEl = el.parent();
				var DetailList = TextBoxHidden.next();
				var Lists = DetailList.next();
				
				if (working) request.abort();
				working = true;

				if (Lists.find('li').length > 0){
					if( e.keyCode == 40 ){//down key
						setSelected(+1, Lists);
						e.stopImmediatePropagation();
						e.preventDefault();
						return false;
					}
					if( e.keyCode == 38 ){//up key
						setSelected(-1, Lists);
						e.stopImmediatePropagation();
						e.preventDefault();
						return false;
					}
					if( e.keyCode == 27 ){
						e.stopImmediatePropagation();
						e.preventDefault();
						return false;	
					}
					if( e.keyCode == 13 ){//enter key
						var li = getCurrentSelected(Lists);
						if (li){
							e.stopImmediatePropagation();
							e.preventDefault();
							li.click();
						}
						return false;						
					}
				}
				
				if (el.val() == "" || e.keyCode == 13){
					el.val('');
					TextBoxHidden.val('');
					Lists.empty().hide();
					working = false;
					return false;
				}
				var DataRequest = {
					InputCurrentCity : el.val() 
				};
				request = $.post('<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=GetCurrentLocation') ?>', DataRequest, function(res){
					if (res.status){
						Lists.empty().append(res.message).show();
						$(document).bind('click', function(){
							el.val('');
							//TextBoxHidden.val('');
							Lists.empty().hide();
						});
						Lists.find('li').bind('click', function(){
							el.val('');
							el.attr('disabled', 'disabled');
							var _el = $(this);
							var CTName = _el.data('CTName');
							var CName = _el.data('CName');
							var NName = _el.data('NName');
							var CTID = _el.data('CTID');
							var CID = _el.data('CID');
							var NID = _el.data('NID');
							//TextBoxHidden.val(CTID);
							
							if (el.attr('id') == "currentCity"){
								$('#currentCity_Input').val(CTID);
							}else if (el.attr('id') === "homeTown"){
								$('#homeTown_Input').val(CTID);
								$('#national_Input').val(NID);
							}
							
							DetailList.html(CTName + '<a href="#" id="RemoveList"></a>').show();
							DetailList.find('a#RemoveList').bind('click', function(){
								$(this).parent().hide();
								el.removeAttr('disabled', 'disabled');
								$finding = ($(this).closest('.inputField').find('input:first').attr('id'));
								$(this).closest('.inputField').find('input:first').focus();
                                if ($finding == "currentCity"){
									$('#currentCity_Input').val('');
								}else if ($finding === "homeTown"){
									$('#homeTown_Input').val('');
									$('#national_Input').val('');
								}
								return false;
							});
							Lists.empty().hide();
							return false;
						});
						TextBoxIsi = 1;
					}else{
						//TextBoxHidden.val('');
						Lists.empty().hide();
						TextBoxIsi = 0;
					}
					working = false;
				}, 'json');
			}).blur(function(){
				
				var el = $(this);
				var TextBoxHidden = el.next();
				var parentEl = el.parent();
				var DetailList = TextBoxHidden.next();
				var Lists = DetailList.next();
				
				if (TextBoxIsi === 0){
					el.val('');
					//TextBoxHidden.val('');
					Lists.empty().hide();
				}

				working = false;
				
				return false;
			});

			CompleteProfile_children.find('#save').bind('click', function(e){
				e.preventDefault();

				var el = $(this);

				if (working) request.abort();
				working = true;

				el.parent().find('.loading').show();

				var url = '';
				var form = el.closest('form');
				
				var current_id = form.parent().index();
				//alert(current_id);
				if (current_id == 0){
					url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=UpdateBasicInformation') ?>';
				}else if (current_id == 1){
					url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=UpdateEmploye') ?>';
				}else if (current_id == 2){
					url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=UpdateEntertaiment') ?>';
				}else if (current_id == 3){
					url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=UpdateInterest') ?>';
				}else if (current_id == 4){
					url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxGettingStarted&Act=UpdateContactInformation') ?>';
				}

				//alert(form.serialize());
				
				var dataRequest = '';

				if (current_id == 0 || current_id == 1){
					dataRequest = form.serialize();
				}else if (current_id == 2){
					ArrMusic.join(',');
					ArrBooks.join(',');
					ArrMovie.join(',');
					dataRequest = {
						Musics : ArrMusic,
						Books : ArrBooks,
						Movies : ArrMovie
					};
				}else if (current_id == 3){
					ArrHobby.join(',');
					dataRequest = {
						Hobby : ArrHobby
					};
				}else if (current_id == 4){
					ArrPhone.join(',');
					dataRequest = {
						Phone : ArrPhone,
						Email : $('#email').val(),
						Address : $('#address').val()
					};
				}

				
				
				if (url){
				request = $.post(url, dataRequest, function(res){
					if (res.status == 1){
						el.parent().find('.loading').hide();
						if (current_id == 4){
							//window.location = '<?php echo Config::Instance('default')->baseUrl . 'Account/GettingStarted/ProfilePicture'; ?>';
							window.location = '<?php echo $URI->WriteURI('App=Account&Com=EditProfilePicture') ?>';
						}else
						form.find('#skip').click();
					}else if (res.status == 0){
						alert(res.message);
						el.parent().find('.loading').hide();
					}
					working = false;
				}, 'json');
				}
				
				//el.parent().find('.loading').hide();
				
			});

            CompleteProfile_children.find('.back').bind('click', function(e){
                
                e.preventDefault();
				var el = $(this);

				var form = el.closest('form');

				var current_id = form.parent().index();
				var prev_id_div = current_id - 1;

                CompleteProfile_children.eq(current_id).hide(0, function(){
					CompleteProfile_children.eq(prev_id_div).show(0, function(){
						profileItemNavigation_children.siblings().removeClass('current');
						profileItemNavigation_children.eq(prev_id_div).addClass('current');
					});
				});
            });

			CompleteProfile_children.find('#skip').bind('click', function(e){
				e.preventDefault();
				var el = $(this);

				var form = el.closest('form');

				var current_id = form.parent().index();
				var next_id_div = current_id + 1;
				
				CompleteProfile_children.eq(current_id).hide(0, function(){
					CompleteProfile_children.eq(next_id_div).show(0, function(){
						profileItemNavigation_children.siblings().removeClass('current');
						profileItemNavigation_children.eq(next_id_div).addClass('current');
					});
				});
				
			});

			$('.inputField').find('a#RemoveList').bind('click', function(){
				var el = $(this);
				el.parent().hide();
				$finding = (el.closest('.inputField').find('input:first').attr('id'));
                el.closest('.inputField').find('input:first').focus();
				if ($finding == "currentCity"){
					$('#currentCity_Input').val('');
				}else if ($finding == "homeTown"){
					$('#homeTown_Input').val('');
					$('#national_Input').val('');
				}else if ($finding == "relationInput"){
					$('#relationInput').val('');
				}
				return false;
			});

			CompleteProfile_children.find('.AddLists').bind('click', function(e){
				e.preventDefault();
				var el = $(this);

				var div_input = el.prev();
				var input = div_input.val();

				if (!input) return false;

				var current = div_input.attr('name');

				if (current == 'music'){
				ArrMusic.push(input);
				}else if (current == 'books'){
				ArrBooks.push(input);
				}else if (current == 'movies'){
				ArrMovie.push(input);
				}else if (current == 'hobby'){
				ArrHobby.push(input);
				}else if (current == 'phone'){
				ArrPhone.push({
					Type : div_input.prev().val(),
					Phone : input
				});
				var TypePhone = div_input.prev().val();
				if (TypePhone == 1) TypePhone = 'Work';
				if (TypePhone == 2) TypePhone = 'Home';
				if (TypePhone == 3) TypePhone = 'Mobile';
				}

				div_input.val('');

				if (current == 'phone'){
					el.closest('.inputRow').find('.ListRows ul')
					.append($('<li>'+TypePhone+' - '+input+'<a href="#" data-Value="'+input+'" class="RemoveListMusic"></a></li>').hide().fadeIn());
				}else{
				el.closest('.inputRow').find('.ListRows ul')
				.append($('<li>'+input+'<a href="#" data-Value="'+input+'" class="RemoveListMusic"></a></li>').hide().fadeIn());
				}
				
			});

			$('.ListRows').find('a.RemoveListMusic').live('click', function(e){
				e.preventDefault();
				var el = $(this);
				var v = el.data('Value');

				var div_input = el.closest('.inputRow').find('input:first').attr('name');

				//alert(div_input);
				
				if (div_input == 'music'){
				for(var i=0; i<ArrMusic.length; i++){
					if (ArrMusic[i] == v){
						ArrMusic[i] = '';
						break;
					}
				}
				}else if (div_input == 'books'){
					for(var i=0; i<ArrBooks.length; i++){
						if (ArrBooks[i] == v){
							ArrBooks[i] = '';
							break;
						}
					}
				}else if (div_input == 'movies'){
					for(var i=0; i<ArrMovie.length; i++){
						if (ArrMovie[i] == v){
							ArrMovie[i] = '';
							break;
						}
					}
				}else if (div_input == 'hobby'){
					for(var i=0; i<ArrHobby.length; i++){
						if (ArrHobby[i] == v){
							ArrHobby[i] = '';
							break;
						}
					}
				}else if (div_input == 'phone'){
					for(var i=0; i<ArrPhone.length; i++){
						if (ArrPhone[i].Phone == v){
							ArrPhone[i].Phone = '';
							ArrPhone[i].Type = '';
							break;
						}
					}
				}

				el.parent().hide().remove();
				
			});
			
		};

		var getCurrentSelected = function(data){
			var selected = data.find('li.activeLi');
			if (selected.length == 1) return selected;
			return null;
		};
		
		var setSelected = function(dir, data){
			var selected = data.find('li.activeLi');
			if (selected.length != 1){
				if (dir > 0){
					data.find('li:first-child').addClass('activeLi');
				}else{
					data.find('li:last-child').addClass('activeLi');
				}
				return;
			}
			selected.removeClass('activeLi');
			if (dir > 0){
				selected.next().addClass('activeLi');
			}else{
				selected.prev().addClass('activeLi');
			}
		};

		return {
			init : init
		}
		
	})();

	Educeus_Account.init();


    $.each($(".DetailList"), function() {
        var width = $($($(this).parents(".inputField")).find("input[type=text]")).width();
        $(this).css("width", (width+2)+'px');
    });

    $.each($(".ListAutoComplete"), function() {
        var width = $($($(this).parents(".inputField")).find("input[type=text]")).width();
        $(this).css("width", (width+10)+'px');
    });

});
	
</script>
