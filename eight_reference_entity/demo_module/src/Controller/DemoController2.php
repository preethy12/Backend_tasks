<?php

namespace Drupal\demo_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * This is demo Controller2.
 */
class DemoController2 extends ControllerBase {

  /**
   * The entity type manager service.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new DemoController2 object.
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
    $node = 1;
    $node_entity = $this->entityTypeManager
      ->getStorage('node')
      ->load($node);
    // Get the node title.
    $title = $node_entity->getTitle();
    $field_name = 'field_colors';
    $field_users = 'field_user';
    $taxonomy_terms = $node_entity->get($field_name)->entity;
    $xxx = $taxonomy_terms->getName();
    $referenced_users = $taxonomy_terms->get($field_users)->entity->getDisplayName();
    $result = $title . ' ' . $xxx . ' ' . $referenced_users;
    return new Response($result);
  }

}
