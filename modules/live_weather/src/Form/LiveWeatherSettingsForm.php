<?php

/**
 * @file
 * Contains \Drupal\live_weather\Form\LiveWeatherSettingsForm.
 */
namespace Drupal\live_weather\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Live Weather Settings Form.
 */
class LiveWeatherSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'live_weather_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'live_weather.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $settings = $this->configFactory->get('live_weather.settings')->get('settings');
    $yes_no_options = [
      FALSE => $this->t('No'),
      TRUE => $this->t('Yes'),
    ];

    $form['#tree'] = TRUE;
    $form['settings']['app_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Yahoo App ID'),
      '#required' => TRUE,
      '#default_value' => empty($settings['app_id']) ? '' : $settings['app_id'],
      '#description' => $this->t('Please enter your Yahoo App ID.'),
    ];

    $form['settings']['consumer_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Yahoo App Consumer Key'),
      '#required' => TRUE,
      '#default_value' => empty($settings['consumer_key']) ? '' : $settings['consumer_key'],
      '#description' => $this->t('Please enter your Yahoo App Consumer Key.'),
    ];

    $form['settings']['consumer_secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Yahoo App Consumer Secret Key'),
      '#required' => TRUE,
      '#default_value' => empty($settings['consumer_secret']) ? '' : $settings['consumer_secret'],
      '#description' => $this->t('Please enter your Yahoo App Consumer Secret Key.'),
    ];

    $form['settings']['unit'] = [
      '#type' => 'select',
      '#title' => $this->t('Unit'),
      '#options' => [
        'F' => $this->t('Fahrenheit'),
        'C' => $this->t('Celsius'),
      ],
      '#default_value' => $settings['unit'],
      '#description' => $this->t('Select Fahrenheit or Celsius for temperature unit.'),
    ];

    $form['settings']['image'] = [
      '#type' => 'select',
      '#title' => $this->t('Image'),
      '#options' => $yes_no_options,
      '#default_value' => $settings['image'],
      '#description' => $this->t('Select Yes to show Forcast Image.'),
    ];

    $form['settings']['wind'] = [
      '#type' => 'select',
      '#title' => $this->t('Wind'),
      '#options' => $yes_no_options,
      '#default_value' => $settings['wind'],
      '#description' => $this->t('Select Yes to show wind speed.'),
    ];

    $form['settings']['humidity'] = [
      '#type' => 'select',
      '#title' => $this->t('Humidity'),
      '#options' => $yes_no_options,
      '#default_value' => $settings['humidity'],
      '#description' => $this->t('Select Yes to show humidity level.'),
    ];

    $form['settings']['visibility'] = [
      '#type' => 'select',
      '#title' => $this->t('Visibility'),
      '#options' => $yes_no_options,
      '#default_value' => $settings['visibility'],
      '#description' => $this->t('Select Yes to show visibility level.'),
    ];

    $form['settings']['sunrise'] = [
      '#type' => 'select',
      '#title' => $this->t('Sunrise'),
      '#options' => $yes_no_options,
      '#default_value' => $settings['sunrise'],
      '#description' => $this->t('Select Yes to show sunrise time.'),
    ];

    $form['settings']['sunset'] = [
      '#type' => 'select',
      '#title' => $this->t('Sunset'),
      '#options' => $yes_no_options,
      '#default_value' => $settings['sunset'],
      '#description' => $this->t('Select Yes to show sunset time.'),
    ];

    $form['settings']['cache'] = [
      '#type' => 'select',
      '#title' => $this->t('Cache'),
      '#options' => [
        0 => $this->t('No Cache'),
        1800 => $this->t('30 min'),
        3600 => $this->t('1 hour'),
        86400 => $this->t('One day'),
      ],
      '#default_value' => $settings['cache'],
      '#description' => $this->t('Time for cache the block.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $form_value = $form_state->getValue('settings');
    $this->config('live_weather.settings')
      ->set('settings', $form_value)
      ->save();
    parent::submitForm($form, $form_state);
  }

}
