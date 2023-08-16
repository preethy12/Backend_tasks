<?php

namespace Drupal\table_task\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for table_task routes.
 */
class TableTaskController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $query = \Drupal::database()->select('table_task_example', 'tt')
      ->fields('tt')
      ->execute();
    $rows = [];
    foreach ($query as $row) {
      $rows[] = [
        'id' => $row->id,
        'first_name' => $row->first_name,
        'last_name'  => $row->last_name,
        'email' => $row->email,
        'phone_number' => $row->phone_number,
        'gender' => $row->gender,
      ];
    }

    return [
      '#theme' => 'table_task',
      '#rows' => $rows,
    ];
  }

}
