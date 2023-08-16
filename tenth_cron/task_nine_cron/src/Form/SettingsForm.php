<?php

declare(strict_types = 1);

namespace Drupal\task_nine_cron\Form;

// Namespace.
// Using base classes.
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class creation.
 */
class SettingsForm extends ConfigFormBase {

  // It gives form id.
  const RESULT = "task_nine_cron.settings";

  /**
   * To get form id.
   */
  public function getFormId() {
    return "task_nine_cron";
  }

  /**
   * To get editable names.
   */
  protected function getEditableConfigNames() {
    // To get names.
    return [
    // Static result.
      static::RESULT,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::RESULT);
    $form['subject'] = [
      '#type' => 'textfield',
      '#title' => 'Help Text',
      '#default_value' => $config->get("subject"),

    ];
    $form['text_area'] = [
      '#type' => 'textarea',
      '#title' => 'Email Content',
      '#default_value' => $config->get('text_area'),
    ];

    // Token support.
    if (\Drupal::moduleHandler()->moduleExists('token')) {
      $form['tokens'] = [
        '#title' => $this->t('Tokens'),
        '#type' => 'container',
      ];
      $form['tokens']['help'] = [
        '#theme' => 'token_tree_link',
        '#token_types' => [
          'node',
        ],
            // '#token_types' => 'all'
        '#global_types' => FALSE,
        '#dialog' => TRUE,
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * Submit form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save the subject and text area values.
    $config = $this->configFactory()->getEditable(static::RESULT);
    $config->set('subject', $form_state->getValue('subject'));
    $config->set('text_area', $form_state->getValue('text_area'));
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
