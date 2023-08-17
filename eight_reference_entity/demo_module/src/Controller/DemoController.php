<?php

namespace Drupal\demo_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * This is demo Controller.
 */
class DemoController extends ControllerBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new DemoController object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager')
    );
  }

  /**
   * Callback for the /demo_module/{node} route.
   */
  public function getNodeInfo() {
    $node = 7;
    $node_entity = $this->entityTypeManager
      ->getStorage('node')
      ->load($node);
    // Get the node title.
    $title = $node_entity->getTitle();
    $field_name = 'field_colors';
    $field_users = 'field_user';
    $term = $node_entity->get($field_name)->referencedEntities()[0];
    $term_name = $term->getName();
    $referenced_users = $term->get($field_users)->referencedEntities()[0];
    $user_name = $referenced_users->getDisplayName();
    $result = $title . ' ' . $term_name . ' ' . $user_name;
    return new Response($result);
  }

}
