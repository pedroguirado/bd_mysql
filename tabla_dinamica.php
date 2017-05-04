<?php

/* --------------------------------------- */
function conectar($maq, $usu, $con, $bas){
$conexion = new mysqli($maq, $usu, $con, $bas);

if ($conexion->connect_error) {
    die('Error de Conexión (' . $conexion->connect_errno . ') '. $conexion->connect_error);
}
$acentos = $conexion->query("SET NAMES 'utf8'");

return $conexion;
}

/* --------------------------------------- */

function tabla_dinamica (){
  include_once("paramconexion.php"); /* En este fichero paramconexion.php definimos las variables que utilizo para llamar a
                                        la función siguiente */
  $conexion=conectar($maquina,$usuario,$contrasena,$basededatos);
    
    // Asignar valor a $tabla o modificar la consulta a continuación
  $resultado=$conexion->query("Select * from %s",$tabla);
  //printf("<p>La selección devolvió %d filas y %d columnas.</p>\n", $resultado->num_rows, $resultado->field_count);
  echo "<table><tr>";
  /* Obtener la información del campo para todas las columnas */
  $info_campo = $resultado->fetch_fields();
  foreach ($info_campo as $valor) {
    printf("<td>%s</td>",$valor->name);
  }
  echo "</tr>";
  /* obtener el array de objetos */
  while ($fila = $resultado->fetch_row()) {
      echo "<tr>";
      foreach ($fila as $valor)
        printf("<td>%s</td>",$valor);
      echo "</tr>";
  }

  echo "</table>";

  $resultado->free();
  $conexion->close();
}

?>
