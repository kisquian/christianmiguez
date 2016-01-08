<?php session_start();

$root = $_SERVER["DOCUMENT_ROOT"].'/cosmic1';


include_once('app/models/Porfolio.php');

/*if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
	if ($msg == "logout_true") {
	$msgText = "Has cerrado sesión satisfactoriamente";}

	if ($msg == "Suscrito_con_exito") {
	$msgText = "Gracias por suscribirte!";}

	if ($msg == "error_datos_requeridos") {
	$msgText = "Error: Datos requeridos";}

	if ($msg == "Comentario_agregado_correctamente") {
	$msgText = "Comentario agregado, debes esperar que lo apruebe el administrador";}

	if ($msg == "comment_deleted") {
	$msgText = "Comentario eliminado satisfactoriamente";}

	if ($msg == "error_extension_archivo") {
	$msgText = "Error en la súbida del archivo";}

	if ($msg == "comment_aproved") {
	$msgText = "Comentario aprobado";}

	if ($msg == "sin_efecto") {
	$msgText = "Accion sin efecto";}

	$showMsg = "<div class='mensaje'>".$msgText."</div>";

}*/

