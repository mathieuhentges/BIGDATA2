<?php
echo('<head><meta charset="UTF-8"></head><body>');
set_time_limit (6400);
$m = new MongoClient();

$db = $m->selectDB("deezer");
$countryStats_Coll = $db->selectCollection("countryStats");
$countryStats_Coll->ensureIndex(array('name' => 1), array("unique" => true));
$countries_Coll = $db->selectCollection("country");

$cursor = $countries_Coll->find();
foreach ($cursor as $doc) {
    try{
			$GLOBALS['countryStats_Coll']->insert(array('name'=>$doc["name"], 'number'=>$doc["number"]));
		}
	catch(Exception $e){
		$newData = array('$inc' => array('number'=>$doc["number"]));
		$GLOBALS['countryStats_Coll']->update(array("name" => $doc["name"]), $newData);
	}
}

$cursor2 = $countryStats_Coll->find();
foreach ($cursor2 as $doc2) {
    var_dump($doc2);
}
?>
