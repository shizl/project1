<?php

/**
 * @file
 * Contains \Drupal\field_collection\Controller\FieldCollectionItemController.
 */

namespace Drupal\celerie\Controller;
use Drupal\node\Entity\Node;


class celerieController {

public function ajaxcelerie() {
  
   $node = Node::load($_POST['nodeid']);
   $number = $_POST['newnumber'];

  //print_r($node->field_liker[0]->value);
  //exit;
    $node->field_liker->value = $number;
    $node->save();

   echo 1;
exit;
  }

}
