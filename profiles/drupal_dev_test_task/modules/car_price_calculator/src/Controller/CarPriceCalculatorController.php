<?php

namespace Drupal\car_price_calculator\Controller;


use Drupal\Core\Controller\ControllerBase;

/**
 * Main calculator form controller
 * Class CarPriceCalculatorController
 *
 * @package Drupal\car_price_calculator\Controller
 */
class CarPriceCalculatorController extends ControllerBase {
  
  /**
   * {@inheritdoc}
   */
  public function content() {
    return [
      '#theme' => 'car_price_calculator_template',
    ];
  }
  
}
