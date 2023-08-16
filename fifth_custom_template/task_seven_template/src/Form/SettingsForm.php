<?php

namespace Drupal\task_seven_template\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Specbee assessment settings for this site.
 */
class SettingsForm extends ConfigFormBase {
  const CONFIGNAME = 'task_seven_template.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'task_seven_template_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::CONFIGNAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::CONFIGNAME);
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->config('task_seven_template.settings')->get('title'),
      '#required' => TRUE,
    ];

    $format = 'basic_html';
    if ($this->config('task_seven_template.settings')->get('text')['format']) {
      $format = $this->config('task_seven_template.settings')->get('text')['format'];
    }

    $form['Paragraph'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Paragraph'),
      '#format' => $format,
      '#default_value' => $this->config('task_seven_template.settings')->get('Paragraph')['value'],
      '#required' => TRUE,
    ];

    $form['color_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Color Code'),
      '#default_value' => $this->config('task_seven_template.settings')->get('color_code'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config(static::CONFIGNAME);
    $config->set('title', $form_state->getValue('title'));
    $config->set('Paragraph', $form_state->getValue('Paragraph'));
    $config->set('color_code', $form_state->getValue('color_code'));
    $config->save();
  }

}
