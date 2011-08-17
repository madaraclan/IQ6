<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

class _Wall extends Controller {

    public function __construct() {
    }

    public function MainLoad(URI $URI, Input $Input) {
        Import::Template('Home');
        Import::View('Wall');

    }
    public function LogoutLoad(URI $URI, Input $Input)
    {
        $Input->Cookie()->DeleteAllValue();
        $Input->Session()->DeleteAllValue();
		redirect($URI->ReturnURI('App=Home&Com=Session'));
    }
}
