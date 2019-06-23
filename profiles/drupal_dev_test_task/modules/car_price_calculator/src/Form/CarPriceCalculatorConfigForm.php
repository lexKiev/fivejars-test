<?php

namespace Drupal\car_price_calculator\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Main car price calculator config form
 * Class CarPriceCalculatorConfigForm
 *
 * @package Drupal\car_price_calculator\Form
 */
class CarPriceCalculatorConfigForm extends ConfigFormBase {
  
  /** @var string Config settings */
  const SETTINGS = 'car_price_calculator.settings';
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'calculator_settings';
  }
  
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    
    $form['fixed_price'] = [
      '#type' => 'number',
      '#title' => $this->t('Fixed price'),
      '#min' => 20,
      '#step' => 0.1,
      '#default_value' => $config->get('fixed_price'),
    ];
    
    $form['variable_price'] = [
      '#type' => 'number',
      '#title' => $this->t('Variable price'),
      '#min' => 100,
      '#step' => 0.1,
      '#default_value' => $config->get('variable_price'),
    ];
    
    return parent::buildForm($form, $form_state);
  }
  
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    $this->configFactory->getEditable(static::SETTINGS)
      // Set the submitted configuration setting
      ->set('fixed_price', $form_state->getValue('fixed_price'))
      // You can set multiple configurations at once by making
      // multiple calls to set()
      ->set('variable_price', $form_state->getValue('variable_price'))
      ->save();
    
    parent::submitForm($form, $form_state);
  }
  
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }
  
}
