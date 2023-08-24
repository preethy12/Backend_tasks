<?php

namespace Drupal\maintenance_mode_drush\Commands;

use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\State\StateInterface;
use Drush\Commands\DrushCommands;

/**
 * Drush command to put the site into maintenance mode.
 *
 * @package Drupal\seventeenth_drush_maintenance_mode\Commands
 */
class CustomTask extends DrushCommands {

  /**
   * The state service.
   *
   * @var \Drupal\Core\State\StateInterface
   */
  protected $state;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * Constructor for the DrushTask class.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\State\StateInterface $state
   *   The state service.
   */
  public function __construct(MessengerInterface $messenger, StateInterface $state) {
    $this->messenger = $messenger;
    $this->state = $state;
    parent::__construct();
  }

  /**
   * Put the site into maintenance mode.
   *
   * @command custom-maintenance-mode
   * @aliases cmm
   * @usage custom-maintenance-mode
   */
  public function customMaintenanceMode() {
    // Put the site into maintenance mode.
    $this->state->set('system.maintenance_mode', TRUE);

    $this->messenger->addStatus('Site is now in maintenance mode.');
  }

}
