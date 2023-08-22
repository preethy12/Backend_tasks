<?php

namespace Drupal\fifteenth_operation\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Fifteenth operation routes.
 */
class FifteenthOperationController extends ControllerBase {

  /**
   * Displays the title of the node.
   */
  public function build($node) {
    return [
      '#markup' => $node->getTitle(),
    ];
  }

}
