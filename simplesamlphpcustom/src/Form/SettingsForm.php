<?php

namespace Drupal\simplesamlphpcustom\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure simplesamlphpcustom settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'equipment_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['equipment.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['equipment_form_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Equipment Form Id'),
      '#default_value' => $this->config('equipment.settings')->get('equipment_form_id'),
      '#required' => true,
    ];
    $form['equipment_view_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Equipment View Id'),
      '#default_value' => $this->config('equipment.settings')->get('equipment_view_id'),
      '#required' => true,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('equipment.settings')
      ->set('equipment_form_id', $form_state->getValue('equipment_form_id'))
      ->set('equipment_view_id', $form_state->getValue('equipment_view_id'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
