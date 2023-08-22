<?php

namespace Drupal\sixteenth_cache\Controller;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

/**
 * Returns responses for cache task routes.
 */
class CacheParamConvertor extends ControllerBase {

  /**
   * Build function.
   */
  public function build(Node $node) {
    $nid = $node->id();
    $cid = 'marki:' . $nid;

    // Look for the item in cache, don't have to do work if we don't need to.
    if ($item = \Drupal::cache()->get($cid)) {
      return $item->data;
    }

    // Build up the markidown array we're going to use later.
    $node = Node::load($nid);
    $marki = [
      '#title' => $node->get('title')->value,
    ];

    // Set the cache so we don't need to do this work again until $node changes.
    \Drupal::cache()->set($cid, $marki, Cache::PERMANENT, $node->getCacheTags());

    return $marki;
  }

}
