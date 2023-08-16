<?php

namespace Drupal\task_ten_formatter\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "",
 *   label = @Translation("Task Ten Formatter"),
 *   field_types = {
 *     "integer"
 *   }
 * )
 */
class TaskTenFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'concat' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['concat'] = [
      '#type' => 'textfield',
      '#title' => 'Concatenate with',
      '#default_value' => $this->getSetting('concat'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $summary[] = $this->t("concatenate with : @concat", ["@concat" => $this->getSetting('concat')]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $value = $item->value / 100;
      $concatinate = $this->getSetting('concat');
      $elements[$delta] = [
        '#markup' => '<p>' . $concatinate . $value . '</p>',
      ];
    }

    return $elements;
  }

}
