<?php
 if ( !defined('FILE_ACCESS') ) exit('No direct script access allowed');
/**
 * InTechPHP Framework
 *
 * Framework Dynamic Configuration
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
* ChartGenerator Class
*
* @package		InTechPHP
* @subpackage	Graphic
* @category		Libraries
* @author		Iqbal Maulana
*/

class ChartGenerator {
	private $errorData;
    public function __construct()
    {
        //include_once('../error/CustomException.php');
        include_once('chart/phpgraphlib.php');
        include_once('chart/phpgraphlib_pie.php');
    }

    /**
	* Create Bar Chart
	*
	* Generate Bar Chart
	*
	* @return   void
	*/
    public function CreateBarChart($width, $height,$data,$title,$color = 'green')
    {
        try {
            if(!is_array($data))
                throw new CustomException();

            $graph = new PHPGraphLib($width,$height);

			if(is_array($data[0]))
			{
				foreach($data as $dataDetail)
					$graph->addData($dataDetail);
			}
			else
				$graph->addData($data);
            $graph->setTitle($title);
            if(is_array($color))
                $graph->setGradient($color[0], $color[1]);
            else
                $graph->setBarColor($color);
            $graph->createGraph();
        }
        catch(CustomException $e)
        {
            $e->ShowError('Error in generate Chart', 'Data must be an array.');
        }
    }
    /**
	* Create Pie Chart
	*
	* Generate Pie Chart
	*
	* @return   void
	*/
    public function CreatePieChart($width, $height, $data, $title = '')
    {
        try {
            if(!is_array($data))
            {
            	$errorData = "Data must be an array";
                throw new CustomException();
            }
            foreach($data as $dt)
            {
                if(is_array($dt))
                {
                    $errorData = "Multiple dataset isn't allowed with pie charts";
                    throw new CustomException();
                }
            }


            $graph = new PHPGraphLibPie($width, $height);
			$graph->addData($data);
            $graph->setTitle($title);
            $graph->createGraph();
        }
        catch(CustomException $e)
        {
            $e->ShowError('Error in generate Chart', $errorData);
        }
    }
    /**
	* Create Line Chart
	*
	* Generate Line Chart
	*
	* @return   void
	*/
    public function CreateLineChart($width, $height,$data,$title)
    {
        try {
            if(!is_array($data))
                throw new CustomException();
            $graph = new PHPGraphLib($width, $height);
            if(is_array($data[0]))
            {
            	foreach($data as $dataDetail)
            		$graph->addData($dataDetail);
            }
            else
            	$graph->addData($data);
            $graph->setBars(false);
			$graph->setLine(true);
            $graph->setTitle($title);
            $graph->createGraph();
        }
        catch(CustomException $e)
        {
            $e->ShowError('Error in generate Chart', 'Data must be an array.');
        }
    }
}

