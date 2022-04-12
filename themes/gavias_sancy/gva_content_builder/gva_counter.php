<?php 
if(!class_exists('element_gva_counter')):
   class element_gva_counter{
      public function render_form(){
         $fields = array(
            'type' => 'gsc_counter',
            'title' => ('Counter'),
            'fields' => array(
               array(
                  'id'        => 'title',
                  'title'     => t('Title'),
                  'type'      => 'text',
                  'admin'     => true
               ),
               array(
                  'id'        => 'icon',
                  'title'     => t('Icon'),
                  'type'      => 'text',
                  'std'       => 'fa fa-thumbs-up',
               ),
               array(
                  'id'        => 'number',
                  'title'     => t('Number'),
                  'type'      => 'text',
               ),
               array(
                  'id'        => 'type',
                  'title'     => t('Style'),
                  'type'      => 'select',
                  'options'   => array(
                     //'icon-left'     => 'Icon left',
                     'icon-top'   => 'Icon top',
                  ),
                  'std'    => 'icon-left',
               ),
               array(
                  'id'        => 'style_text',
                  'type'      => 'select',
                  'title'     => t('Skin Text for box'),
                  'options'   => array(
                     'text-dark'   => 'Text dark',
                     'text-light'   => 'Text light'
                  ),
                  'std'       => 'text-dark'
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
         return $fields;
      }

       public static function render_content( $attr = array(), $content = '' ){
         extract(gavias_merge_atts(array(
            'title'              => '',
            'icon'               => '',
            'number'             => '',
            'type'               => 'vertical',
            'el_class'           => '',
            'style_text'         => 'text-light',
            'animate'            => '',
            'animate_delay'      => ''
         ), $attr));
         $class = array();
         $class[] = $el_class;
         $class[] = $type;
         $class[] = $style_text;
         ?>
         <?php ob_start() ?>
         <div class="widget milestone-block <?php if(count($class) > 0){ print implode($class, ' '); } ?>" <?php print gavias_content_builder_print_animate_aos($animate, $animate_delay) ?>>
            <?php if($icon){ ?>
               <div class="milestone-icon"><span class="<?php print $icon; ?>"></span></div>
            <?php } ?>   
            <div class="milestone-right">
               <div class="milestone-number"><?php print $number; ?></div>
               <div class="milestone-text"><?php print $title ?></div>
            </div>
         </div>
         <?php return ob_get_clean() ?>
         <?php
      }

   }
endif;
   



