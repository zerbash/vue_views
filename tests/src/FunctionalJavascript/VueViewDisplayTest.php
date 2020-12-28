<?php

namespace Drupal\Tests\vue_views\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;
use Drupal\Tests\node\Traits\NodeCreationTrait;

/**
 * Simple test to ensure that main page loads with module enabled.
 *
 * @group vue_views
 */
class VueViewDisplayTest extends WebDriverTestBase {

  use NodeCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'node',
    'views',
    'vue_views',
    'vue_views_test'
  ];

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'classy';


  /**
   * {@inheritdoc}
   */
  public function setUp(): void {
    parent::setUp();


  }

  public function testVuePageDisplay() {
    $title_1 = $this->createNode()->getTitle();
    $title_2 = $this->createNode()->getTitle();

    $this->drupalGet('vue-views-test');
    $this->assertJsCondition('Vue !== null');
    $this->assertSession()->pageTextContains($title_1 . ' placed by Twig');
    $this->assertSession()->pageTextContains($title_2 . ' placed by Vue');

//    $this->drupalGet('test_page_display_200');
//    $page = $this->getSession()->getPage();
//    $rows = $page->findAll('css', 'tbody tr');
//    $this->assertCount(2, $rows);
  }
//  /**
//   * Tests adding a Vue style to a page display.
//   */
//  public function testAdminSettings() {
//    $this->drupalGet('admin/structure/views/view/test_page_view');
//    $page = $this->getSession()->getPage();
//
//    // Select Display styles
//    $page->find('css', '#views-page-1-style')->click();
//
//    $this->assertSession()->assertWaitOnAjaxRequest();
//
//    // Assert Vue display style is available.
//    $vueStyleElement = $this->assertSession()->elementExists('css', 'input[value="vue_views"]');
//
//    // Select Vue style
//    $vueStyleElement->click();
//
//    // Find the modal form and submit
//    $submit = $page->find('css','.views-ui-edit-display-form');
//    $submit->submit();
//
//    $this->assertSession()->assertWaitOnAjaxRequest();
//
//    // Assert that our demo plugin was found
//    $this->assertSession()->elementExists('css','option[value="vue_views_test"]');
//    $submit->submit();
//
//    $this->assertSession()->assertWaitOnAjaxRequest();
//
//    // Assert the text from the demo template is rendered in preview
//    $this->assertSession()->elementContains('css','.preview-section','this live preview may not <em>appear</em>em> to contain anything');
//
//  }

}
