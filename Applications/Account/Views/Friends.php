
<div id="SubNavigation">
    <div class="ContentWrapper">
        <div class="listSubNavigation">
            <a class="" href="<?php $URI->WriteURI('App=Account&Com=NewsFeeds'); ?>"><span class="Icon16 IconHome16"></span></a>
            <a  href="<?php $URI->WriteURI('App=Account&Com=Profile'); ?>"><span class="Icon16 IconProfile16"></span></a>
            <a class="current" href="<?php $URI->WriteURI('App=Account&Com=FindFriends&Act=Search'); ?>"><span class="Icon16 IconFriends16"></span></a>
        </div>
        <div class="QuickSearchContainer">
            <span class="QuickSearch">
               
            </span>
        </div>
    </div>
</div>

<div id="Middle" >

    <div class="ContentWrapper">

        <div class="ContentTwoLayout">
            <div class="LeftColumn">

            </div>
            <div class="RightColumn">

                <div id="DetailProfile">


                    <div class="tabInformation">
                        <ul class="tabInformationList">
                            <li><a  href="<?php $URI->WriteURI('App=Account&Com=FindFriends&Act=Search'); ?>" style="cursor:pointer;">Cari Teman</a></li>
                             <li><a class="current" href="<?php $URI->WriteURI('App=Account&Com=Friends'); ?>" style="cursor:pointer;">Teman kamu</a></li>
                       	</ul>
                        <div class="ClearFix"></div>
                    </div>

                    <div id="posts" class="tabsItemInformation">
                         
                         <form method="post" action="" style="padding:10px;">
		                    <input type="text" id="SearchInput" name="quickFind" value="" autocomplete="off" />
		                </form>
                         
                         <ul class="friendsList" id="friendsList" style="padding:10px;">
					
                <?php echo $FriendsDefault; ?>
                
                
                </ul>
                         
                    </div>

                </div>

            </div>
        </div>

    </div>

</div>

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

	var Educeus_Profile = (function(){

		var request;
		var working = false;
		var workingSearch = false;

		var Follow = $('#follow');
		var SearchInput = $('#SearchInput');
		
		var init = function(){
			SearchInput.defaultText('Looking for people?');
			EventHandler();
		};
		
		var EventHandler = function(){
			Follow.live('click', function(){
				var el = $(this);
				var par = el.closest('li');
				var UName = par.data('UName');
				var AliasingName = par.data('AliasingName');
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
				//alert(UName);
                
				request = $.post(url, DataRequest, function(res){
					if (n == 'Un Follow'){
					    el.parent().removeClass('buttonOrange').addClass('buttonGray');
					}else{
					    el.parent().removeClass('buttonGray').addClass('buttonOrange');
					}
					el.attr('value', n);
					working = false;
					window.location = window.location;
				}, 'json');

				return false;
				
			});

			SearchInput.bind('keyup', function(e){
				e.preventDefault();
				var el = $(this);
				var parent = el.parent();
				var list = parent.next();
								
				if (workingSearch) request.abort();
				workingSearch = true;

				list.html('Loading...');
				
					var DataRequest = {
						Keywords : el.val() 
					};
					request = $.post('<?php echo $URI->WriteURI('App=Account&Com=Friends&Act=SearchFriends') ?>', DataRequest, function(res){
						if (res.status){
						list.html(res.result);
						}
						
						workingSearch = false;
					}, 'json');
				
			});
			
		};	

		return{
			init : init
		}
		
	})();

	Educeus_Profile.init();

});

</script>

