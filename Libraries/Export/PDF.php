<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');

require_once PATH_LIBRARIES . DS . 'Export' . DS . 'PDF' . DS . 'class.ezpdf.php';
define('PORTRAIT','portrait');
define('LANDSCAPE','landscape');
define('LETTER','LETTER');
define('LEGAL','LEGAL');
define('EXECUTIVE','EXECUTIVE');
define('FOLIO','FOLIO');
define('A1','A1');
define('A2','A2');
define('A3','A3');
define('A4','A4');
define('A5','A5');
define('A6','A6');
define('A7','A7');
define('A8','A8');
define('A9','A9');
define('A10','A10');
define('B1','B1');
define('B2','B2');
define('B3','B3');
define('B4','B4');
define('B5','B5');
define('B6','B6');
define('B7','B7');
define('B8','B8');
define('B9','B9');
define('B10','B10');
define('C1','C1');
define('C2','C2');
define('C3','C3');
define('C4','C4');
define('C5','C5');
define('C6','C6');
define('C7','C7');
define('C8','C8');
define('C9','C9');
define('C10','C10');

class PDF {
    private $pdf;

    public function __construct($type, $orientation = PORTRAIT) {
        $this->pdf = new Cezpdf($type, $orientation);
    }

    public function SetImageBackground($path, $x, $y, $w, $h, $quality=75) {
        $image = imagecreatefrompng($path);
        $this->pdf->addImage($image, $x, $y, $w, $h, $quality);
    }

    public function SetFont($path) {
        $this->pdf->selectFont($path);
    }

    public function SetColor($r, $g, $b) {
        $this->pdf->setColor($r, $g, $b);
    }

    public function AddText($x, $y, $size, $text) {
        $this->pdf->addText($x, $y, $size, $text);
    }

    public function AddData($data, $x, $y, $size, $xIncrement, $yIncrement) {
        foreach($data as $i)
        {
            $this->pdf->addText($x, $y, $size, $i);
            $x += $xIncrement;
        }
        $y -= $yIncrement;
    }

    public function SetLineStyle($width) {
        $this->pdf->setLineStyle($width);
    }

    public function Line($x1, $y1, $x2, $y2) {
        $this->pdf->line($x1, $y1, $x2, $y2);
    }

    public function SetStrokeColor($r, $g, $b) {
        $this->pdf->setStrokeColor($r, $g, $b);
    }

    public function Close() {
        $this->pdf->ezStream();
    }
}
?>
