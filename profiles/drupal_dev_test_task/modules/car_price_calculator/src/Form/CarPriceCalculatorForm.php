<?php

namespace Drupal\car_price_calculator\Form;


use Drupal\car_price_calculator\Classes\Calculator;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class CarPriceCalculatorForm
 */
class CarPriceCalculatorForm extends FormBase {
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'car_price_calculator_form';
  }
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#required' => TRUE,
    ];
    
    $form['age'] = [
      '#type' => 'select',
      '#title' => $this->t('Age'),
      '#options' => [
        'placeholder' => t('SELECT AGE'),
        '<20' => '<20',
        '20-24' => '20-24',
        '25+' => '25+',
      ],
      '#ajax' => [
        'callback' => '::changeOptionsAjax',
      ],
    ];
    
    $form['car_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Car size'),
      '#options' => [
        'placeholder' => t('SELECT SIZE'),
        'small' => t('small'),
        'medium' => t('medium'),
        'large' => t('large'),
      ],
      '#ajax' => [
        'callback' => '::changeOptionsAjax',
      ],
    ];
    
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    return $form;
  }
  
  
  public function changeOptionsAjax(array &$form, FormStateInterface $form_state) {
    $inputAge = $form_state->getValue('age');
    $inputCarSize = $form_state->getValue('car_size');
    $response = new AjaxResponse();
    //early return in case of placeholders selected
    if ($inputAge == 'placeholder' || $inputCarSize == 'placeholder') {
      $response->addCommand(new InvokeCommand('#calculation_result', 'val', ['']));
      return $response;
    }
    
    //if age <20 selected returning message
    if ($inputAge == 'placeholder' || $inputAge == '<20') {
      $response->addCommand(new InvokeCommand('#calculation_result', 'val', ['You must be at least 20 years old']));
      return $response;
    }
    
    //calculating
    $totalPrice = Calculator::calculate($inputAge,$inputCarSize);
    
    $formattedPrice = '$' . $totalPrice;
    
    //set result to input
    $response->addCommand(new InvokeCommand('#calculation_result', 'val', [$formattedPrice]));
    
    return $response;
  }
  
  
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('age') == '<20') {
      $form_state->setErrorByName('age', $this->t('You must be at least 20 years old'));
    }
    if ($form_state->getValue('age') == 'placeholder') {
      $form_state->setErrorByName('age', $this->t('Please select age'));
    }
    if ($form_state->getValue('car_size') == 'placeholder') {
      $form_state->setErrorByName('car_size', $this->t('Please select car size'));
    }
  }
  
  /**
   * {@inheritdoc}
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $name = $form_state->getValue('name');
    $age = $form_state->getValue('age');
    $carSize = $form_state->getValue('car_size');
    
    $totalPrice = Calculator::calculate($age,$carSize);
    
    $query = \ Drupal:: database()->insert('car_price_calculator');
    $query->fields([
      'name' => $name,
      'age' => $age,
      'car_size' => $carSize,
      'calculated_price' => $totalPrice,
    ]);
    $query->execute();
    
    $this->messenger()
      ->addStatus($this->t('Your order has been saved'));
  }
  
}
