<?php
require_once ("graph/jpgraph.php");
require_once ('graph/jpgraph_pie.php');

if (isset($_GET['data']) && isset($_GET['title'])){
	$title = $_GET['title'];
	$data = unserialize($_GET['data']);
	
	if (isset($_GET['label']))
		$labels = explode(',', $_GET['label']);
	else
		$labels = array('','','','');
	
	$graphPrint = array();
	$dataArr = array();
	for ($i = 0; $i < count($data) ; $i++){
		$graphPrint[]= $data[$i]." ".$labels[$i];
		$dataArr[]= $data[$i];
	}
}
// Create the Pie Graph.
$graph = new PieGraph(350,250);

$theme_class="DefaultTheme";
//$graph->SetTheme(new $theme_class());

// Set A title for the plot
$graph->title->Set($title);
$graph->SetBox(true);

// Create
$p1 = new PiePlot($dataArr);
$graph->Add($p1);
$p1->SetStartAngle(0);

//$p1->SetValueType(PIE_LABEL_ABS);
//$p1->SetValueType(PIE_VALUE_PERCENTAGE);
//$p1->SetLabels($graphPrint,50);
//$p1->SetLabelType(PIE_LABEL_ABS);
$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(array('#5360ff','#ff1e30','#0b8500','#7006ff'));


$graph->Stroke();
?>