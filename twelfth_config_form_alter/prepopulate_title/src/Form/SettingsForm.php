<?php

namespace Drupal\prepopulate_title\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Configure prepopulate_title settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  const CONFIGNAME = 'prepopulate_title.settings';

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * MyModuleService constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The database connection.
   */
  public function __construct(MessengerInterface $messenger, ConfigFactoryInterface $config_factory) {
    $this->messenger = $messenger;
    parent::__construct($config_factory);
  }

  /**
   * Create a new instance of MyModuleService.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The service container.
   *
   * @return static
   *   A new instance of MyModuleService.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'prepopulate_title_settings';
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
    $tags_reference = $config->get('tags_reference');
    $vocabulary = $this->entityTypeManager()->getStorage('taxonomy_term')->load($tags_reference);

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('title'),
    ];
    $form['advanced'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Default advanced Value'),
      '#default_value' => $config->get('advanced'),
    ];
    $form['tags_reference'] = [
      '#type' => 'entity_autocomplete',
      '#title' => $this->t('Default Tag Vocabulary'),
      '#target_type' => 'taxonomy_term',
      '#default_value' => $vocabulary,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config(static::CONFIGNAME)
      ->set('title', $form_state->getValue('title'))
      ->set('advanced', $form_state->getValue('advanced'))
      ->set('tags_reference', $form_state->getValue('tags_reference'))
      ->save();
    // $this->messenger->addStatus($this->t('the configuration options have been saved'));
    parent::submitForm($form, $form_state);
  }

}
