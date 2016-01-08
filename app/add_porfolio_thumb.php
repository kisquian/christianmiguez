<?php

include('models/Porfolio.php');

$porfolio = new Porfolio;

  // lets rock! 

  if( isset($_POST) ) {

  $data = new stdClass();
  $data->name       = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
  $data->tags     = filter_var($_POST['cat'], FILTER_SANITIZE_SPECIAL_CHARS);
  $imagen = $_FILES['image'];

  $tempFile = $imagen['tmp_name'];
  $nombreArchivo = filter_var($imagen['name'], FILTER_SANITIZE_SPECIAL_CHARS);

  $partesNombres = explode('.', strtolower($nombreArchivo));
  $nuevoNombreImagen = str_replace(' ', '_', $partesNombres[0]);
  $extension = end($partesNombres);
  $nuevoNombreImagen.= '_' . md5(uniqid()) . '.' . $extension;  



  if( $data->name && $data->tags && $imagen ) {    

    $porfolio->agregarPorfolio($data, $nuevoNombreImagen);
    
  } else {
     header("location:../admin/registro.php?msg=datos_requeridos");
     // Los campos con * son requeridos
  }

} else {
  header("location:../$returnPage?msg=no_data");
}


if(!empty($_FILES['image']['name'])){
  
  //call thumbnail creation function and store thumbnail name
  $upload_img = $porfolio->cwUpload('image','../uploads/',$nuevoNombreImagen,TRUE,'../uploads/thumbs/','200','160');
  
  //full path of the thumbnail image
  $thumb_src = 'uploads/thumbs/'.$upload_img;
  
  //set success and error messages
  $message = $upload_img?"<span style='color:#008000;'>Image thumbnail have been created successfully.</span>":"<span style='color:#F00000;'>Some error occurred, please try again.</span>";
  header('location: ../admin/index.php?msg=successUploasdadad');
}else{
  
  //if form is not submitted, below variable should be blank
  $thumb_src = '';
  $message = '';

}

 ?>