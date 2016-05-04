<?php

/**
 * @file
 * Contains Drupal\contact_block\Plugin\Block\ContactBlock.
 */

namespace Drupal\custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\StatementInterface;
use Drupal\Core\Entity\Query\EntityQueryInterface;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\image\Entity\ImageStyle;
/**
 * Provides a 'bannerBlock' block.
 *
 * @Block(
 *  id = "banner_block",
 *  admin_label = @Translation("banner block"),
 * )
 */

class BannerBlock extends BlockBase{

  /**
   * {@inheritdoc}
   */
  public function build() {

	  return array(
	    '#markup' =>$this->blockContent(),
	  );
  }

public function blockContent(){

 $output = '<div class="responsive-slider" data-spy="responsive-slider" data-autoplay="true">
        	<div class="slides" data-group="slides">
      		<ul>';

$query = db_query("select entity_id from {node__field_sort_order} where entity_id in (select entity_id from {node__field_featured_work} where bundle = 'work' and field_featured_work_value = 'yes') order by field_sort_order_value desc , entity_id desc");

$gallery = "";

 foreach($query as $result){
  $nid =  $result->entity_id;
  $node =  Node::load($nid); 
	  $entity_id = $node->get('field_work_images')->value;
	  $query3 = db_query("select field_cover_images_target_id from {field_collection_item__field_cover_images} where entity_id =".$entity_id);

	   foreach($query3 as $file){

			$fid = $file->field_cover_images_target_id;
	  		$file =  file_load($fid);
	  		$uri = $file->get('uri')->value;
			//$url = file_create_url($uri);
			$url = ImageStyle::load('cover_image_style_1000px_750px')->buildUrl($uri);

			$gallery .= '
			<li>
			<div class="slide-body" data-group="slide"><a href="/node/'.$nid.'"><img src="'.$url.'" /></a>
			<div id="postion" class="summary_body"><div class="summary">'.substr($node->get('field_featur_work_title')->value,0,120).'</div>
			<div class="body">'.substr($node->get('field_feature_work_description')->value,0,250).'</div></div>
	</div>
							
			</li>';
	    }		
	
 }

$output .= $gallery.'</ul></div><a class="slider-control left" href="#" data-jump="prev"></a><a class="slider-control right" href="#" data-jump="next"></a></div>';

  return $output;
}



}
