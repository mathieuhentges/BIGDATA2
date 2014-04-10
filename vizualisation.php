<?php
set_time_limit (6400);
$m = new MongoClient();

$db = $m->selectDB("deezer");
$countryStats_Coll = $db->selectCollection("countryStats");
$countries_Coll = $db->selectCollection("country");

if(isset($_GET['genre'])){
  $genre=(int)$_GET['genre'];
}
else{
  $genre=129;
}
if(isset($_GET['name'])){
  $genreName=$_GET['name'];
}
else{
  $genreName='rock';
}

$mapParam='[\'Country\', \'pourcentage\', \'total\']';

$cursor=$GLOBALS['countries_Coll']->find(array('genre_Id'=>$genre));
foreach ($cursor as $doc) {
  if($doc["name"]!==''){
    $cursor2=$GLOBALS['countryStats_Coll']->find(array('name'=>$doc["name"]));
    $cursor2->next();
    $doc2=$cursor2->current();
    $mapParam=$mapParam.', [\''.$doc["name"].'\', '.$doc["number"]/$doc2["number"].', '.$doc["number"].']';
  }
}
?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {


        var data = google.visualization.arrayToDataTable([<?php echo($mapParam); ?>]);

        var options = {
          colorAxis: {colors:['white','#00297A']}
        };

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };

    function selectGenre(){
      var genresDropdown=document.getElementById("genres");
      var selectedGenre=genresDropdown.options[genresDropdown.selectedIndex].value;
      var selectedGenreName=genresDropdown.options[genresDropdown.selectedIndex].text;
      window.location.href="http://localhost/vizualisation.php?genre="+selectedGenre+'&name='+selectedGenreName;
    }
    </script>
  </head>
  <body><center>
    <p>Genre musical :
      <select id="genres" onchange="selectGenre()">
        <option value="0">Genre musical</option>
        <option value="1">World</option>
        <option value="2">Afrique</option>
        <!--<option value="3">Afro Pop</option>-->
        <!--<option value="4">Biguine</option>-->
        <!--<option value="5">Coupé-Décalé</option>-->
        <!--<option value="6">Sega mauritien</option>-->
        <!--<option value="7">Seggae mauritien</option>-->
        <!--<option value="8">Swag mauritien</option>-->
        <!--<option value="9">Touareg</option>-->
        <!--<option value="10">Zouglou</option>-->
        <!--<option value="11">Zouk</option>-->
        <option value="12">Maghreb</option>
        <!--<option value="13">Chaabi</option>
        <option value="14">Charki</option>
        <option value="15">Raï</option>-->
        <option value="16">Asie</option>
        <!--<option value="17">Folklore asiatique</option>
        <option value="18">C-Pop</option>
        <option value="19">Dangdut</option>
        <option value="20">Pop indonésienne</option>
        <option value="21">Musique islamique</option>
        <option value="22">J-Pop</option>
        <option value="23">K-Pop</option>
        <option value="24">M-Pop</option>
        <option value="25">Musique indonésienne</option>
        <option value="26">OPM</option>
        <option value="27">Country thaï</option>
        <option value="28">Pop thaï</option>
        <option value="29">Retro thaï</option>
        <option value="30">Teen thaï</option>-->
        <option value="31">Australie/Pacifique</option>
        <option value="32">Europe</option>
        <!--<option value="33">Arabesque (TR)</option>
        <option value="34">Musique celtique</option>
        <option value="35">Éntekhno (GR)</option>
        <option value="36">Flamenco (ES)</option>
        <option value="37">Flamenco Pop (ES)</option>
        <option value="38">Folk hongrois (HU)</option>
        <option value="39">Isklemä (FI)</option>
        <option value="40">Laïkó (GR)</option>
        <option value="41">Levenslied (NL)</option>
        <option value="42">Nederlandstalige volksmuziek (NL)</option>
        <option value="43">Pizzica (IT)</option>
        <option value="44">Folk contestataire turc (TR)</option>
        <option value="45">Schlager (DE, AT, CH)</option>
        <option value="46">Tammurriata (IT)</option>
        <option value="47">Tarantella (IT)</option>
        <option value="48">Musique classique turc (TR)</option>
        <option value="49">Folk turc (TR)</option>
        <option value="50">Folk finlandais (FI)</option>-->
        <option value="51">France</option>
        <option value="52">Chanson française</option>
        <option value="53">Variété française</option>
        <!--<option value="54">Musique celtique</option>-->
        <option value="55">Moyen Orient</option>
        <option value="56">Amérique Centrale/Caraïbes</option>
        <!--<option value="57">Bachata</option>
        <option value="58">Banda</option>
        <option value="59">Buigine caraïbe</option>
        <option value="60">Folklore d'Amérique Centrale</option>
        <option value="61">Grupero</option>
        <option value="62">Mariachi</option>
        <option value="63">Mento/Calypso</option>
        <option value="64">Merengue</option>
        <option value="65">Regional méxicain</option>
        <option value="66">Rocksteady</option>
        <option value="67">Salsa</option>
        <option value="68">Tropical</option>-->
        <option value="69">Amérique du Sud</option>
        <!--<option value="70">Cuenca</option>
        <option value="71">Cumbia/Tropical</option>
        <option value="72">Folklore argentin</option>
        <option value="73">Tango</option>
        <option value="74">Vallenato</option>-->
        <option value="75">Brésil</option>
        <!--<option value="76">Axé/Forró</option>
        <option value="77">Instrumental/Traditionnel</option>
        <option value="78">MPB</option>
        <option value="79">Samba/Pagode</option>
        <option value="80">Forró/Sertanejo</option>-->
        <option value="81">Inde</option>
        <!--<option value="82">Chine</option>-->
        <option value="83">Amérique du Nord</option>
        <!--<option value="84">Country</option>-->
        <option value="85">Alternative</option>
        <option value="86">Pop indé</option>
        <option value="87">Rock thaï</option>
        <!--<option value="88">Indé thaï</option>
        <option value="89">Indé Finlande</option>
        <option value="90">Indé Estonie</option>
        <option value="91">Alternatif latin</option>
        <option value="92">Alternatif néo-zélandais</option>
        <option value="93">Alternatif francophone</option>
        <option value="94">Alternatif brésilien</option>-->
        <option value="95">Musique pour enfants</option>
        <option value="96">Comptines/Chansons</option>
        <!--<option value="97">Histoires</option>-->
        <option value="98">Classique</option>
        <option value="99">Baroque</option>
        <option value="100">Période classique</option>
        <option value="101">Médieval</option>
        <option value="102">Moderne</option>
        <option value="103">Opéra</option>
        <!--<option value="104">Renaissance</option>-->
        <option value="105">Romantique</option>
        <option value="106">Electro</option>
        <option value="107">Chill Out/Trip-Hop/Lounge</option>
        <!--<option value="108">Dubstep</option>-->
        <option value="109">Electro Hip-Hop</option>
        <!--<option value="110">Electro Pop/Electro Rock</option>-->
        <option value="111">Techno/House</option>
        <!--<option value="112">House sud-africaine</option>-->
        <option value="113">Dance</option>
        <!--<option value="114">Dancefloor</option>-->
        <option value="115">Trance</option>
        <option value="116">Hip Hop</option>
        <!--<option value="117">Hip Hop instrumental</option>-->
        <option value="118">Rap UK</option>
        <option value="119">Rap US</option>
        <option value="120">Rap divers</option>
        <!--<option value="121">Rap en allemand</option>
        <option value="122">Reggaeton</option>
        <option value="123">Rap russe</option>
        <option value="124">Rap finlandais</option>
        <option value="125">Kwaito</option>
        <option value="126">Rap latin</option>
        <option value="127">Hip Hop francophone</option>-->
        <option value="128">Rap français</option>
        <option value="129">Jazz</option>
        <option value="130">Jazz instrumental</option>
        <option value="131">Jazz vocal</option>
        <option value="132">Pop</option>
        <option value="133">Pop indé/Folk</option>
        <option value="134">Pop internationale</option>
        <!--<option value="135">Pop russe</option>
        <option value="136">Pop finlandais</option>
        <option value="137">Pop turque</option>
        <option value="138">Pop latine</option>
        <option value="139">Pop francophone</option>
        <option value="140">Pop néo-zélandaise</option>-->
        <option value="141">Variété Internationale</option>
        <!--<option value="142">Pop-Rock hongrois</option>-->
        <option value="143">Pop française</option>
        <option value="144">Reggae</option>
        <option value="145">Dancehall/Ragga</option>
        <option value="146">Dub</option>
        <option value="147">Ska</option>
        <option value="148">Reggaeton</option>
        <!--<option value="149">Reggae finlandais</option>
        <option value="150">Reggae mauritien</option>
        <option value="151">Reggae jamaïcain</option>-->
        <option value="152">Rock</option>
        <option value="153">Blues</option>
        <option value="154">Rock Indé/Pop Rock</option>
        <option value="155">Metal/HardRock</option>
        <option value="156">Rock & Roll/Rockabilly</option>
        <!--<option value="157">Metal finlandais</option>
        <option value="158">Rock russe</option>
        <option value="159">Rock turc</option>
        <option value="160">Rock latin</option>
        <option value="161">Rock brésilien</option>
        <option value="162">Rock finlandais</option>
        <option value="163">Rock néo-zélandais</option>-->
        <option value="164">Rock français</option>
        <option value="165">R&B/Soul/Funk</option>
        <option value="166">R&B contemporain</option>
        <option value="167">Soul contemporaine</option>
        <option value="168">Disco</option>
        <option value="169">Funk</option>
        <option value="170">R&B vieille école</option>
        <option value="171">Soul vieille école</option>
        <!--<option value="172">R&B néo-zélandais</option>-->
        <option value="173">Films/Jeux vidéo</option>
        <option value="174">Musiques de films</option>
        <option value="175">Comédies musicales</option>
        <option value="176">Bandes originales</option>
        <option value="177">BO TV</option>
        <option value="178">Bollywood</option>
        <!--<option value="179">Musiques de jeux vidéo</option>-->
        

      </select>
    </p>
    </br>
    <div id="chart_div" style="width: 900px; height: 500px;"></div></br>
    <h2>Carte de la répartition des fans de <?php echo($genreName); ?></h2></center>
  </body>
</html>