<?php

namespace Drupal\vue_views\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Traversable;

/**
 * Provides the Vue View plugin manager.
 */
class VueViewsPluginManager extends DefaultPluginManager {

  /**
   * Constructs a new VueViewManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/VueViews', $namespaces, $module_handler, 'Drupal\vue_views\Plugin\VueViewsPluginInterface', 'Drupal\vue_views\Annotation\VueViews');
    $this->alterInfo('vue_views_info');
    $this->setCacheBackend($cache_backend, 'vue_views_plugins');
  }

}
