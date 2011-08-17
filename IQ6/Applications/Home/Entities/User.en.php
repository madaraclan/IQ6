<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

class UserEntity {
    public $UName;
    public $UPass;
	public $AvatarFilePath;
	public $SecQuestion;
	public $SecAnswer;
	public $Avatar;
	public $UType;
	public $IsActive;
}
