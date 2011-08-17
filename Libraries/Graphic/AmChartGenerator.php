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

class AmChartGenerator {
	private $errorData;
    private $path;
    public function __construct()
    {
        //include_once('../error/CustomException.php');
        $this->path = Config::Instance(SETTING_USE)->baseUrl . 'Libraries' . '/' . 'Graphic' . '/' . 'amcharts';
    }

    /**
	* Create Bar Chart
	*
	* Generate Bar Chart
	*
	* @return   void
	*/
    public function CreateBarChart($data,$category, $value, $color, $title)
    {
        try {
            if(!is_array($data))
                throw new CustomException();

            echo "<html>
                <head>
                    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
                    <title>".$title."</title>
                    <script src=\"". $this->path . "/javascript/amcharts.js\" type=\"text/javascript\"></script>
                    <script src=\"" . $this->path . "/javascript/raphael.js\" type=\"text/javascript\"></script>

                    <script type=\"text/javascript\">

                    var chart;

                    var chartData = ". json_encode($data) . ";


                    window.onload = function() {
                        chart = new AmCharts.AmSerialChart();
                        chart.dataProvider = chartData;
                        chart.categoryField = \"". $category . "\";
                        chart.marginTop = 25;
                        chart.marginBottom = 80;
                        chart.marginLeft = 55;
                        chart.marginRight = 25;
                        chart.startDuration = 1;

                        var graph = new AmCharts.AmGraph();
                        graph.valueField = \"" . $value . "\";
                        graph.colorField = \"" . $color . "\";
                        graph.balloonText=\"[[" . $category . "]]: [[" . $value . "]]\";
                        graph.type = \"column\";
                        graph.lineAlpha = 0;
                        graph.fillAlphas = 0.8;
                        chart.addGraph(graph);

                        var catAxis = chart.categoryAxis;
                        catAxis.gridPosition = \"start\";
                        catAxis.autoGridCount = true;

                        chart.write(\"chartdiv\");
                    }


                    </script>

                </head>

                <body style=\"background-color:#EEEEEE\">
                    <div id=\"chartdiv\" style=\"width:600px; height:400px; background-color:#FFFFFF\"></div>
                </body>
            </html>";
            
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

