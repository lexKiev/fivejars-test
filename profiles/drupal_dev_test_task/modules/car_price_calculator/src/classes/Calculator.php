<?php

namespace Drupal\car_price_calculator\Classes;

class Calculator
{
  public static function calculate($inputAge,$inputCarSize)
  {
    //getting fp & vp values from configs
    $fixedPrice = \Drupal::config('car_price_calculator.settings')
      ->get('fixed_price');
    $variablePrice = \Drupal::config('car_price_calculator.settings')
      ->get('variable_price');
    
  
    //since we change age only in case of '20-24' selected, setting it to 0 by default
    $age = 0;
    if ($inputAge == '20-24') {
      $age = 0.2;
    }
  
    switch ($inputCarSize) {
      case 'medium':
        $carSize = 0.5;
        break;
      case 'large':
        $carSize = 1;
        break;
      default:
        $carSize = 0;
    }
    
    return round($fixedPrice + $variablePrice * (1 + $age + $carSize));
  }
  
}
