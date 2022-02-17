<?php 
	$clasificaciones = array();
	foreach ($dato as $key => $value)
		foreach ($value as $va ): 
			array_push($clasificaciones, strtolower($va['clasificacion']));
		endforeach;
	print_r(array_unique($clasificaciones, SORT_STRING));
?>