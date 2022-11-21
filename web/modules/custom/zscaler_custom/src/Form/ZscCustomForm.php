<?php

namespace Drupal\zscaler_custom\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;
use Drupal\Core\Routing;

/**
 * Provides the form for ZscCustomForm.
 */
class ZscCustomForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'zscaler_custom_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#maxlength' => 64,
      '#size' => 64,
      '#weight' => '0',
    ];
    $form['body'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Body'),
      '#weight' => '0',
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;

  }
  
   /**
   * {@inheritdoc}
   */
  public function validateForm(array & $form, FormStateInterface $form_state) {
   
    parent::validateForm($form, $form_state);

    $title = $form_state->getValue('title');
    $body = $form_state->getValue('body');

    if (empty($title)) {
      // Set an error for the form element with a key of "title".
      $form_state->setErrorByName('title', $this->t('Title must be given.'));
    }
		
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array & $form, FormStateInterface $form_state) {
    try{    
      $title = $form_state->getValue('title');
      $body = $form_state->getValue('body');
      $node = \Drupal::entityTypeManager()->getStorage('node')->create([
        'type'        => 'zscaler',
        'title'       => $title,
        'langcode'    => 'en',
        'body' => [
          'summary' => '',
          'value' => $body['value'],
          'format' => 'full_html',
        ],
      ]);
      $node->save();
      if($node) {
        $form_state->setRedirect('entity.node.canonical', ['node' => $node->id()]);
      }      

    } catch(Exception $ex){
      \Drupal::logger('zsc_logger')->error($ex->getMessage());
    }
    
  }

}