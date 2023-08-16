<?php

namespace Drupal\task_six_dropdown\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Dropdown form.
 */
class SettingsForm extends FormBase {

  /**
   * The database service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * CustomForm constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dropdown_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $item_id = $form_state->getValue("item");
    $model_id = $form_state->getValue("model");
    $form['item'] = [
      '#type' => 'select',
      '#title' => ' Select electronic Item',
      '#options' => $this->getElectronicItemOptions(),
      '#empty_option' => '- Select -',
      '#ajax' => [
        'callback' => [$this, 'ajaxModelDropdownCallback'],
        'wrapper' => 'model-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ],
    ];

    $form['model'] = [
      '#type' => 'select',
      '#title' => ' Select mobile model',
      '#options' => $this->getMobileModelOptions($item_id),
      '#prefix' => '<div id="model-wrapper">',
      '#suffix' => '</div>',
      '#empty_option' => '- Select -',
      '#ajax' => [
        'callback' => [$this, 'ajaxColorDropdownCallback'],
        'wrapper' => 'color-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
          'message' => $this->t('Loading...'),
        ],
      ],
    ];

    $form['color'] = [
      '#type' => 'select',
      '#title' => ' Select color',
      '#options' => $this->getColorByModel($model_id),
      '#prefix' => '<div id="color-wrapper">',
      '#suffix' => '</div>',
      '#empty_option' => '- Select -',
      '#disabled' => FALSE,
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle form submission if needed.
  }

  /**
   * Ajax callback for the MOdel dropdown.
   */
  public function ajaxModelDropdownCallback(array &$form, FormStateInterface $form_state) {
    return $form['model'];
  }

  /**
   * Ajax callback for the color dropdown.
   */
  public function ajaxColorDropdownCallback(array &$form, FormStateInterface $form_state) {
    return $form['color'];
  }

  /**
   * Helper function to retrieve itemoptions.
   */
  private function getElectronicItemOptions() {
    $query = $this->database->select('item', 'i');
    $query->fields('i', ['id', 'name']);
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }

    return $options;
  }

  /**
   * Retrieve Model options.
   */
  private function getMobileModelOptions($item_id) {

    $query = $this->database->select('model', 'm');
    $query->fields('m', ['id', 'name']);
    $query->condition('m.item_id', $item_id);
    $result = $query->execute();

    $model = [];
    foreach ($result as $row) {
      $model[$row->id] = $row->name;
    }
    return $model;
  }

  /**
   * Get Color options.
   */
  public function getColorByModel($model_id) {
    $query = $this->database->select('color', 'c');
    $query->fields('c', ['id', 'name']);
    $query->condition('c.model_id', $model_id);
    $result = $query->execute();

    $color = [];
    foreach ($result as $row) {
      $color[$row->id] = $row->name;
    }

    return $color;
  }

}
