<?php 
use Drupal\gavias_blockbuilder\includes\gavias_blockbuilder_embed;
if(!class_exists('element_gva_video_box')):
   class element_gva_video_box{

      public function render_form(){
         $fields = array(
            'type' => 'gsc_video_box',
            'title' => ('Video Box'), 
            'size' => 3,
            'fields' => array(
         
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'admin'     => true
               ),
                  
               array(
                  'id'        => 'content',
                  'type'      => 'text',
                  'title'     => t('Data Url'),
                  'desc'      => t('example: //player.vimeo.com/video/88558878?color=ffffff&title=0&byline=0&portrait=0'),
               ),
               array(
                  'id'        => 'height',
                  'type'      => 'text',
                  'title'     => t('Data Height box'),
                  'std'       => '800',
                  'desc'      => 'example: 800'
               ),

               array(
                  'id'        => 'image',
                  'type'      => 'upload',
                  'title'     => t('Image Background'),
               ),
               
               array(
                  'id'        => 'el_class',
                  'type'      => 'text',
                  'title'     => t('Extra class name'),
                  'desc'      => t('Style particular content element differently - add a class name and refer to it in custom CSS.'),
               ),
               array(
                  'id'        => 'animate',
                  'type'      => 'select',
                  'title'     => t('Animation'),
                  'desc'      => t('Entrance animation for element'),
                  'options'   => gavias_content_builder_animate_aos(),
                  'class'     => 'width-1-2'
               ), 
               array(
                  'id'        => 'animate_delay',
                  'type'      => 'select',
                  'title'     => t('Animation Delay'),
                  'options'   => gavias_content_builder_delay_aos(),
                  'desc'      => '0 = default',
                  'class'     => 'width-1-2'
               )
            )                                      
         );
         return $fields;
      }

      public static function render_content( $attr = array(), $content = '' ){
         global $base_url;
         extract(gavias_merge_atts(array(
            'title'              => '',
            'content'            => '',
            'width'              => '100%',
            'height'             => '800',
            'image'              => '',
            'el_class'           => '',
            'animate'            => '',
            'animate_delay'      => ''
         ), $attr));

         $style='width:100%; height:'.$height.'px; max-width:100%;';
         $_id = gavias_content_builder_makeid();
         if($image){
            $image = $base_url . '/' .$image; 
         }
         $autoembed = new gavias_blockbuilder_embed();
         $video = trim($autoembed->parse($content));
      ?>
      <?php ob_start() ?>
      <div class="widget gsc-video-box <?php print $el_class;?> clearfix" style="background-image: url('<?php print $image ?>');<?php print $style; ?>" <?php print gavias_content_builder_print_animate_aos($animate, $animate_delay) ?>>
         <div class="video-inner">
            <div class="video-body">

               <a class="gsc-video-link" data-toggle="modal" data-target="#<?php print $_id ?>"  data-height="<?php print $height ?>" href="#">
                  <i class="icon-play space-40"></i>
               </a>

               <!-- Modal -->
               <div class="modal fade modal-video-box" id="<?php print $_id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                 <div class="modal-dialog" role="document">
                   <div class="modal-content">
                     <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel"><?php if($title) print $title ; ?></h4>
                     </div>
                     <div class="modal-body">
                        <?php print $video ?>
                     </div>
                     
                   </div>
                 </div>
               </div>

            </div> 
         </div>    
      </div>   
      <?php return ob_get_clean() ?>
       <?php
      }

   }
endif;   




