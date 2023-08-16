<?php

namespace Drupal\task_five_events\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Response subscriber to remove these X-Generator header tag.
 */
class HeadersManagerResponseSubscriber implements EventSubscriberInterface {

  /**
   * Remove extra X-Generator header on successful responses.
   *
   * @param \Symfony\Component\HttpKernel\Event\ResponseEvent $event
   *   The event to process.
   */
  public function headersManagerOptions(ResponseEvent $event) {
    $response = $event->getResponse();
    $response->headers->remove('X-Generator');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['headersManagerOptions', -10];
    return $events;
  }

}
