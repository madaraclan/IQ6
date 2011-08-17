<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

Import::Model('Account.User');

class _Login extends Controller {

    private $userModel;

    public function __construct(URI $URI, Input $Input) {
        $this->userModel = new User();
        $this->userModel->ValidateLogin($Input, 'LogedOut');
    }

    public function MainLoad(URI $URI, Input $Input) {
        Import::Template('Login', NULL, 'Guest');
        Import::View('Login',array('error'=>$Input->Session()->GetValue('error')));
        if($Input->Session('EDU')->GetValue('error') != NULL)
            $Input->Session('EDU')->DeleteValue('error');
    }

    public function DoLoginLoad(URI $URI, Input $Input) {
        $isLogedIn = $this->userModel->SignIn($Input);
        
        if ($isLogedIn)
		    redirect($URI->ReturnURI('App=Account&Com=NewsFeeds'));
        else
            redirect($URI->ReturnURI(''));
    }
}
