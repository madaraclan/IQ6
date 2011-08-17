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
                    <div class="header">Menu</div>
                    <div class="content">
                       	<ul class="profileItemNavigation">
            <li class="current">
                <a href="">
                    <span class="Icon16 iconBasicInformation16"></span>
                    <span class="title">Basic Information</span>
                </a>
            </li>

            <li>
                <a href="">
                    <span class="Icon16 iconWork16"></span>
                    <span class="title">Education and Work</span>
                </a>
            </li>

            <li>
                <a href="">
                    <span class="Icon16 iconEntertainment16"></span>
                    <span class="title">Arts and Entertainment</span>
                </a>
            </li>

            <li>
                <a href="">
                    <span class="Icon16 iconActivities16"></span>
                    <span class="title">Hobbies</span>
                </a>
            </li>

            <li>
                <a href="">
                    <span class="Icon16 iconContact16"></span>
                    <span class="title">Contact Information</span>
                </a>
            </li>

            <li class="last"><a href=""></a></li>

        </ul>
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
                            <li><a href="<?php $URI->WriteURI('App=Account&Com=EditProfile'); ?>">Edit Profile</a></li>
                            <li><a href="<?php $URI->WriteURI('App=Account&Com=EditProfilePicture'); ?>">Edit Profile Picture</a></li>
                            <li><a href="<?php $URI->WriteURI('App=Account&Com=Profile'); ?>">Back to Profile</a></li>
                        </ul>
                        <div class="ClearFix"></div>
                    </div>

                  	<div class="CompleteProfile" style="margin-top:50px;">

        <div id="tabBasicInformation">
			
			<form id="BasicInformation" method="post">
			
			<div class="row">

                <div class="inputRow">
                    <span class="label">First Name:</span>
                    <span class="inputField">
                        <input type="text" name="firstname" size="60" id="firstname" value="<?php echo $FirstName; ?>" autocomplete="off" />
                    </span>
                    <div class="ClearFix"></div>
                </div>
                
                <div class="inputRow">
                    <span class="label">Last Name:</span>
                    <span class="inputField">
                        <input type="text" name="lastname" size="60" id="lastname" value="<?php echo $LastName; ?>" autocomplete="off" />
                    </span>
                    <div class="ClearFix"></div>
                </div>
							
            </div>
			
            <div class="row">

                <div class="inputRow">
                    <span class="label">Current City:</span>
                    <span class="inputField">
                        <input type="text" name="currentCity" size="60" id="currentCity" autocomplete="off" />
                        <input type="hidden" name="currentCity_Input" size="60" id="currentCity_Input" value="<?php echo ($CurrentCity ? $CurrentCity->CTID : ''); ?>" />
                        <div class="DetailList" style="<?php echo ($CurrentCity ? 'display:block;' : 'display:none;'); ?>"><?php echo ($CurrentCity ? $CurrentCity->CTName : ''); ?><a href="#" id="RemoveList"></a></div>
                        <ul class="ListAutoComplete ListCity" id="ListCity">
                    	</ul>
                    </span>
                    <div class="ClearFix"></div>
                </div>

                <div class="inputRow">
                    <span class="label">Hometown:</span>
                    <span class="inputField">
                        <input type="text" name="homeTown" size="60" id="homeTown" autocomplete="off" />
                        <input type="hidden" name="homeTown_Input" size="60" id="homeTown_Input" value="<?php echo ($Hometown ? $Hometown->CTID : ''); ?>" />
                        <div class="DetailList" style="<?php echo ($Hometown ? 'display:block;' : 'display:none;'); ?>"><?php echo ($Hometown ? $Hometown->CTName : ''); ?><a href="#" id="RemoveList"></a></div>
                    	<ul class="ListAutoComplete ListHomeTown" id="ListHomeTown">
                    	</ul>
                    </span>
                    <div class="ClearFix"></div>
                </div>
				
				 <input type="hidden" name="national_Input" size="60" id="national_Input" value="<?php echo ($Nationality ? $Nationality->NID : ''); ?>" />
			
            </div>

            <div class="row">

                <div class="inputRow">
                    <span class="label">Religion:</span>
                    <span class="inputField">
                        <select name="religion" id="religion">
                        	<?php 
                        		$IslamSelected = '';
                        		$KristenSelected = '';
                        		$KatolikSelected = '';
                        		$HinduSelected = '';
                        		$BudhaSelected = '';
								switch($Religion){
									case 'Islam':$IslamSelected='selected';break;
									case 'Kristen':$KristenSelected='selected';break;
									case 'Katolik':$KatolikSelected='selected';break;
									case 'Hindu':$HinduSelected='selected';break;
									case 'Budha':$BudhaSelected='selected';break;
								}
                        	?>
                            <option value="Islam" <?php echo $IslamSelected; ?>>Islam</option>
                            <option value="Kristen" <?php echo $KristenSelected; ?>>Kristen</option>
                            <option value="Katolik" <?php echo $KatolikSelected; ?>>Katolik</option>
                            <option value="Hindu" <?php echo $HinduSelected; ?>>Hindu</option>
                            <option value="Budha" <?php echo $BudhaSelected; ?>>Budha</option>
                        </select>
                    </span>
                    <div class="ClearFix"></div>
                </div>

                <div class="inputRow">
                    <span class="label">I Am:</span>
                    <span class="inputField">
                        <select name="gender" id="gender">
                        	<?php
                        		$MaleSelected = '';
                        		$FemaleSelected = '';
                        		switch($Gender){
                        			case 'Male':$MaleSelected = 'selected';break;
                        			case 'Female':$FemaleSelected = 'selected';break;
                        		}
                        	?>
                            <option value="Male" <?php echo $MaleSelected; ?>>Male</option>
                            <option value="Female" <?php echo $FemaleSelected; ?>>Female</option>
                        </select>
                    </span>
                    <div class="ClearFix"></div>
                </div>

            </div>

            <div class="row">

                <div class="inputRow">
                    <span class="label">Birthday:</span>
                    <span class="inputField">
                        <?php
                        $arrMonthName   = array("Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec");
                        $Birthday = explode('-', $Birthday);
                        ?>
                        <select name="bdayMonth" id="bdayMonth">
                            <?php
                            $i = 0;
                            foreach($arrMonthName as $monthName):
                            	$MonthSelected = '';
                            	if ($Birthday[1] == ($i+1)) $MonthSelected = 'selected';
                            ?>
                                <option value="<?php echo ($i+1); ?>" <?php echo $MonthSelected; ?>><?php echo $monthName?></option>
                            <?php
                                $i++;
                            endforeach;
                            ?>
                        </select>
                        <select name="bdayDay" id="bdayDay">
                            <?php
                                for($i = 1; $i <= 31; $i++):
                                	$DaySelected = '';
                            		if ($Birthday[2] == $i) $DaySelected = 'selected';
                                    ?>
                                    <option value="<?php echo $i?>" <?php echo $DaySelected; ?>><?php echo $i?></option>
                                    <?php
                                endfor;
                            ?>
                        </select>
                        <select name="bdayYear" id="bdayYear">
                            <?php
                                for($i = date("Y"); $i >= 1905; $i--):
                                	$YearSelected = '';
                            		if ($Birthday[0] == $i) $YearSelected = 'selected';
                                    ?>
                                    <option value="<?php echo $i?>" <?php echo $YearSelected; ?>><?php echo $i?></option>
                                    <?php
                                endfor;
                            ?>
                        </select>
                        <div class="ClearFix"></div>
                        <br />
                        <select name="optionShowBirthday" id="optionShowBirthday">
                        	<?php 
								$Opt0 = '';
								$Opt1 = '';
								$Opt2 = '';
								switch($ShowBirthday){
									case 0:$Opt0 = 'selected';break;
									case 1:$Opt1 = 'selected';break;
									case 2:$Opt2 = 'selected';break;
								}
                        	?>
                            <option value="0" <?php echo $Opt0; ?>>Show my full birhtday in my profile.</option>
                            <option value="1" <?php echo $Opt1; ?>>Show only month & day in my profile.</option>
                            <option value="2" <?php echo $Opt2; ?>>Don't show my birthday in my profile.</option>
                        </select>
                    </span>
                    <div class="ClearFix"></div>
                </div>

            </div>

            <div class="row">

                <div class="inputRow">
                    <span class="label">Relation Status:</span>
                    <span class="inputField">
                        <select name="relationshipStatus" id="relationshipStatus">
                            <option value="1" <?php echo ($RelationType == 1 ? 'selected' : ''); ?>>Single</option>
                            <option value="2" <?php echo ($RelationType == 2 ? 'selected' : ''); ?>>In a relationship</option>
                            <option value="3" <?php echo ($RelationType == 3 ? 'selected' : ''); ?>>Engaged</option>
                            <option value="4" <?php echo ($RelationType == 4 ? 'selected' : ''); ?>>Married</option>
                            <option value="5" <?php echo ($RelationType == 5 ? 'selected' : ''); ?>>It's complicated</option>
                        </select>
                        <br /><br />
                        <input type="text" name="relationInput" size="60" id="relationInput" autocomplete="off" style="<?php echo ($RelationURToUName ? 'display:inline;' : 'display:none;'); ?> " value="<?php echo $RelationURToUName; ?>" />
                    	<div class="DetailList" style="<?php echo ($RelationURToUName ? 'display:block;' : 'display:none;'); ?>"><?php echo ($RelationURToUName ? $RelationURToUName_FirstName.' '.$RelationURToUName_LastName : ''); ?><a href="#" id="RemoveList"></a></div>
                    	<ul class="ListAutoComplete ListName" id="ListName">
                    	</ul>
                    </span>
                    <div class="ClearFix"></div>
                </div>

                <div class="inputRow">
                    <span class="label">Interested In:</span>
                    <span class="inputField">
                    	<?php 
                    	$Interest = (explode(', ', $Interest)); 
                    	$MenSelected = '';
                    	$WomenSelected = '';
                    	if (isset($Interest[0])){
                    		if ($Interest[0] == 'men') $MenSelected = 'checked';
                    		if ($Interest[0] == 'women') $WomenSelected = 'checked';
                    	}
                    	if (isset($Interest[1])){
                    		if ($Interest[1] == 'men') $MenSelected = 'checked';
                    		if ($Interest[1] == 'women') $WomenSelected = 'checked';
                    	}
                    	?>
                        <input type="checkbox" id="interestedIn" value="women" name="interestedIn[]" id="women" <?php echo $WomenSelected; ?>>&nbsp;<label for="women">Women</label>
                        <br />
                        <input type="checkbox" id="interestedIn" value="men" name="interestedIn[]" id="men" <?php echo $MenSelected; ?>>&nbsp;<label for="men">Men</label>
                    </span>
                    <div class="ClearFix"></div>
                </div>

            </div>

            <div class="row">

                <div class="inputRow">
                    <span class="label">About Me:</span>
                    <span class="inputField">
                        <textarea rows="5" cols="60" name="aboutMe" id="aboutMe"><?php echo $AboutMe; ?></textarea>
                    </span>
                    <div class="ClearFix"></div>
                </div>

            </div>

            <div class="row">

                <div class="inputRow">
                    <span class="label"></span>
                    <span class="inputField" style="float:right; margin-right: 170px;">
                        <span class="buttonBlue">
                        <a href="#" id="save" class="button" style="line-height:10px;">Save & Continue</a>
                        </span>
                        <span class="Left">&nbsp;</span>
                        <span class="buttonGray"><a href="#" id="skip" class="button">Skip&nbsp;<img src="<?php echo Path::Template('Images/next_arrow.png')?>" /></a></span>
                        <img src="<?php echo Path::Template('Images/loading.gif')?>" alt="" class="loading" />
                    </span>
                    <div class="ClearFix"></div>
                </div>

            </div>

			</form>

        </div>
        
        <div id="tabEducationWork" style="display:none;">
        	
        	<form id="EducationWork" method="post">
        	
        		<div class="row">

	                <div class="inputRow">
	                    <span class="label">Employers At:</span>
	                    <span class="inputField">
	                        <input type="text" name="employers" size="60" id="employers" value="<?php echo $EmployersAt; ?>" />
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	                
	            </div>
	            
	            <div class="row">

	                <div class="inputRow">
	                    <span class="label"></span>
	                    <span class="inputField" style="float: left">
                            <span class="buttonGray"><a href="#" class="button back"><img src="<?php echo Path::Template('Images/back_arrow.png')?>" />&nbsp;Back</a></span>
                        </span>
                        <span class="inputField" style="float: right; margin-right: 170px;">
	                        <span class="buttonBlue"><input type="submit" name="save" id="save" value="Save & Continue" class="button" /></span>
	                        <span class="Left">&nbsp;</span>
                            <span class="buttonGray"><a href="#" class="button" id="skip">Skip&nbsp;<img src="<?php echo Path::Template('Images/next_arrow.png')?>" /></a></span>
	                        <img src="<?php echo Path::Template('Images/loading.gif')?>" alt="" class="loading" />
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	
	            </div>
	            
        		
        	</form>
        	
        </div>
        
        <div id="tabArtEntertainment" style="display:none;">
        	
        	<form id="ArtEntertainment" method="post">
        	
        		<div class="row">

	                <div class="inputRow">
	                    <span class="label">Music:</span>
	                    <span class="inputField">
	                        <input type="text" name="music" size="60" id="music" value="" />
	                        <a href="#" class="uibutton small AddLists" style="display:block;" id="AddMusic" >Add</a>
	                    </span>
	                    
	                    <div class="ClearFix"></div>
	                    
	                    <div class="ListRows" id="ListMusic">
	                    	<ul>
	                    		<?php echo $Musics; ?>
	                    	</ul>
	                    </div>
	                    
	                </div>
	                
	            </div>
	            
	            <div class="row">

	                <div class="inputRow">
	                    <span class="label">Books:</span>
	                    <span class="inputField">
	                        <input type="text" name="books" size="60" id="books" value="" />
	                        <a href="#" class="uibutton small AddLists" style="display:block;" id="AddMusic">Add</a>
	                    </span>
	                    <div class="ClearFix"></div>
	                    <div class="ListRows" id="ListMusic">
	                    	<ul>
	                    		<?php echo $Books; ?>
	                    	</ul>
	                    </div>
	                </div>
	                
	            </div>
	            
	            <div class="row">

	                <div class="inputRow">
	                    <span class="label">Movies:</span>
	                    <span class="inputField">
	                        <input type="text" name="movies" size="60" id="movies" value="" />
	                        <a href="#" class="uibutton small AddLists" style="display:block;" id="AddMusic">Add</a>
	                    </span>
	                    <div class="ClearFix"></div>
	                    <div class="ListRows" id="ListMusic">
	                    	<ul>
	                    		<?php echo $Movies; ?>
	                    	</ul>
	                    </div>
	                </div>
	                
	            </div>
	            
	            <div class="row">

	                <div class="inputRow">
	                    <span class="label"></span>
	                    <span class="inputField" style="float: left">
                            <span class="buttonGray"><a href="#" class="button back"><img src="<?php echo Path::Template('Images/back_arrow.png')?>" />&nbsp;Back</a></span>
                        </span>
                        <span class="inputField" style="float: right; margin-right: 170px;">
	                        <span class="buttonBlue"><input type="submit" name="save" id="save" value="Save & Continue" class="button" /></span>
	                        <span class="Left">&nbsp;</span>
                            <span class="buttonGray"><a href="#" class="button" id="skip">Skip&nbsp;<img src="<?php echo Path::Template('Images/next_arrow.png')?>" /></a></span>
	                        <img src="<?php echo Path::Template('Images/loading.gif')?>" alt="" class="loading" />
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	
	            </div>
	            
        		
        	</form>
        	
        </div>
        
        <div id="tabInterest" style="display:none;">
        	
        	<form id="Interest" method="post">
        	
        		<div class="row">

	                <div class="inputRow">
	                    <span class="label">Hobby:</span>
	                    <span class="inputField">
	                        <input type="text" name="hobby" size="60" id="hobby" value="" />
	                        <a href="#" class="uibutton small AddLists" style="display:block;" id="AddMusic">Add</a>
	                    </span>
	                    <div class="ClearFix"></div>
	                    <div class="ListRows" id="ListMusic">
	                    	<ul>
	                    		<?php echo $Hobby; ?>
	                    	</ul>
	                    </div>
	                </div>
	                
	            </div>
	            
	            <div class="row">

	                <div class="inputRow">
	                    <span class="label"></span>
	                    <span class="inputField" style="float: left">
                            <span class="buttonGray"><a href="#" class="button back"><img src="<?php echo Path::Template('Images/back_arrow.png')?>" />&nbsp;Back</a></span>
                        </span>
                        <span class="inputField" style="float: right; margin-right: 170px;">
	                        <span class="buttonBlue"><input type="submit" name="save" id="save" value="Save & Continue" class="button" /></span>
	                        <span class="Left">&nbsp;</span>
                            <span class="buttonGray"><a href="#" class="button" id="skip">Skip&nbsp;<img src="<?php echo Path::Template('Images/next_arrow.png')?>" /></a></span>
	                        <img src="<?php echo Path::Template('Images/loading.gif')?>" alt="" class="loading" />
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	
	            </div>
	            
        		
        	</form>
        	
        </div>
        
        <div id="tabContactInformartion" style="display:none;">
        	
        	<form id="ContactInformartion" method="post">
        	
        		<div class="row">

	                <div class="inputRow">
	                    <span class="label">Email:</span>
	                    <span class="inputField">
	                        <input type="text" name="email" size="60" id="email" value="<?php echo $Email; ?>" />
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	                
	            </div>
	            
	            <div class="row">

	                <div class="inputRow">
	                    <span class="label">Phone:</span>
	                    <span class="inputField">
	                       	<select name="TypePhone">
	                       		<option value="1">Work</option>
	                       		<option value="2">Home</option>
	                       		<option value="3">Mobile</option>
	                       	</select> 
	                       	<input type="text" name="phone" size="60" id="phone" value="" />
	                       	<a href="#" class="uibutton small AddLists" style="display:block;" id="AddMusic">Add</a>
	                    </span>
	                    <div class="ClearFix"></div>
	                    <div class="ListRows" id="ListMusic">
	                    	<ul>
	                    		<?php echo $Phone; ?>
	                    	</ul>
	                    </div>
	                </div>
	                
	            </div>
	            
	            <div class="row">

	                <div class="inputRow">
	                    <span class="label">Address:</span>
	                    <span class="inputField">
	                        <input type="text" name="address" size="60" id="address" value="<?php echo $Address; ?>" />
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	                
	            </div>
	            
	            <div class="row">

	                <div class="inputRow">
	                    <span class="label"></span>
	                    <span class="inputField" style="float: left">
                            <span class="buttonGray"><a href="#" class="button back"><img src="<?php echo Path::Template('Images/back_arrow.png')?>" />&nbsp;Back</a></span>
                        </span>
                        <span class="inputField" style="float: right; margin-right: 170px;">
	                        <span class="buttonBlue"><input type="submit" name="save" id="save" value="Save & Continue" class="button" /></span>
                            <span class="Left">&nbsp;</span>
                            <span class="buttonGray"><a href="<?php echo URI::ReturnURI('App=Account&Com=GettingStarted&Act=ProfilePicture')?>" class="button">Skip&nbsp;<img src="<?php echo Path::Template('Images/next_arrow.png')?>" /></a></span>
	                        <img src="<?php echo Path::Template('Images/loading.gif')?>" alt="" class="loading" />
	                    </span>
	                    <div class="ClearFix"></div>
	                </div>
	
	            </div>
	            
        		
        	</form>
        	
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
