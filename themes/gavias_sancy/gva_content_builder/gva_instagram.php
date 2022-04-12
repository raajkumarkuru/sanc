<?php 
if(!class_exists('element_gva_instagram')):
   class element_gva_instagram{

      public function render_form(){
         $fields = array(
            'type' => 'gsc_instagram',
            'title' => ('Instagram'), 
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
                  'desc'      => t('Some Shortcodes and HTML tags allowed'),
               ),
               array(
                  'id'        => 'username',
                  'type'      => 'text',
                  'title'     => t('Username'),
               ),
               array(
                  'id'        => 'number',
                  'type'      => 'text',
                  'title'     => t('Number'),
                  'std'       => '6'
               ),
               array(
                  'id'        => 'columns',
                  'type'      => 'text',
                  'title'     => t('Columns'),
                  'std'       => '5'
               ),
               array(
                  'id'        => 'columns_md',
                  'type'      => 'text',
                  'title'     => t('Columns for medium screen'),
                  'std'       => '5'
               ),
               array(
                  'id'        => 'columns_sm',
                  'type'      => 'text',
                  'title'     => t('Columns for small screen'),
                  'std'       => '5'
               ),
               array(
                  'id'        => 'link',
                  'type'      => 'select',
                  'title'     => t('Show link use'),
                  'options'   => array(
                     1     =>  t('Enable'),
                     0     =>  t('Disable')               
                  )
               ),
               array(
                  'id'        => 'style',
                  'title'     => t('Style'),
                  'type'      => 'select',
                  'options'   => array(
                     'style-1'        => 'default',
                     'style-2'        => 'style #2: no padding',
                  ),
                  'std'    => 'icon-left',
               ),
               array(
                  'id'     => 'el_class',
                  'type'      => 'text',
                  'title'  => t('Extra class name'),
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
         extract(gavias_merge_atts(array(
            'title'              => '',
            'content'            => '',
            'username'           => '',
            'number'             => '6',
            'columns'            => '5',
            'columns_sm'         => '4',
            'columns_md'         => '5', 
            'link'               => 0,
            'style'              => 'style-1',
            'el_class'           => '',
            'animate'            => '',
            'animate_delay'      => ''
         ), $attr));
         
         $el_class .= ' ' . $style;

         $results_array = false;
         if($username){
            $results_array = scrape_insta_hash($username);
         }
         if($link && $results_array){
            $link = 'https://' . $results_array['hostname'] . '/' . $username;
         }

         ?>
         <?php ob_start() ?>
         <div class="block gsc-instagram <?php print $el_class; ?>" <?php print gavias_content_builder_print_animate_aos($animate, $animate_delay) ?>>
            <?php if($title){ ?>
               <h2 class="block-title"><span><?php print $title ?><?php if($link) print " <a href=\"{$link}\">{$username}</a>"; ?></span></h2>
            <?php } ?>
            <?php if($content){ ?><div class="desc"><?php print $content; ?></div><?php } ?>
            <div class="widget-content">
            <div class="cols lg-block-grid-<?php print $columns ?> md-block-grid-<?php print $columns_md ?> sm-block-grid-<?php print $columns_sm ?> xs-block-grid-2">
                  <?php 
                     if($results_array){
                        for ($i=1; $i <= $number; $i++) { 
                           $image = $results_array['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'][$i]['node'];
                           print '<div class="instagram-image item"><a data-rel="prettyPhoto[g_gal]" href="'.$image['display_url'].'"><img src="'.$image['thumbnail_src'].'" alt=""/></a></div>';
                        }
                     }
                  ?>
               </div>
            </div>
         </div>
         <?php return ob_get_clean() ?>
       <?php
      }

   } 
endif;   
