<?php

namespace Drupal\zscaler_custom\Event;

use Drupal\Component\EventDispatcher\Event;
use Drupal\Core\Entity\EntityInterface;

/**
 * Event that is fired when a user logs in.
 */
class ZscalerEvent extends Event {

  const INSERT = 'zscaler_custom_entity_insert';
  const UPDATE = 'zscaler_custom_entity_update';
  const DELETE = 'zscaler_custom_entity_delete';

  public $entity;

  /**
   * Constructs the object.
   *
   * @param Drupal\Core\Entity\EntityInterface; $entity
   *   The account of the user logged in.
   */
  public function __construct(EntityInterface $entity) {
    $this->entity = $entity;
  }

}