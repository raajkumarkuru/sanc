<?php
function gavias_sancy_preprocess_views_view_unformatted__taxonomy_term(&$variables){
   $current_uri = \Drupal::request()->getRequestUri();
   $url = \Drupal::service('path.current')->getPath();
   $arg = explode('/', $url);
}

function gavias_sancy_preprocess_username(&$variables){
   $account = $variables['account'];
   if($account->hasField('field_full_name')){
      $field_full_name = $account->get('field_full_name');
   }
}

function gavias_sancy_preprocess_views_view_grid(&$variables) {
   $view = $variables['view'];
   $rows = $variables['rows'];
   $style = $view->style_plugin;
   $options = $style->options;
   $variables['gva_masonry']['class'] = '';
   $variables['gva_masonry']['class_item'] = '';
   $array_class = preg_split('/ /', $options['row_class_custom']);
   if(in_array('masonry', $array_class) ){
      $variables['gva_masonry']['class'] = 'post-masonry-style row';
      $variables['gva_masonry']['class_item'] = 'item-masory';
   }
}

function gavias_sancy_preprocess_views_view(&$variables) {
   global $gva_node_index;
   $gva_node_index = 0;
}