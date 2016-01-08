<?php
include_once('models/Porfolio.php');


if( isset($_POST) ) {

  $data = new stdClass();
  $data->name       = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
  $data->tags    = filter_var($_POST['cat'], FILTER_SANITIZE_SPECIAL_CHARS);

  $imagen = $_FILES['image'];


  $tempFile = $imagen['tmp_name'];
  $nombreArchivo = filter_var($imagen['name'], FILTER_SANITIZE_SPECIAL_CHARS);
  $destinoFinal = dirname(__FILE__) . '/../uploads/';
  $thumb_folder = dirname(__FILE__) . '/../uploads/thumbs/';
  var_dump( $destinoFinal);

  $partesNombres = explode('.', strtolower($nombreArchivo));
  $nuevoNombreImagen = str_replace(' ', '_', $partesNombres[0]);
  $extension = end($partesNombres);
  $nuevoNombreImagen.= '_' . md5(uniqid()) . '.' . $extension;

  $archivoFinal = $destinoFinal .  $nuevoNombreImagen;

  $tiposArchivo = array('jpg', 'jpeg', 'gif', 'png');


  if( $data->name && $data->tags && $imagen ) {
      
      $porfolio = new Porfolio();
      

     if( in_array($extension, $tiposArchivo) ) {
          //Hago la subida
          if( copy($tempFile, $archivoFinal) ) {
            $porfolio->agregarPorfolio($data, $nuevoNombreImagen);
            //ACA IRIA EL CODIGO PARA LA GENERACION DEL THUMBNAIL
            //call thumbnail creation function and store thumbnail name
  $upload_img = $porfolio->cwUpload('image','../uploads/',$nuevoNombreImagen,TRUE,'../uploads/thumbs/','200','160');
  
  //full path of the thumbnail image
  $thumb_src = 'uploads/thumbs/'.$upload_img;
  
  //set success and error messages
  $message = $upload_img?"<span style='color:#008000;'>Image thumbnail have been created successfully.</span>":"<span style='color:#F00000;'>Some error occurred, please try again.</span>";
  header('location: ../admin/index.php?msg=successUploasdadad');

            //ACA TERMINA EL CODIGO PARA LA GENERACION DEL THUMBNAIL
            header("location:../admin/index.php?msg=porfolio_added");
          }else{
            header("location:../index.php?msg=error_copiando_archivo");
          }
        }else{
          // La extension no está permitida
          header("location:../index.php?msg=error_extension_archivo");
        }

    
  } else {
     header("location:../admin/add-porfolio.php?msg=datos_requeridos");
     // Los campos con * son requeridos
  }

} else {
  header("location:../$returnPage?msg=no_data");
}