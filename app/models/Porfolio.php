<?php
include_once("Model.php");
/**
 * Usuario
 */
class Porfolio extends Model
{


    // Variable privada que almacena el objeto PDO
    private $_db;

    private $_lastInsertedId = 0;

    /**
     * [__construct description]
     */
    public function __construct() {
        // Creamos una nueva conexión
        $this->_db = Model::getInstance();
    }

    public function listarPorfolio() {
      $sql = null;

      try {
            $sql = $this->_db->query("SELECT * FROM porfolio");
            $sql->setFetchMode(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            $this->_error = $e->getMessage();
        }

        return $sql;
    }

    public function listarPorfolioPublicados($published) {
      $sql = null;

      try {
            $sql = $this->_db->prepare("SELECT * FROM porfolio WHERE status=:Status");
            $sql->execute(array(
              "Status" => $published
            ));
            $sql->setFetchMode(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            $this->_error = $e->getMessage();
        }

        return $sql;
    }

    public function filtrarPosts( $busqueda, $tipo_filtro = self::NOMBRE_EXACTO ) {
      $result = null;

      try {
            $filtrado = "='".$busqueda."'";

            switch( $tipo_filtro ) {
              case self::NOMBRE_EXACTO:
                $filtrado = $busqueda;
                break;
              case self::EMPIEZA_CON:
                $filtrado = $busqueda ."%";
                break;
              case self::TERMINA_CON:
                $filtrado = "%" . $busqueda;
                break;
            }

            $sql = $this->_db->prepare("SELECT * FROM posts WHERE title LIKE :Filtrado");
            $sql->execute(array(
              "Filtrado" => $filtrado
            ));
            $sql->setFetchMode(PDO::FETCH_OBJ);
            $result = $sql->fetchAll();
        } catch(PDOException $e) {
            $this->_error = $e->getMessage();
        }

        return $result;
    }

    public function obtenerPost( $id_post ) {
      $result = null;

      try {
          $sql = $this->_db->prepare("SELECT * FROM posts WHERE id=:IdPost");
          $sql->execute(array( "IdPost" => $id_post ));
          $sql->setFetchMode(PDO::FETCH_OBJ);
          $result = $sql->fetch();
        } catch(PDOException $e) {
            $this->_error = $e->getMessage();
        }

        return $result;
    }

    public function agregarPorfolio( stdClass $data, $nuevoNombreImagen) {
        $sql = null;
        $this->_lastInsertedId = 0;

        try {
            $sql= $this->_db->prepare ("INSERT INTO porfolio(name, tags, url) VALUES(:Name, :Tags, :Url)");
            $sql->execute(array(
              "Name"    => $data->name,
              "Tags" => $data->tags,
              "Url" => $nuevoNombreImagen
            ));

            $this->_lastInsertedId = $this->_db->lastInsertId();
        } catch(PDOException $e) {
            $this->_error = $e->getMessage();
        }

        return ($sql->rowCount() > 0) ? true : false;
    }

    public function editarPost( $idPost, stdClass $data ) {
        $sql = null;

        try {
            $sql= $this->_db->prepare ("UPDATE posts SET title=:Title, content=:Content, status=:Status WHERE id=:idPost");
            $sql->execute(array(
              "Title"    => $data->title,
              "Content" => $data->content,
              "idPost" => $idPost,
              "Status" => $data->status
            ));
        } catch(PDOException $e) {
            echo $e->getMessage();
        }

        return ($sql->rowCount() > 0) ? true : false;
    }

    public function eliminarPost( $id_usuario ) {
        try {
            $sql = $this->_db->prepare("DELETE FROM posts WHERE id=:IdPost");
            $sql->execute(array( "IdPost" => $id_usuario ));
            return ($sql->rowCount() > 0) ? true : false;
        } catch(PDOException $e) {
            $this->_error = $e->getMessage();
        }
    }

    /**
     * Retorna el ID del último registro insertado
     * @return int
     */
    public function obtenerIdUltimoRegistro() {
      return (int) $this->_lastInsertedId;
    }

  function cwUpload($field_name, $target_folder, $file_name, $thumb, $thumb_folder, $thumb_width, $thumb_height) {

      try {

        //define folders
      $target_path = $target_folder;
      $thumb_path = $thumb_folder;
      
      
      //upload image path
      $upload_image = $target_path.basename($nuevoNombreImagen);
      
      //upload image
      if(move_uploaded_file($nuevoNombreImagen,$upload_image))
      {
          //thumbnail creation
          if($thumb == TRUE)
          {
              $thumbnail = $thumb_path.$nuevoNombreImagen;
              list($width,$height) = getimagesize($upload_image);
              $thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
              
              switch($file_ext){
                  case 'jpg':
                      $source = imagecreatefromjpeg($upload_image);
                      break;
                  case 'jpeg':
                      $source = imagecreatefromjpeg($upload_image);
                      break;

                  case 'png':
                      $source = imagecreatefrompng($upload_image);
                      break;
                  case 'gif':
                      $source = imagecreatefromgif($upload_image);
                      break;
                  default:
                      $source = imagecreatefromjpeg($upload_image);
              }

              imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
              switch($file_ext){
                  case 'jpg' || 'jpeg':
                      imagejpeg($thumb_create,$thumbnail,100);
                      break;
                  case 'png':
                      imagepng($thumb_create,$thumbnail,100);
                      break;

                  case 'gif':
                      imagegif($thumb_create,$thumbnail,100);
                      break;
                  default:
                      imagejpeg($thumb_create,$thumbnail,100);
              }

          }

          return $nuevoNombreImagen;
          

      }
      else
      {
          return false;
      }

      
        
      } catch(PDOException $e) {
            $this->_error = $e->getMessage();
        }
  }


// The end of the Class
}