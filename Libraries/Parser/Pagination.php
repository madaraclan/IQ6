<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Paging Framework for split data per page
 *
 * @package		InTechPHP
 * @author		Iqbal Maulana
 * @copyright	Copyright (c) 2011, Intelligence Tech, Inc.
 * @license
 * @link		http://intelligencetech.com
 * @since		Version 1.0
 */

// ------------------------------------------------------------------------

/**
* Paging Class
*
* @package		InTechPHP
* @subpackage	Parser
* @category		Libraries
* @author		Iqbal Maulana
*/
class Pagination {
    private $totRec;
    private $recPerPage;
    private $totPages;
    private $fixPage;

    public $fullTagOpen     = '<table align="center"><tr><td>';
    public $fullTagClose    = '</td></tr></table>';
    public $tagOpen         = '';
    public $tagClose        = '&nbsp;&nbsp;&nbsp;';
    public $anchorClass     = '';

    public function __construct($totRec = 0, $recPerPage = 0) {
        $this->totRec = $totRec;
        $this->recPerPage = $recPerPage;
        $this->totPages = ceil($this->totRec / $this->recPerPage);
        $fix_page = 2;
    }

    public function Display() {

        $URI            = new URI();
        $queryString    = $URI->QueryString();
        $currPage       = 1;

        switch(Config::Instance(SETTING_USE)->URLMethod) {
            case 'friendly':
                $parts      = explode("page", $queryString);
                $link       = Config::Instance(SETTING_USE)->baseUrl.Config::Instance(SETTING_USE)->baseFile.$parts[0];
                $tempPage   = Filter::IntFilter(str_replace('/', '', $parts[1]));
                $currPage   = ($tempPage != 0) ? $tempPage : 1;
                break;
        }

        
        try {
            if ($currPage < 1) {
                throw new CustomException();
            }
        }
        catch(CustomException $e) {
            $e->ShowError('Page Error', 'Your number of links must be a positive number.');
        }
        $html = $this->fullTagOpen;

        
    }
}
