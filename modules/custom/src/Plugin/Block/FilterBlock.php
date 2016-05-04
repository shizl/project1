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
/**
 * Provides a 'filterBlock' block.
 *
 * @Block(
 *  id = "filter_block",
 *  admin_label = @Translation("filter block"),
 * )
 */

class FilterBlock extends BlockBase{

  /**
   * {@inheritdoc}
   */
  public function build() {

  if(isset($_GET['filter'])){

	if($_GET['filter']=='commercial'){
	$category_id = 2;
	}elseif($_GET['filter']=='residential'){
	$category_id = 1;		
	}else{
	$category_id = 0;	
	}
  }else{
	$category_id = 0;
  }
	  return array(
	    '#markup' =>$this->blockContent($category_id),
	  );
  }

public function blockContent($category_id){

 	if($category_id!='0'){
	 // $query2 = db_query("select entity_id from {field_collection_item__field_category} where field_category_value =".$category_id." and entity_id in (select field_work_images_value from {node__field_work_images} where bundle = 'work' and entity_id in (select entity_id from {node__field_sort_order} order by field_sort_order_value desc))");

	  $query2 = db_query("select entity_id from {node__field_sort_order} where bundle = 'work' and  entity_id in (select entity_id from {node__field_work_images} where field_work_images_value in (select entity_id from {field_collection_item__field_category} where field_category_value =".$category_id .")) order by field_sort_order_value desc , entity_id desc ");

	  $r = 0;
	  $gallery = "";
	 foreach($query2 as $result){
	  $nid =  $result->entity_id;

	  $node =  Node::load($nid); 
	  $entity_id = $node->get('field_work_images')->value;
	  
	  if($entity_id!=null){
	  $query3 = db_query("select field_cover_images_target_id,field_cover_images_width,field_cover_images_height from {field_collection_item__field_cover_images} where entity_id =".$entity_id);

	   foreach($query3 as $file){

			$fid = $file->field_cover_images_target_id;
			$width = intval($file->field_cover_images_width/3);
			$height = intval($file->field_cover_images_height/3);
	  		$files =  file_load($fid);
	  		$uri = $files->get('uri')->value;
			$url = file_create_url($uri);
			$gallery .= '<div class="item item-'.$r.'" data-ri= "'.$r.'" data-id="'.$nid.'" data-h="'.$height.'" data-w="'.$width.'"><img src="'.$url.'" /></div>';
		$r++;
	    }

	   }
	  }
 
	}else{
	$r = 0;
	$gallery = "";
	$query = db_query("select entity_id from {node__field_sort_order} where bundle = 'work' order by field_sort_order_value desc , entity_id desc ");
	 foreach($query as $result){
	  $nid =  $result->entity_id;
	   $node =  Node::load($nid); 
	  $entity_id = $node->get('field_work_images')->value;
	  
	  if($entity_id!=null){
	  $query3 = db_query("select field_cover_images_target_id,field_cover_images_width,field_cover_images_height from {field_collection_item__field_cover_images} where entity_id =".$entity_id);

	   foreach($query3 as $file){

			$fid = $file->field_cover_images_target_id;
			$width = intval($file->field_cover_images_width/3);
			$height = intval($file->field_cover_images_height/3);
	  		$files =  file_load($fid);
	  		$uri = $files->get('uri')->value;
			$url = file_create_url($uri);
			$gallery .= '<div class="item item-'.$r.'" data-ri= "'.$r.'" data-id="'.$nid.'" data-h="'.$height.'" data-w="'.$width.'"><img src="'.$url.'" /></div>';
		$r++;
	    }	

	}
	
     }
}



 $output = '<div id="filter-tool"><div class="layout-container">
    <div class="tool-menu">filter projects:
	<a  href="/?filter=all#postion"  class="all '.($category_id==0?'active':'').'">all</a>
	<a  href="/?filter=residential#postion" class="residential '.($category_id==1?'active':'').'">residential</a>
	<a  href="/?filter=commercial#postion"  class="commercial '.($category_id==2?'active':'').'">commercial</a>
   </div>	
</div></div>
<div id="other_cover"><div class="filter-content layout-container flex-images">
'.$gallery.'
</div><div id="load_more"><span>↓</span></div></div>';

  return $output;




}



}
