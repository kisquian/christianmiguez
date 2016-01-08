<?php 
  foreach( $listaPorfolio as $por ) { ?>


  <li class="col-lg-2 col-md-2 col-sm-2 gallery gallery-graphic" id="<?php echo $por->id; ?>" >
              <a class="colorbox" href="uploads/<?php echo $por->url; ?>.<?php echo $por->ext; ?>" data-group="gallery-graphic">
                  <div class="templatemo-project-box">

                      <img src="uploads/small_<?php echo $por->url; ?>.<?php echo $por->ext; ?>" class="img-responsive" alt="gallery" />

                      <div class="project-overlay">
                          <h5><?php echo $por->name; ?></h5>
                          <hr />
                          <h4><?php echo $por->tags; ?></h4>
                      </div>
                  </div>
              </a>
          </li>

<?php
 }
?>
                        