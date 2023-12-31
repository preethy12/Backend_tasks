<?php

declare(strict_types=1);

namespace Drupal\mail_task_four\Form;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Utility\Token;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This is the Form.
 */
class ExampleForm extends ConfigFormBase {

  const RESULT = 'ExampleForm.settings';

  /**
   * The token service.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * Constructs an ExampleForm object.
   *
   * @param \Drupal\Core\Utility\Token $token
   *   The token service.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler service.
   */
  public function __construct(Token $token, ModuleHandlerInterface $module_handler) {
    $this->token = $token;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('token'),
      $container->get('module_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'ExampleForm_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
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
      '#title' => $this->t('Help Text'),
      '#default_value' => $config->get('subject'),
    ];
    $form['text_area'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Email Content'),
      '#default_value' => $config->get('text_area'),
    ];

    // Token support.
    if ($this->moduleHandler->moduleExists('token')) {
      $form['tokens'] = [
        '#title' => $this->t('Tokens'),
        '#type' => 'container',
      ];
      $form['tokens']['help'] = [
        '#theme' => 'token_tree_link',
        '#token_types' => [
          'node',
        ],
        '#global_types' => FALSE,
        '#dialog' => TRUE,
      ];
    }

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable(static::RESULT);
    $config->set('subject', $form_state->getValue('subject'));
    $config->set('text_area', $form_state->getValue('text_area'));
    $config->save();
    parent::submitForm($form, $form_state);
  }

}
