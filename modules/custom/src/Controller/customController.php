<?php

/**
 * @file
 * Contains \Drupal\field_collection\Controller\FieldCollectionItemController.
 */

namespace Drupal\custom\Controller;
use Drupal\node\Entity\Node;


class customController {

public function coverajax() {
  
   $node =  Node::load($_POST['id']);

   $collection_id =  $node->get('field_work_images')->value;

   $cover_image = '';
   $other_image = '';
$mobile_img1 = '';
$mobile_img2 = '';
  $query = db_query("select field_cover_images_target_id from {field_collection_item__field_cover_images} where entity_id =".$collection_id);
  $query2 = db_query("select field_other_images_target_id from {field_collection_item__field_other_images} where entity_id =".$collection_id);
  $date = db_query("select field_date_value from {field_collection_item__field_date} where entity_id =".$collection_id)->fetchfield();

  	   foreach($query as $file){
			$fid = $file->field_cover_images_target_id;
	  		$file =  file_load($fid);
	  		$uri = $file->get('uri')->value;
			$url = file_create_url($uri);
			$cover_image .= '<img  class="active first" src="'.$url.'" />';
			$mobile_img1 .=  '<li><div class="slide-body" data-group="slide"><img src="'.$url.'" /></div></li>';
	    }

          foreach($query2 as $file){

			$fid = $file->field_other_images_target_id;
	  		$file =  file_load($fid);
	  		$uri = $file->get('uri')->value;
			$url = file_create_url($uri);
			$other_image .= '<img src="'.$url.'" />';	
			$mobile_img2 .=  '<li><div class="slide-body" data-group="slide"><img src="'.$url.'" /></div></li>';	
	 }



$mobile_slider = '
<div class="mobile-responsive-slider">
    <ul class="rslides" id="mobile-responsive-slider">
      '.$mobile_img1.$mobile_img2.'
    </ul>
</div>
';

$output = $mobile_slider.'<div class="layout-container other-content"><div class="big_image">'.$cover_image.'</div> <div class="small_image"><div class="title">'.$node->get('title')->value.'</div><div class="time">'.date('m.d.y',strtotime($date)).'</div>'.$cover_image.$other_image.'</div></div> <a href="javascript:" class="close">×</a>
<script>jQuery(".cover-region .small_image img").click(function(){
     img_src = jQuery(this).attr("src");	      
     jQuery(".cover-region .big_image img").attr("src",img_src); 

     jQuery(".cover-region .small_image img").each(function(){
           jQuery(this).removeClass("active");
     });
	jQuery(this).addClass("active");

  });
jQuery(".cover-region .close").click(function(){

 jQuery(".cover-region").remove();

});

  jQuery("#mobile-responsive-slider").responsiveSlides({
	auto: false,
	pager: false,
	nav: true,
	speed: 500,
	namespace: "callbacks",
	before: function () {
	  jQuery(".events").append("<li>before event fired.</li>");
	},
	after: function () {
	  jQuery("events").append("<li>after event fired.</li>");
	}
  });

</script>';
print_r($output);
exit;
  }



public function filterajax() {


 if(isset($_POST['text'])){
	$_SESSION['filter'] = $_POST['text'];
  }

 print_r(1);exit;
}



}
