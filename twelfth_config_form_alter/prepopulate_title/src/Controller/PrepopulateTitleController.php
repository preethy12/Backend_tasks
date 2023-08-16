<?php

namespace Drupal\prepopulate_title\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for prepopulate_title routes.
 */
class PrepopulateTitleController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
