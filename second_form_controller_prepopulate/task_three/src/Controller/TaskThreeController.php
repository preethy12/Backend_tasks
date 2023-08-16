<?php

namespace Drupal\task_three\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\node\NodeInterface;
use Drupal\task_three\Form\TaskThreeForm;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller to handle tasks.
 */
class TaskThreeController extends ControllerBase {

  /**
   * The form builder service.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * ControllerTask constructor.
   *
   * @param \Drupal\Core\Form\FormBuilderInterface $formBuilder
   *   The form builder service.
   */
  public function __construct(FormBuilderInterface $formBuilder) {
    $this->formBuilder = $formBuilder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder')
    );
  }

  /**
   * Render the custom form.
   *
   * @param \Drupal\node\NodeInterface|null $node
   *   The node entity (if available).
   *
   * @return array
   *   A renderable array containing the form.
   */
  public function content(NodeInterface $node = NULL) {
    /* If the node object is not null, the form is pre-filled with the data from the node.*/
    $form = $this->formBuilder->getForm(TaskThreeForm::class, $node);
    return $form;
  }

}
