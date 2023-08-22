<?php

namespace Drupal\sixteenth_cache\Controller;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Controller for handling tasks related to ControllerTask module.
 */
class CacheTask extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $nid = 12;
    $cid = 'markone:' . $nid;

    // Look for item in cache so we don't have to do work if we don't need to.
    if ($item = \Drupal::cache()->get($cid)) {
      return $item->data;
    }

    // Build up the markdown array we're going to use later.
    $node = Node::load($nid);
    $title = $node->getTitle();
    $markone = [
      // '#title' => $node->get('title')->value,
      '#markup' => $title,
      // ...
    ];

    // Set the cache so we don't need to do this work again until $node changes.
    \Drupal::cache()->set($cid, $markone, Cache::PERMANENT, $node->getCacheTags());

    return $markone;
  }

}
