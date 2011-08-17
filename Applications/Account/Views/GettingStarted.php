<div class="BoxContentBordered GettingStarted">

    <div class="Title">
        <h1>New in Educeus? Let's Getting Started</h1>
        <span class="Description">Please complete your information step by step bellow</span>
    </div>

    <div class="HrGrayWhite"></div>

    <div class="GettingStartedStep">

        <ul class="GettingStartedNavigation">

            <li class="Current">
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

    <?php
    Import::View("GettingStarted/".$currentView);
    ?>

    <div class="ClearFix"></div>
    <br />

</div>
<div class="Left"></div>