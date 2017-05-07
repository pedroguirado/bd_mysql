<?php
//header('Content-type: text/plain');
$username = "[user]";
$password = "[password]";
$hostname = "localhost";	
$database = "[database]";


// Opens a connection to a mySQL server
$conexion = new mysqli($hostname, $username, $password, $database);

if (!$conexion) {
  die('Not connected : ' . mysql_error());
}

// json output - insert table name below after "FROM"
$query = 'SELECT * FROM survey';
$dbquery = $conexion->query($query);

if(! $dbquery )
{
  die('Could not get data: ' . mysql_error());
}

// Parse the dbquery into geojson 
// ================================================
// ================================================
// Return markers as GeoJSON

$feature=array();

$geojson = array(
    'type'      => 'FeatureCollection',
    'features'  => $feature
 );

while($row = $dbquery->fetch_assoc()) {
    $feature = array(
        'type' => 'Feature', 
      'geometry' => array(
        'type' => 'Point',
        'coordinates' => array((float)$row['lon'], (float)$row['lat'])
            ),
      'properties' => array(
            'name' => $row['title']
        //Other fields here, end without a comma
            )
        );
    array_push($geojson['features'], $feature);
};
$conexion->close();

// // Return routing result
//    header("Content-Type:application/json",true);
    echo json_encode($geojson);
?>
