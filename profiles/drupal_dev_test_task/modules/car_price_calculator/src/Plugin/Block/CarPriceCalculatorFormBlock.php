<?php

namespace Drupal\car_price_calculator\Plugin\Block;


use Drupal\Core\Block\BlockBase;

/**
 * Class CarPriceCalculatorFormBlock
 *
 * @Block(
 *   id = "car_price_calculator_form_block",
 *   admin_label = @Translation("Car Price Calculator"),
 *   category = @Translation("Car Price Calculator"),
 * )
 * @package Drupal\car_price_calculator\Plugin\Block
 */
class CarPriceCalculatorFormBlock extends BlockBase {
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    $form = \Drupal::formBuilder()
      ->getForm('Drupal\car_price_calculator\Form\CarPriceCalculatorForm');
    return $form;
  }
  
}
