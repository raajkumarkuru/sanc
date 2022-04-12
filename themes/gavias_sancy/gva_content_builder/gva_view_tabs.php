<?php 

use Drupal\views\Views;
use Drupal\views\Element\View;
if(!class_exists('element_gva_view_tabs')):
   class element_gva_view_tabs{

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
            'type' => 'gsc_view_tabs',
            'title' => t('Tab views'),
            'size' => 3,
            'fields' => array(
               array(
                  'id'        => 'title',
                  'type'      => 'text',
                  'title'     => t('Title For Admin'),
                  'admin'     => true
               ),
               array(
                  'id'        => 'hidden_category',
                  'type'      => 'select',
                  'title'     => t('Hidden Categories Of Post'),
                  'options'   => array(
                     'hidden' => 'Hidden',
                     'show'   => 'Show'
                  ),
                  'default'       => 'show',
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

         for($i=1; $i<=10; $i++){
            $fields['fields'][] = array(
               'id'     => "info_${i}",
               'type'   => 'info',
               'desc'   => "Information for tab item {$i}"
            );
            $fields['fields'][] = array(
               'id'        => "title_{$i}",
               'type'      => 'text',
               'title'     => t("Title {$i}")
            );
            $fields['fields'][] = array(
               'id'        => "view_{$i}",
               'type'      => 'select',
               'title'     => t("View {$i}"),
               'options'   => $view_display
            );
         }
         return $fields;
      }

      public static function render_content( $attr = array(), $content = '' ){
         $default = array(
            'title'              => '',
            'hidden_category'    => '',
            'el_class'           => '',
            'animate'            => '',
            'animate_delay'      => ''
         );

         for($i=1; $i<=10; $i++){
            $default["title_{$i}"] = '';
            $default["view_{$i}"] = '';
         }

         extract(gavias_merge_atts($default, $attr));
         if($hidden_category == 'hidden') $el_class  .= 'hidden-categories';
         $_id = gavias_content_builder_makeid();
         
         ?>
         <?php ob_start() ?>
         <div class="gsc-tab-views <?php echo $el_class ?>" <?php print gavias_content_builder_print_animate_aos($animate, $animate_delay) ?>> 
            <div class="clearfix text-center">
               <ul class="nav nav-tabs">
                  <?php 
                  for($i=1; $i<=10; $i++){ 
                     $title = "title_{$i}";
                     if(!empty($$title)){
                  ?>
                     <li class="<?php print ($i==1?'active':'') ?>"><a data-toggle="tab" href="#tab-item-<?php print ($_id . $i) ?>"><?php print $$title ?></a></li>

                  <?php 
                     }
                  } 
                  ?>
               </ul>
             </div>  
            <div class="tab-content">
               <?php for($i=1; $i<=10; $i++){ 
                  $output = '';
                  $view = "view_{$i}";
                  $title = "title_{$i}";
                  if(!empty($$title)){
                     if($$view){
                        $_view =  preg_split("/-----/", $$view);
                        if(isset($_view[0]) && isset($_view[1])){ 
                           try{
                              $view = Views::getView($_view[0]);
                              if($view){
                                 $v_output = $view->buildRenderable($_view[1], [], FALSE);
                                 if($v_output){
                                    $v_output['#view_id'] = $view->storage->id();
                                    $v_output['#view_display_show_admin_links'] = $view->getShowAdminLinks();
                                    $v_output['#view_display_plugin_id'] = $view->display_handler->getPluginId();
                                    views_add_contextual_links($v_output, 'block', $_view[1]);
                                    $v_output = View::preRenderViewElement($v_output);
                                    if (empty($v_output['view_build'])) {
                                      $v_output = ['#cache' => $v_output['#cache']];
                                    }
                                    if($v_output){
                                      $output .= render($v_output);
                                    }
                                 }
                              }else{
                                 $output .= '<div>Missing view, block "'.$view_tmp.'"</div>';
                              }
                           }catch(PluginNotFoundException $e){
                                 $output .= '<div>Missing view, block "'.$view_tmp.'"</div>';
                           }
                           $view = null;
                           $v_output = null;
                        }
                     }else{
                        $output .= '<div>Missing view, please choose view"</div>';
                     }
                     print '<div class="tab-pane fade in '.(($i==1)?'active':'').'" id="tab-item-' . $_id . $i . '">'.$output.'</div>';     
                  } 
               } ?>
            </div>   
         </div>   
         <?php return ob_get_clean();
      }

   }
 endif;  



