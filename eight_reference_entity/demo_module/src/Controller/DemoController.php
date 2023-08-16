<?php

namespace Drupal\demo_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * This is demo Controller.
 */
class DemoController extends ControllerBase {

  /**
   * Callback for the /demo_module/{node} route.
   */
  public function getNodeInfo() {
    $node = 1;
    $node_entity = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->load($node);
    // Get the node title.
    $title = $node_entity->getTitle();
    $field_name = 'field_colors';
    $field_users = 'field_user';
    $term = $node_entity->get($field_name)->referencedEntities()[0];
    $term_name = $term->getName();
    $referenced_users = $term->get($field_users)->referencedEntities()[0];
    $user_name = $referenced_users->getDisplayName();
    $result = $title . ' ' . $term_name . ' ' . $user_name;
    return new Response($result);
  }

}
