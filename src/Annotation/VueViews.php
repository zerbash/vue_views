<?php

namespace Drupal\vue_views\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Vue View item annotation object.
 *
 * @see \Drupal\vue_views\Plugin\VueViewsPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class VueViews extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

}
