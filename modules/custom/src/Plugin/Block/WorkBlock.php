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
 * Provides a 'workBlock' block.
 *
 * @Block(
 *  id = "see_more_work_block",
 *  admin_label = @Translation("see more work block"),
 * )
 */

class WorkBlock extends BlockBase{

  /**
   * {@inheritdoc}
   */
  public function build() {

	  return array(
	    '#markup' =>$this->blockContent(),
	  );
  }

public function blockContent(){

	$r = 0;
	$gallery = "";
	$query = db_query("select nid from {node} where type = 'work' ORDER BY rand()");
	 foreach($query as $result){
	  $nid =  $result->nid;
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


 $output = '<a href="/#filter"><h2 class="overrite">see more work</h2></a><div id="see_more_work" class="flex-images">'.$gallery.'</div><div id="load_more"><span>↓</span></div>';

  return $output;




}



}
