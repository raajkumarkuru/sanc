<?php 

use Drupal\views\Views;
use Drupal\views\Element\View;
if(!class_exists('element_gva_view')):
   class element_gva_view{
      public function render_form(){
         $view_options = Views::getViewsAsOptions(TRUE, 'all', NULL, FALSE, TRUE);
         $view_display = array();
         foreach ($view_options as $view_key => $view_name) {
            $view = Views::getView($view_key);
            $view_display[''] = '-- None --';
            foreach ($view->storage->get('display') as $name => $display) {
               if($display['display_plugin']=='block'){
                  $view_display[$view_key . '-----' . $name] = $view_name .' || '. $display['display_title'];
               }
            }
         }
         asort($view_display);
         $fields = array(
            'type' => 'gsc_view',
            'title' => ('Drupal View'),
            'size' => 12,
            
            'fields' => array(
               array(
                  'id'        => 'title_admin',
                  'type'      => 'text',
                  'title'     => t('Administrator Title'),
                  'admin'       => true,
               ),
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title'),
               ),
               array(
                  'id'        => 'view',
                  'type'      => 'select',
                  'title'     => t('View Name'),
                  'options'   => $view_display,
                  'class'     => 'gsc_display_view change_value_admin',
               ),
               array(
                  'id'        => 'show_title',
                  'type'      => 'select',
                  'title'     => t('Show Title'),
                  'options'   => array(
                     'hidden'       => 'Hidden',
                     'title_view'   => 'Title View',
                     'title_block'  => 'Title Block'
                  ),
                  'default'       => 'title_view',
                  'desc'      => t('Hidden title default for block')
               ),
               array(
                  'id'        => 'extra_links',
                  'type'      => 'textarea',
                  'title'     => t('Extra Links'),
               ),
               array(
                  'id'        => 'hidden_category',
                  'type'      => 'select',
                  'title'     => t('Show/Hidden Categories Of Post'),
                  'options'   => array(
                     'hidden' => 'Hidden',
                     'show'   => 'Show'
                  ),
                  'default'       => 'show',
               ),
               array(
                  'id'        => 'style_text',
                  'type'      => 'select',
                  'title'     => t('Skin Text for box'),
                  'options'   => array(
                     'text-dark'   => 'Text dark',
                     'text-light'   => 'Text light',
                  ),
                  'default'       => 'text-dark'
               ),
                array(
                  'id'        => 'style_heading',
                  'type'      => 'select',
                  'title'     => t('Style Heading'),
                  'options'   => array(
                     ''            => 'Default',
                     'heading-2'   => 'Heading 2',
                  ),
                  'default'       => ''
               ),
               array(
                  'id'        => 'align_title',
                  'type'      => 'select',
                  'title'     => t('Align title'),
                  'options'   => array(
                     'title-align-left'   => 'Align Left',
                     'title-align-right'  => 'Align Right',
                     'title-align-center' => 'Align Center'
                  ),
                  'default'       => 'title-align-left',
                  'desc'      => t('Align title default for block')
               ),
               array(
                  'id'        => 'remove_margin',
                  'type'      => 'select',
                  'title'     => ('Margin'),
                  'options'   => array(
                     'on'        =>  'No Margin',
                     'off'       =>  'Margin Default',
                     'medium'    =>  'Margin Medium',
                     'large'     =>  'Margin Large',
                  ),
                  'default'      => 'off',
               ),
               array(
                  'id'        => 'remove_margin_post',
                  'type'      => 'select',
                  'title'     => ('Margin Post'),
                  'options'   => array(
                     'on'        =>  'No Margin',
                     'off'       =>  'Margin Default'
                  ),
                  'default'      => 'off',
               ),
               array(
                  'id'        => 'block_color',
                  'type'      => 'select',
                  'title'     => t('Block Color'),
                  'options'   => gavias_sancy_get_colors_block(),
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

      public function render_content( $attr = array(), $content = '' ){
         extract(gavias_merge_atts(array(
            'title_admin'        => '',
            'title'              => '',
            'view'               => '',
            'extra_links'        => '',
            'show_title'         => 'hidden',
            'hidden_category'    => '',
            'align_title'        => 'title-align-center',
            'style_text'         => '',
            'style_heading'      => '',
            'el_class'           => '',
            'remove_margin'      => 'off',
            'remove_margin_post' => 'off',
            'block_color'        => '',
            'animate'            => '',
            'animate_delay'      => ''
         ), $attr));
         
         if(!$view) return "None view choose";

         $output = '';
         $class = array();
         $class[] = $align_title; 
         $class[] = $el_class;
         $class[] = $style_text;
         $class[] = $style_heading;
         $class[] = 'remove-margin-' . $remove_margin;
         $class[] = 'remove-margin-post-' . $remove_margin_post;
         if($block_color) $class[] = $block_color;
         if($hidden_category == 'hidden') $class[] = 'hidden-categories';
         $view_tmp = $view;
         $_view =  preg_split("/-----/", $view);

         if(isset($_view[0]) && isset($_view[1])){
            $output_view = gavias_render_views( $_view[0], $_view[1], '' );
            $output .= '<div>';
               $output .= '<div class="widget block clearfix gsc-block-view  gsc-block-drupal block-view '.implode($class, ' ') .'" ' . gavias_content_builder_print_animate_aos($animate, $animate_delay) .'>';
               
               if($show_title == 'title_view' && $output_view['view_title']) $title = $output_view['view_title'];

               if($title && ($show_title == 'title_block' || $show_title == 'title_view')){
                  $output .= '<div class="block-heading">';
                     $output .= '<h2 class="block-title"><span>' . $title . '</span></h2>';
                     if($extra_links) $output .= '<div class="extra-links">' . $extra_links . '</div>';
                  $output .= '</div>';
               }

               $output .= $output_view['content'];
            $output .= '</div></div>';
            
            $view = null;
            $v_output = null;
         } 
         return $output;  
      }


   }
endif;
   



