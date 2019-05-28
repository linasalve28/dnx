<?php
	/* 
		Use as follows:
		$query_debug=pb_debug_query($query);
eval("\$query_debug= \"$query_debug\";");
echo $query_debug. "\n";

*/
	function pb_debug_query($query) {
	print_r($con);
	preg_match_all('/:(.*?)(,| |\)|$)/i', $query, $result, PREG_PATTERN_ORDER);
	for ($i = 0; $i < count($result[0]); $i++) {

		//global ${$result[1][$i]};
		${$result[1][$i]};

	


		$query=str_replace(":".$result[1][$i],"'$".$result[1][$i]."'",$query);
	}
	return $query;

}



	/* OLD FUNCTION, replaced 1st Feb 2017
function pb_debug_query($query,$con) {
	print_r($con);
preg_match_all('/:(.*?)(,| |\)|$)/i', $query, $result, PREG_PATTERN_ORDER);
for ($i = 0; $i < count($result[0]); $i++) {

global ${$result[1][$i]};
 ${$result[1][$i]};
 
 for ($x = 0; $x < count($con); $x++) {
	 
	 }
 

$query=str_replace(':'.$result[1][$i],'"'.${$result[1][$i]}.'"',$query);
}
return $query;

}
*/

?>