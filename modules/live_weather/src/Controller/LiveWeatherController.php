<?php

namespace Drupal\live_weather\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Drupal\Component\Utility\Html;

/**
 * Controller for live_weather WOEID settings.
 */
class LiveWeatherController extends ControllerBase {

  /**
   * The form builder service.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * The configuration factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a live_weather controller object.
   *
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory holding resource settings.
   */
  public function __construct(FormBuilderInterface $form_builder, ConfigFactoryInterface $config_factory) {
    $this->formBuilder = $form_builder;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder'),
      $container->get('config.factory')
    );
  }

  /**
   * Constructs a list of locations.
   */
  public function locationList() {
    $rows = $build = [];
    $location_list = $this->configFactory
      ->get('live_weather.location')
      ->get('location');

    $form_arg = 'Drupal\live_weather\Form\LiveWeatherForm';
    $build['live_weather_form'] = $this->formBuilder->getForm($form_arg);

    $header = [
      $this->t('Woeid'),
      $this->t('Location'),
      [
        'data' => $this->t('Operations'),
        'colspan' => 2,
      ],
    ];

    if (!empty($location_list)) {
      foreach ($location_list as $key => $value) {
        $operations = [];
        $operations['delete'] = [
          'title' => $this->t('Delete'),
          'url' => Url::fromRoute('live_weather.delete', ['woeid' => $key]),
        ];

        $data['woeid'] = $key;
        $data['location'] = Html::escape($value);
        $data['operations'] = [
          'data' => [
            '#type' => 'operations',
            '#links' => $operations,
          ],
        ];

        $rows[] = $data;
      }
    }

    $build['live_weather_table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No locations available.'),
    ];

    return $build;
  }

}
