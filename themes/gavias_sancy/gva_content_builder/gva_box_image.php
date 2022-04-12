<?php 

if(!class_exists('element_gva_box_color')):
   class element_gva_box_color{
      public function render_form(){
         return array(
           'type'          => 'gsc_box_image',
            'title'        => t('Box Image'),
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
                  'admin'     => true
               ),
               array(
                  'id'        => 'content',
                  'type'      => 'textarea',
                  'title'     => t('Content'),
                  'desc'      => t('Content for box color'),
               ),
               array(
                  'id'        => 'color',
                  'type'      => 'text',
                  'title'     => t('Color for box'),
                  'desc'      => t('Use color name ( blue ) or hex ( #f5f5f5 )')
               ),
               array(
                  'id'        => 'image',
                  'type'      => 'upload',
                  'title'     => t(' Background image'),
                  'desc'      => t('Background image for box color'),
               ),
               array(
                  'id'        => 'icon',
                  'type'      => 'text',
                  'title'     => t('Icon'),
               ),
               array(
                  'id'        => 'link',
                  'type'      => 'text',
                  'title'     => t('Link'),
               ),
               array(
                  'id'        => 'link_title',
                  'type'      => 'text',
                  'title'     => t('Link Title'),
                  'std'       => 'Read more'
               ),
               array(
                  'id'        => 'target',
                  'type'      => 'select',
                  'title'     => t('Open in new window'),
                  'desc'      => t('Adds a target="_blank" attribute to the link'),
                  'options'   => array( 'off' => 'No', 'on' => 'Yes' ),
                  'std'       => 'on'
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
               ), 
            ),                                     
         );
      }

      public static function render_content( $attr = array(), $content = '' ){
         global $base_url;
         extract(gavias_merge_atts(array(
            'title'              => '',
            'content'            => '',
            'color'              => '',
            'image'              => '',
            'icon'               => '',
            'link'               => '',
            'link_title'         => 'Readmore',
            'target'             => '',
            'el_class'           => '',
            'animate'            => '',
            'animate_delay'      => ''
         ), $attr));

         // target
         if( $target ){
            $target = 'target="_blank"';
         } else {
            $target = false;
         }
         if($image) $image = $base_url . '/' . $image;     
         ?>
            <?php ob_start() ?>
            <div class="widget gsc-box-image<?php if($el_class) print (' '.$el_class) ?>" <?php print gavias_content_builder_print_animate_aos($animate, $animate_delay) ?>>
              <div class="image text-center">
                  <img src="<?php print $image ?>" alt="<?php print $title ?>"/>
              </div>
              <div class="body text-center"<?php if($color) print ' style="border-top-color:'.$color.';"' ?>>
                  <?php if($icon){ ?>
                     <div class="icon"<?php if($color) print ' style="background-color:'.$color.';"' ?>><i class="<?php print $icon; ?>"></i></div>
                  <?php } ?>
                  <div class="content">
                     <div class="title"><h3><?php print $title ?></h3></div>
                     <div class="desc"><?php print $content ?></div>
                     <?php if($link){ ?>
                        <div class="readmore"><a class="btn-theme" href="<?php print $link ?>"><?php print $link_title ?></a></div>
                     <?php } ?>
                  </div>
              </div>
           </div>
           <?php return ob_get_clean() ?>
      <?php
      } 
   }
endif;   
