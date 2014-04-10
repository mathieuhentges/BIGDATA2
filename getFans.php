<?php
echo('<head><meta charset="UTF-8"></head><body>');
set_time_limit (6400);
$m = new MongoClient();

if(isset($_GET['album'])){
	$start=$_GET['album'];
}
else{
	exit("Please enter an album parametter");
}
if($start>=480000)
	exit("limit");

$db = $m->selectDB("deezer");
$album_Coll = $db->selectCollection("albums");
$countries_Coll = $db->selectCollection("country");
$countries_Coll->ensureIndex(array('name' => 1, 'genre_Id' => 1), array("unique" => true));

for($myI=$start;$myI<$start+50;$myI++){
	$albumCursor = $GLOBALS['album_Coll']->find(array('album_Id'=>$myI));
	$albumCursor->next();
	$albumLine = $albumCursor->current();
	if(count($albumLine["album_Genres"])>0){
		$album_Genres = array();
		for($i=0;$i<count($albumLine["album_Genres"]); $i++){
			$album_Genres[$i]=$albumLine["album_Genres"][$i]["id"];
		}
	    getFans($albumLine["album_Id"], $album_Genres);
	}
}

function getFans($id, $album_Genres){
	$content = file_get_contents('http://api.deezer.com/album/'.$id.'/fans');
	$myFans=json_decode($content);
	foreach($myFans->data as $fan){
		addFanCountry($fan->id,$album_Genres);
	}
}

function addFanCountry($user_Id, $genres){
	$content = file_get_contents('http://api.deezer.com/user/'.$user_Id);
	$myFan=json_decode($content);
	$country=$myFan->country;

	for($j=0;$j<count($genres);$j++){
		try{
			$GLOBALS['countries_Coll']->insert(array('name'=>$country, 'genre_Id'=>$genres[$j], 'number'=>1));
		}
		catch(Exception $e){
			$newData = array('$inc' => array('number'=>1));
			$GLOBALS['countries_Coll']->update(array("name" => $country, 'genre_Id'=>$genres[$j]), $newData);
		}
	}
}

$newStart=$start+50;
echo($start.' to '.$newStart);
echo('<script> setTimeout(function(){window.location.href="http://localhost/getFans.php?album='.$newStart.'";}, 200);</script>');
?>