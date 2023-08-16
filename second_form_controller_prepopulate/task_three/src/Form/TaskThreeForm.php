<?php

namespace Drupal\task_three\Form;

use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This is the form for task three.
 */
class TaskThreeForm extends FormBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * TaskThreeForm constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager service.
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection service.
   * @param \Drupal\Core\Session\AccountInterface $currentUser
   *   The current user service.
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager, Connection $database, AccountInterface $currentUser) {
    $this->entityTypeManager = $entityTypeManager;
    $this->database = $database;
    $this->currentUser = $currentUser;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('database'),
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'task_three_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, NodeInterface $node = NULL) {
    $user = $this->currentUser;
    $user_entity = $this->entityTypeManager->getStorage('user')->load($user->id());
    $default_node = $node ? $node->getTitle() : '';

    $form['title'] = [
      '#type' => 'textfield',
      '#title' => 'Title',
      '#required' => TRUE,
      '#placeholder' => 'Title',
      '#default_value' => $default_node,
    ];

    $form['user'] = [
      '#type' => 'entity_autocomplete',
      '#title' => 'User',
      '#target_type' => 'user',
      '#required' => TRUE,
      '#default_value' => $user_entity,
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
    // Get the title and user ID from the form state.
    $title = $form_state->getValue('title');
    $user_id = $form_state->getValue('user');
    // Load the user entity by ID.
    $user = $this->entityTypeManager->getStorage('user')->load($user_id);

    // If the user exists, insert the data into the `task_three_data` table.
    if ($user) {
      $data = [
        'title' => $title,
        'user_id' => $user_id,
      ];
      $this->database->insert('task_three_data')->fields($data)->execute();
    }
  }

}
