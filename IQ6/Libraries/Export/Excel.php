<?php
if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
Import::Library('Export.Excel.PHPExcel');

class Excel {
    private $excel;
    private $excelWriter;

    public function __construct() {
        $this->excel = new PHPExcel();
    }

    public function SetCreator($creator) {
        $this->excel->getProperties()->setCreator($creator);
    }

    public function SetLastModifiedBy($lastModified) {
        $this->excel->getProperties()->setLastModifiedBy($lastModified);
    }

    public function SetTitle($title) {
        $this->excel->getProperties()->setTitle($title);
    }

    public function SetSubject($subject) {
        $this->excel->getProperties()->setSubject($subject);
    }

    public function SetDescription($description) {
        $this->excel->getProperties()->setDescription($description);
    }

    public function SetKeywords($keywords) {
        $this->excel->getProperties()->setKeywords($keywords);
    }

    public function SetCategory($category) {
        $this->excel->getProperties()->setCategory($category);
    }

    public function SetActiveSheetIndex($pIndex) {
        $this->excel->setActiveSheetIndex($pIndex);
    }

    public function SetCellValue($pIndex, $pCoordinate, $value) {
        $this->excel->setActiveSheetIndex($pIndex)->setCellValue($pCoordinate, $value);
    }

    public function GetActiveSheetIndex()
    {
        return $this->excel->getActiveSheetIndex();
    }

    public function AddNewSheet()
    {
        $this->excel->addSheet(new PHPExcel_Worksheet($this->excel));
    }

    public function Save() {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="file.xlsx"');
        header('Cache-Control: max-age=0');

        $excelWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
        $excelWriter->save('php://output');
    }
}
?>