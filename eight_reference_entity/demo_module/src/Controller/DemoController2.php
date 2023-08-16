<?php

namespace Drupal\demo_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;

/**
 * This is demo Controller2.
 */
class DemoController2 extends ControllerBase {

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
    $taxonomy_terms = $node_entity->get($field_name)->entity;
    $xxx = $taxonomy_terms->getName();
    $referenced_users = $taxonomy_terms->get($field_users)->entity->getDisplayName();
    $result = $title . ' ' . $xxx . ' ' . $referenced_users;
    return new Response($result);
  }

}
