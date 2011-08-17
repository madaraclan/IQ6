<!--Box Login-->
<div id="LoginBox">
    <div id="LoginBanner">
        <img src="<?php echo Path::Template('Images/login_banner.jpg')?>" />
    </div>

    <div id="LoginForm">
        <h1>EDUCEAN LOGIN</h1>
        <div class="Description">
            Please enter your current Student ID / <br />
            Lecturer ID and password for Login.
        </div>

        <form method="post" action="<?php URI::WriteURI('App=Home&Com=Session&Act=Login', TRUE) ?>">
            <div id="AccountBox">
                <p>
                    <label for="userID">Student ID :</label>
                    <input type="text" name="userID" id="userID" class="IconLoginAccount IconUserID" />
                </p>

                <p>
                    <label for="password">Password :</label>
                    <input type="password" name="password" id="password" class="IconLoginAccount IconPassword" />
                </p>


                <div id="KeepLogedIn">
                    <input type="checkbox" name="alwaysLogedIn" id="alwaysLogedIn" value="TRUE" />
                    <label for="alwaysLogedIn">Keep me signed in</label>
                    <div class="ClearFix"></div>
                </div>

                <div class="ClearFix"></div>
            </div>

            <input type="submit" name="logIn" id="LogIn" value="Login" class="BgX ButtonBlack" />
            <div id="ForgotPassword">
                <a href="">Forgot your password?</a>
            </div>
        </form>

        <div id="ConnectedImage">
            <img src="<?php echo Path::Template('Images/connected.jpg')?>" />
        </div>
    </div>

</div>
<!--End Box Login-->