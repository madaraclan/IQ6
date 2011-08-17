<!--Content Two Column-->
<div class="ContentTwoLayout">
    <!--Left Column-->
    <div class="LeftColumn">
        <h2 class="HeaderIcon"><span class="Icon16 IconNewsFeeds16"></span>News Feeds</h2>

        <div class="ShareBox">
            <div class="ShareTypeBox">
                <ul class="ShareType">
                    <li>Share :</li>
                    <li><a href="" class="Current">
                        <span class="Icon16 IconStatus16"></span>
                        <span class="Text">Status</span>
                    </a></li>
                    <li><a href="">
                        <span class="Icon16 IconLink16"></span>
                        <span class="Text">Link</span>
                    </a></li>
                    <li><a href="">
                        <span class="Icon16 IconQuestion16"></span>
                        <span class="Text">Question</span>
                    </a></li>
                </ul>
            </div>
            <div class="ClearFix"></div>

            <div id="BoxInpuContainer">
                <form action="" method="post">
                    <div class="BoxInput">
                        <div class="BoxInputText">
                            <input type="text" name="ShareInput" id="ShareInput" value="Write something on your mind..." />
                        </div>
                    </div>

                    <div class="BoxShareButton">
                        <span id="CountCharacter">
                            Characters Left :
                            <strong>300</strong>
                        </span>
                        <input type="submit" name="Share" id="Share" value="Share" class="BgX ButtonBlack" />
                    </div>
                </form>
            </div>
            
        </div>

        <div class="ClearFix"></div>
        <div id="BoxNewsFeeds">
            <ul class="BlokNewsList">
                <li>
                    <span class="DisplayPicture"><img src="<?php echo Path::View('Documents/1200996594/Avatar/thumb_60.jpg') ?>"></span>
                </li>
            </ul>
        </div>
    </div>
    <!--End Left Column-->

    <!--Right Column-->
    <div class="RightColumn">
        
    </div>
    <!--End Right Column-->
</div>
<!--End Content Two Column-->