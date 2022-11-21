<?php

namespace Drupal\zscaler_custom\Commands;

use Drush\Commands\DrushCommands;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class ZscDrushCommands
 * @package Drupal\zscaler_custom\Commands
 */
class ZscDrushCommands extends DrushCommands {
 
  /**
   * @var Drupal\Core\Database\Connection; 
   */
  protected $database;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;
 
  /**
   * constructor.
   * @param Drupal\Core\Database\Connection $connection
   */
  public function __construct(Connection $connection,EntityTypeManagerInterface $entity_type_manager) {
    $this->database = $connection;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database'),
      $container->get('entity_type.manager')
    );
  }
 
  /**
   * @command zscaler_custom:zsc-email-notification
   * @usage drush zscaler_custom:zsc-email-notification
   * @validate-module-enabled zscaler_custom
   *
   * @aliases zsc-email-notification
   */
  public function zsc_email_notification() {
    $query  = $this->database->select('zsc_email_notification', 'zen')
    ->fields('zen', ['nid','notification_status'])
    ->condition('zen.notification_status', 0);
    $query->range(0, 5);
    $query->orderBy('changed', 'DESC');
    $results = $query ->execute()->fetchAll();

    if($results) {
      foreach($results as $item){      
        $this->zsc_sent_email_notification($item->nid);
      }
    }
    else {
      print '----- There no pending Email notifications -------' . "\n";
    }      
  }

  public function zsc_sent_email_notification($nid) {
    print '--nid->'. $nid . "\n";
    $node = $this->entityTypeManager->getStorage('node')->load($nid);
    if($node) {
      $title = $node->get('title')->value;
      print '--Node Title->'. $node->get('title')->value;        
      $author = $node->uid->entity;
      $author_email = $author->mail->value;
      $author_name = $author->name->value;
      print ' --Author Name->'. $author_name;
      print ' --Author Email->'. $author_email;
      print "\n";

      $mailManager = \Drupal::service('plugin.manager.mail');
      $module = 'zscaler_custom';
      $key = 'node_insert';
      $to = $author_email;
      $params['message'] = "Dear " .  $author_name . "," . "\n" . "The Node - " . $title . " Updated";
      $params['title'] = "Notifications - ". $title . " - Updated";
      $langcode = \Drupal::currentUser()->getPreferredLangcode();
      $send = true;
    
      $result = $mailManager->mail($module, $key, $to, $langcode, $params, NULL, $send);
      if ($result['result'] != true) {
        $message = t('There was a problem sending your email notification to @email.', array('@email' => $to));
        \Drupal::logger('mail_log')->error($message);
        print ' --Failed email->';
      }
      else {
        // update notification table
        $this->database->update('zsc_email_notification')
        ->fields([
          'notification_status' => 1,
          'changed' => \Drupal::time()->getRequestTime(),
        ])
        ->condition('nid', $nid, '=')
        ->execute();
        $message = t('Sending your email notification to @email.', array('@email' => $to));
        \Drupal::logger('mail_log')->error($message);
        print ' -- Email sent Successfully';
      }
      
    }  
  }
 
}