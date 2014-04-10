<?php
set_time_limit (6400);
$mongo = new MongoClient();
echo('<head><meta charset="UTF-8"></head><body>');

$db = $mongo->selectDB("deezer");
$album_Coll = $db->selectCollection("albums");

if(isset($_GET['album'])){
	$start=$_GET['album'];
}
else{
	exit("Please enter an album parametter");
}
$stats=array($mongo->deezer->command(array( 'collStats' => 'albums' )));
if($stats[0]["count"]>25000)
	exit('<script> setTimeout(function(){window.location.href="http://localhost/getFans.php?album=469000";}, 1000);</script>');

for($i=$start; $i<$start+100; $i++){
	addAlbum($i, $album_Coll);
}

function addAlbum($i, $album_Coll){					//Add album to db
	$content = file_get_contents('http://api.deezer.com/album/'.$i);
	$myAlbum=json_decode($content);
	if(!isset($myAlbum->error)){
		$myAlbum2=array(	'album_Id' => $myAlbum->id,'album_Name' => $myAlbum->title, 'album_Genres' => $myAlbum->genres->data);
		$album_Coll -> insert($myAlbum2);
	}
}
$newStart=$start+100;

echo($start.' to '.$newStart);
echo('<script> setTimeout(function(){window.location.href="http://localhost/recupAlbums.php?album='.$newStart.'";}, 1000);</script>');		//Script for infinite loop
?>