<?php

namespace Drupal\zscaler_custom\EventSubscriber;

use Drupal\zscaler_custom\Event\ZscalerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ZscalerEventSubscriber.
 *
 * @package Drupal\zscaler_custom\EventSubscriber
 */
class ZscalerEventSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      ZscalerEvent::INSERT => 'onEntityInsert',
      ZscalerEvent::UPDATE => 'onEntityUpdate',
      ZscalerEvent::DELETE => 'onEntityDelete',
    ];
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\custom_events\Event\ZscalerEvent $event
   *   Dat event object yo.
   */
  public function onEntityInsert(ZscalerEvent $event) {    
    $nid = $event->entity->id();
    // Sent email
    $this->zsc_sent_email($nid, 'insert');
    \Drupal::messenger()->addStatus(t('Entity Insert- %id.', [
      '%id' => $nid,
    ]));
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\custom_events\Event\ZscalerEvent $event
   *   Dat event object yo.
   */
  public function onEntityUpdate(ZscalerEvent $event) {
    $database = \Drupal::database();
    $nid = $event->entity->id();
    $query  = $database->select('zsc_email_notification', 'zen')
    ->fields('zen', ['nid','notification_status'])
    ->condition('zen.nid', $nid);    
    $results = $query ->execute()->fetchAll();

    $status= false;
    foreach($results as $item){
      if(!$item->notification_status) {
        $status = true;
        break;
      }
    }

    \Drupal::messenger()->addStatus(t('Entity Update - %id.', [
      '%id' => $nid,
    ]));

    if($status) {
      // Sent email
      $this->zsc_sent_email($nid, 'update');
    }
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\custom_events\Event\ZscalerEvent $event
   *   Dat event object yo.
   */
  public function onEntityDelete(ZscalerEvent $event) {
    $id = $event->entity->id();    
    \Drupal::messenger()->addStatus(t('Deleted - %id.', [
      '%id' => $id,
    ]));
  }

  public function zsc_sent_email($nid, $type) {
    
    $node = \Drupal::entityTypeManager()->getStorage('node')->load($nid);
    if($node) {   
      $title = $node->get('title')->value;   
      $author = $node->uid->entity;
      $author_email = $author->mail->value;
      $author_name = $author->name->value;
      $mailManager = \Drupal::service('plugin.manager.mail');
      $module = 'zscaler_custom';
      $key = 'node_insert';
      $to = \Drupal::currentUser()->getEmail();
      $params['message'] = "Dear " .  $author_name . "," . "\n" . "The Node - " . $title . " Updated";
      $params['title'] = "Notifications - ". $title . " - Updated";
      $langcode = \Drupal::currentUser()->getPreferredLangcode();
      $send = true;
    
      $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
      if ($result['result'] != true) {
        $message = t('There was a problem sending your email notification to @email.', array('@email' => $to));
        \Drupal::messenger()->addStatus(t('%message.', [
          '%message' => $message,
        ]));
        \Drupal::logger('mail_log')->error($message);
        $notification_status = 0;
        $this->zsc_update_notification($nid, $type, $notification_status);
        return;
      }
  
      $message = t('An email notification has been sent to @email ', array('@email' => $to));
      \Drupal::messenger()->addStatus(t('%message.', [
        '%message' => $message,
      ]));
      \Drupal::logger('mail-log')->notice($message);

      $notification_status = 1;
      $this->zsc_update_notification($nid, $type, $notification_status);
    }
    return;
  }

  public function zsc_update_notification($nid, $type, $notification_status) { 
    $database = \Drupal::database();
    // update notification table
    switch ($type) {
      case 'insert':          
        $res = $database->insert('zsc_email_notification')
        ->fields([
          'nid' => $nid,
          'created' => \Drupal::time()->getRequestTime(),
          'changed' => \Drupal::time()->getRequestTime(),
          'notification_status' => $notification_status,
        ])
        ->execute();
        break;
      case 'update':          
        $database->update('zsc_email_notification')
        ->fields([
          'notification_status' => $notification_status,
          'changed' => \Drupal::time()->getRequestTime(),
        ])
        ->condition('nid', $nid, '=')
        ->execute();
        break;
    }
    return;
  }

}