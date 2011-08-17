<div class="BoxContentBordered GettingStarted">

    <div id="friendsHeaderFixed">
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

                <li>
                    <span class="NumStep">2</span>
                    <span class="Text">
                        <span class="Title">Profile Picture</span>
                        <span class="Description">Upload your profile picture</span>
                    </span>
                </li>

                <li class="LastStep Current">
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
    </div>
    
    <div id="findFriendsGettingStartedContainer">

        <div class="leftColumn">
            <div id="friendSearchBox">
                <h2 class="title">Find Friends</h2>
                <div class="rightArrow"></div>

                <div class="ClearFix"></div>

                <form method="post" action="">

                    <div class="row">
                        <div class="label">People's Name:</div>
                        <div class="inputField">
                            <input autocomplete="off" type="text" name="peopleName" id="peopleName" class="inputPeopleName" value="Type Name of People" />
                        	<div class="DetailList" style="display:none; margin: -21px 0 0 1px; height: 13px"><a href="#" id="RemoveList">X</a></div>
	                        <ul class="ListAutoComplete ListFindName" id="ListFindName" style="display:none; padding: 0; margin: 0;">
	                    	</ul>
                        </div>
                    </div>
                    
                    <input type="hidden" name="HiddenFirstName" id="HiddenFirstName" value="" />
                    <input type="hidden" name="HiddenLastName" id="HiddenLastName" value="" />

                    <div class="row">
                        <div class="label">Location:</div>
                        <div class="inputField">

                                <input autocomplete="off" style="margin: 0; width:165px" type="text" name="currentCity" id="currentCity" value="Current City" />
                                <div class="DetailList" style="display:none; margin: -21px 0 0 1px; height: 13px"><a href="#" id="RemoveList"></a></div>
                                <ul class="ListAutoComplete ListCurrentCity" id="ListCurrentCity" style="display:none; padding: 0; margin: 0;">
                                </ul>



                                <input autocomplete="off" style="margin: 0; width: 158px" type="text" name="hometown" id="hometown" value="Hometown" />
                                <div class="DetailList" style="display:none; margin: -21px 0 0 181px; height: 13px"><a href="#" id="RemoveList"></a></div>
                                <ul class="ListAutoComplete ListCurrentHomeTown" id="ListCurrentHomeTown" style="display:none; padding: 0; margin: 0 0 0 180px; ">
                                </ul>

                            
                        </div>
                    </div>
                    
                    <input type="hidden" name="currentCity_Input" size="60" id="currentCity_Input" value="" />
					 <input type="hidden" name="homeTown_Input" size="60" id="homeTown_Input" value="" />	

                    <div class="row">
                        <div class="label">Gender & Relationship Status:</div>
                        <div class="inputField">
                            <select name="gender" id="gender">
                                <option value="0" selected="selected">- Gender -</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <select name="relationshipStatus" id="relationshipStatus">
                                <option value="0" selected="selected">- Relationship Status -</option>
                                <option value="single">Single</option>
                                <option value="In a relationship">In a relationship</option>
                                <option value="Engaged">Engaged</option>
                                <option value="Married">Married</option>
                                <option value="It's complicated">It's complicated</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="label">Interested In:</div>
                        <div class="inputField">
                            <input type="checkbox" value="women" name="interestedIn[]" id="women" class="checkbox">&nbsp;<label for="women">Women</label>
                            <br />
                            <input type="checkbox" value="men" name="interestedIn[]" id="men" class="checkbox">&nbsp;<label for="men">Men</label>
                        </div>
                    </div>
                    
                    <input type="hidden" name="SearchInput" value="1" />

                    <div class="row">
                        <div class="Right">
                            <span class="buttonGray"><input type="reset" name="reset" id="reset" value="Reset" class="button" /></span>
                            <div class="Left">&nbsp;</div>
                            <span class="buttonOrange">
                            <a href="#" id="search" class="button" style="line-height:10px;">Search Friends</a>
                            </span>
                        </div>
                        <div class="ClearFix"></div>
                    </div>

                </form>
                <br />
                <div class="HrGrayWhite"></div>
                <br />
                <div class="Left">
                    <span class="buttonGray"><a href="<?php URI::WriteURI('App=Account&Com=GettingStarted&Act=ProfilePicture')?>" class="button"><img src="<?php echo Path::Template('Images/back_arrow.png')?>" />&nbsp;Back</a></span>
                </div>

                <div class="Right">
                    <span class="buttonBlue"><input type="submit" name="save" id="save" value="Finish" class="button" /></span>
                </div>
            </div>
            <div class="ClearFix"></div>
        </div>

        <div class="rightColumn" style="min-height:450px;">
            <div class="ListLoading" style="display:none;"><img src="<?php echo Path::Template('Images/loading.gif')?>" /></div>
            <ul class="friendsList" id="friendsList">
					
				<!--<li class="ListLoading" style="display:none;"><img src="<?php echo Path::Template('Images/loading.gif')?>" /></li>-->
                <?php echo $FriendsDefault; ?>
                
            </ul>

			<!--
            <div id="moreNavigation">
                <a href="">see more people &raquo;</a>
            </div>
            -->
        </div>

        <div class="ClearFix"></div>
    </div>

