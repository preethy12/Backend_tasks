<?php

namespace Drupal\task_seven_template\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for task_seven_template routes.
 */
class TaskSevenTemplateController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $config = $this->config('task_seven_template.settings');
    $title = $config->get('title');
    $paragraph = $config->get('Paragraph')['value'];
    $color_code = $config->get('color_code');
    return [
      '#theme' => 'task_seven_template',
      '#title' => $title,
      '#Paragraph' => $paragraph,
      '#color_code' => $color_code,
    ];
  }

}
