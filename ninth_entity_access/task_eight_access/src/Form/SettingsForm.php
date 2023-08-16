<?php

namespace Drupal\task_eight_access\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Specbee assessment settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'task_eight_access';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['task_eight_access.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Fetch available roles.
    $roles = \Drupal::entityTypeManager()
      ->getStorage('user_role')
      ->loadMultiple();

    $role_options = [];
    foreach ($roles as $role) {
      $role_options[$role->id()] = $role->label();
    }

    // Fetch available content types.
    $content_types = \Drupal::entityTypeManager()
      ->getStorage('node_type')
      ->loadMultiple();

    $content_type_options = [];
    foreach ($content_types as $content_type) {
      $content_type_options[$content_type->id()] = $content_type->label();
    }

    // Add role checkboxes.
    $form['roles'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Roles'),
      '#options' => $role_options,
      '#default_value' => $this->config('task_eight_access.settings')->get('roles'),
    ];

    // Add content type checkboxes.
    $form['content_types'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Content Types'),
      '#options' => $content_type_options,
      '#default_value' => $this->config('task_eight_access.settings')->get('content_types'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('task_eight_access.settings')
      ->set('roles', $form_state->getValue('roles'))
      ->set('content_types', $form_state->getValue('content_types'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