</div>
<div class="Left"></div>


<script type="text/javascript">

$(function(){

	$.fn.defaultText = function(val){
		var el = this.eq(0);
		el.data('text',val);
		el.focus(function(){
			if (el.val() == val){
				el.val('').removeClass('text');
                el.addClass('textActive');
			}
		}).blur(function(){
			if (el.val() == ''){
				el.addClass('text').val(val);
                el.removeClass('textActive');
			}
		});
		return el.blur();
	}
	
	var Educeus_Account = (function(){

		var friendsList = $('#friendsList');
		var friendsList_Li = friendsList.children('li');
		var Follow = friendsList.find('#follow');
		var ListLoading = $('.ListLoading');

		var request;
		var working = false;

		var peopleName = $('#peopleName');
		var currentCity = $('#currentCity');
		var hometown = $('#hometown');

		var TextBoxIsi = 0;
		
		var init = function(){
			peopleName.defaultText('Type Name of People');
			currentCity.defaultText('Current City');
			hometown.defaultText('Hometown');
			Init_ProfileFindFriends();
		};
		
		var Init_ProfileFindFriends = function(){
			EventHandler();
		};

		var EventHandler = function(){

			$('#save').bind('click', function(){
				window.location = '<?php URI::WriteURI('App=Account&Com=GettingStarted&Act=Finish'); ?>';
			});
			
			$('#search').bind('click', function(e){
				e.preventDefault();
				var el = $(this);

				if (working) request.abort();
				working = true;

				ListLoading.show();
				
				var form = el.closest('form');
				var DataRequest = form.serialize();
				//alert($('#currentCity').val() + "-" + $('#hometown').val());
				request = $.post('<?php echo $URI->WriteURI('App=Account&Com=AjaxFriends&Act=SearchFriend') ?>', DataRequest, function(res){

					friendsList.empty();
					friendsList.append(res.message);
					
					ListLoading.hide();

					working = false;
					
				}, 'json');
				
			});
			
			$('#reset').bind('click', function(e){
				e.preventDefault();

				
				peopleName.val('');
				currentCity.val('');
				hometown.val('');
				
				
				peopleName.defaultText('Type Name of People');
				currentCity.defaultText('Current City');
				hometown.defaultText('Hometown');

				$('#gender').val(0);
				$('#relationshipStatus').val(0);
				$('.DetailList').hide();
				$('.checkbox').removeAttr('checked');
				$('#HiddenFirstName').val('');
				$('#HiddenLastName').val('');
				$('#currentCity_Input').val('');
				$('#homeTown_Input').val('');
			});
			
			$('#peopleName').bind('keyup', function(e){
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

				if (el.val() == ""){
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

								Lists.empty().hide();
							});
							Lists.find('li').bind('click', function(){
								var _el = $(this);
								var UName = _el.data('UName');
								var AliasingName = _el.attr('data-UAliasingName');
								var FirstName = _el.attr('data-UFirstName');
								var LastName = _el.attr('data-ULastName');
								//alert(el.val());
								el.val(FirstName +" "+ LastName);
								$('#HiddenFirstName').val(FirstName);
								$('#HiddenLastName').val(LastName);
								DetailList.html(FirstName + " " + LastName + '<a href="#" id="RemoveList"></a>').show();
								DetailList.find('a#RemoveList').bind('click', function(){
									$(this).parent().hide();
									el.val('');
									$('#HiddenFirstName').val('');
									$('#HiddenLastName').val('');
                                    $('#peopleName').focus();
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

			$('#currentCity, #hometown').bind('keyup', function(e){
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
					
				if (el.val() == "" || e.keyCode == 13){
					el.val('');
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
						//setSelected(+1, Lists);
						
						$(document).bind('click', function(){
							Lists.empty().hide();
						});
						Lists.find('li').bind('click', function(){
							var _el = $(this);
							var CTName = _el.data('CTName');
							var CName = _el.data('CName');
							var NName = _el.data('NName');
							var CTID = _el.data('CTID');
							var CID = _el.data('CID');
							var NID = _el.data('NID');
							TextBoxIsi = 1;
							if (el.attr('id') == "currentCity"){
								$('#currentCity_Input').val(CTID);
								//$('#currentCity').val(CTID);
								//console.log(el.val());
							}else if (el.attr('id') === "hometown"){
								$('#homeTown_Input').val(CTID);
								//$('#national_Input').val(NID);
								//$('#hometown').val(CTID);
								//console.log(el.val());
							}

							DetailList.html(CTName + '<a href="#" id="RemoveList"></a>').show();
							DetailList.find('a#RemoveList').bind('click', function(){
								
								$(this).parent().hide();
								if (el.attr('id') == "currentCity"){
									$('#currentCity_Input').val('');
									$('#currentCity').val('');
                                    $('#currentCity').focus();
									//console.log(el.val());
								}else if (el.attr('id') === "hometown"){
									$('#homeTown_Input').val('');
									$('#national_Input').val('');
									$('#hometown').val('');
                                    $('#hometown').focus();
                                    //hometown.defaultText('Hometown');
									//console.log(el.val());
								}
								TextBoxIsi = 0;
								
								return false;
							});
							Lists.empty().hide();
							return false;
						});
					}else{
						TextBoxHidden.val('');
						Lists.empty().hide();
					}
					TextBoxIsi = 0;
					working = false;
				}, 'json');
			});
			
			Follow.live('click', function(){
				var el = $(this);
				var parent = el.closest('li');
				var UName = parent.data('UName');
				var AliasingName = parent.attr('data-AliasingName');
				var value = el.attr('value');
				
				if (working) request.abort();
				working = true;

				var url;var n;
				if (value == 'Follow'){
				url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxFriends&Act=FollowFriend') ?>';
				n = 'Un Follow';
				}else{
				url = '<?php echo $URI->WriteURI('App=Account&Com=AjaxFriends&Act=UnFollowFriend') ?>';
				n = 'Follow';
				}
				
				var DataRequest = { 
					EDU_TOKENUNAME : UName
				};
                
				request = $.post(url, DataRequest, function(res){
					if (n == 'Un Follow'){
					    el.parent().removeClass('buttonOrange').addClass('buttonGray');
					}else{
					    el.parent().removeClass('buttonGray').addClass('buttonOrange');
					}
					el.attr('value', n);
					working = false;
				}, 'json');

				return false;
				
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
		};
		
	})();

	Educeus_Account.init();

    $.each($(".DetailList"), function() {
        var width = $(this).prev().width();
        $(this).css("width", (width+2)+'px');
    });

    $.each($(".ListAutoComplete"), function() {
        var width = $($(this).prev()).prev().width();
        $(this).css("width", (width+10)+'px');
    });
});


</script>
