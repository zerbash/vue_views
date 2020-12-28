<?php

namespace Drupal\Tests\vue_views\Kernel;

use Drupal\Tests\views\Kernel\Plugin\PluginKernelTestBase;
use Drupal\views\Views;

/**
 * Tests the vue views plugin
 */
class VueViewsPluginTest extends PluginKernelTestBase {

  /**
   * Views used by this test.
   *
   * @var array
   */
  public static $testViews = ['test_view'];

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'vue_views',
    'vue_views_test'
  ];

  /**
   * Tests that the Vue Views style plugin is discovered
   */
  public function testViewsStylePlugin() {
    // Assert that the Vue Views style plugin is discovered
    $this->assertArrayHasKey('vue_views', Views::fetchPluginNames('style'));
  }

  /**
   * Tests the Vue Views style plugin output
   */
  public function testVueViewsStyle() {
    $renderer = $this->container->get('renderer');
    $view = Views::getView('test_view');
    $plugin_options = [
      'type' => 'vue_views',
      'options' => [
        'vue_views_plugin' => 'vue_views_test'
      ]
    ];
    $view->getDisplay()->setOption('style',$plugin_options);
    $output = $view->preview();
    $this->assertContains('vue_views_test/vue_views_test',$output['#attached']['library']);
    $output = $renderer->renderRoot($output);
    $this->assertStringContainsString('<div id="vue-views-app">', (string) $output);
  }


}
