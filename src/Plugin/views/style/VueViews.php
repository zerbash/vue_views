<?php

namespace Drupal\vue_views\Plugin\views\style;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\vue_views\Plugin\VueViewsPluginManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Default style plugin to render a Vue application.
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "vue_views",
 *   title = @Translation("Vue"),
 *   help = @Translation("Display view using Vue js."),
 *   theme = "vue_views",
 *   display_types = {"normal"}
 * )
 */
class VueViews extends StylePluginBase {

  /**
   * {@inheritdoc}
   */
  protected $usesFields = TRUE;

  /**
   * {@inheritdoc}
   */
  protected $usesGrouping = FALSE;

  /**
   * @var \Drupal\vue_views\Plugin\VueViewsPluginManager
   */
  private $vueViewsPluginManager;

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    VueViewsPluginManager $vueViewsManager
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->vueViewsPluginManager = $vueViewsManager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('plugin.manager.vue_views')
    );
  }

  /**
   * Returns Vue View plugin options
   *
   * @return array
   *   An array of plugin labels keyed by id
   */
  protected function getPlugins() {
    $plugins = $this->vueViewsPluginManager->getDefinitions();
    return array_combine(array_keys($plugins),array_column($plugins,'label'));
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    if ($options = $this->getPlugins()) {
      $default = $this->options['vue_views_plugin'] ?: 0;
      $form['vue_views_plugin'] = [
        '#type' => 'select',
        '#require' => TRUE,
        '#title' => t('Select Plugin'),
        '#default_value' => $default,
        '#options' => $options,
      ];
    } else {
      $form['vue_views_plugin'] = [
        '#markup' => $this->t('No Vue Views plugins found')
      ];
    }

  }

  public function themeFunctions() {
    $pluginId = $this->options['vue_views_plugin'];
    $themes = $this->view->buildThemeFunctions($pluginId);
    $themes[] = $this->definition['theme'];
    return $themes;
  }

  /**
   * Render the display in this style.
   */
  public function render() {
    $this->renderFields($this->view->result);
    $this->attachData();
    $this->attachLibrary();
    $output = [
      '#theme' => $this->themeFunctions(),
      '#view' => $this->view,
      '#rows' => $this->rendered_fields
    ];
    if ($this->view->preview) {
      $output['#prefix'] = $this->t('Note: Since the results are in the JS drupalSettings object, this live preview may not <em>appear</em> to contain anything.');
    }
    return $output;
  }

  public function attachLibrary() {
    if (isset($this->options['vue_views_plugin'])) {
      $vuePluginId = $this->options['vue_views_plugin'];
      $definition = $this->vueViewsPluginManager->getDefinition($vuePluginId);
      $library = $definition['provider'] . '/' . $vuePluginId;
      $this->view->element['#attached']['library'][] = $library;
    }
  }

  public function attachData() {
    $this->view->element['#attached']['drupalSettings']['vue_views_data'] = $this->rendered_fields;
  }
}
