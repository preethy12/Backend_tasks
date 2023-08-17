<?php

declare(strict_types = 1);

namespace Drupal\thirteen_checkbox\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Thirteen checkbox form.
 */
class ExampleForm extends FormBase {
  /**
   * The logger channel.
   *
   * @var \Psr\Log\LoggerInterface
   */
  protected $logger;

  /**
   * Constructs a CustomLogger object.
   *
   * @param \Drupal\Core\Log\LoggerInterface $logger
   *   The logger service.
   */
  public function __construct(LoggerInterface $logger) {
    $this->logger = $logger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('logger.factory')->get('thirteen_checkbox_example')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'thirteen_checkbox_example';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['#attached']['library'][] = "thirteen_checkbox/jss_lib";

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => t('first name'),
      '#required' => TRUE,
    ];
    $form['no_last_name'] = [
      '#type' => 'checkbox',
      '#title' => t('no last name'),
      '#attributes' => ['id' => 'no-last-name'],
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => t('last name'),
      // '#states' => [
      // 'visible' => [
      // ':input[name="no_last_name"]' => ['checked' => FALSE],
      // ],
      // ],
    ];
    $form['action'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('send'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    // $this->logger->warning($this->t('The message has been sent.'));
    // $this->logger->notice($this->t('The message has been sent.'));
    $this->logger->error($this->t('The message has been sent.'));
    $this->messenger()->addStatus($this->t('submitted'));

  }

}
