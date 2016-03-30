<?php
	ini_set('default_socket_timeout', 900);
	//page vars
	$url = $_POST['url'];
	$regx = '/^(http|https|ftp|ftps)/';
	$tableContents = "";
	$pageContent = "";
	if(!preg_match($regx,$url)) {
		$begin = "https://";
	} else {
		$begin = "";
	}
	//fetch page and generate page tag results
	$pageContent = file_get_contents($begin.$url);
	preg_match_all("(<[a-zA-Z]*(\s|>))",$pageContent, $result);
	//normalize the tag names for display
	foreach($result[0] as &$value) {
		$value = trim($value);
		$value = trim($value,'<>');
	}
	$result = array_values(array_filter($result[0]));
	$tagCounts =array_count_values($result);
	//create tag results table
	foreach($tagCounts as $key=>$value) {
		$tableContents .= "<tr><td><button type=\"button\" class=\"btn btn-default\" id=\"$key\" onclick=\"highlight(this.id)\">&lt;$key&gt;</button></td><td><span class=\"badge\">$value</span></td></tr>";
	}
	echo json_encode(array("tableContents"=>$tableContents, "sourceCode"=>htmlspecialchars($pageContent,ENT_QUOTES))); //something is breaking the pageContent part for google.com	when returned
	return;
?>