<?php

/**
 * @file
 * Contains a ModelInterface
 */

namespace SuperModel;

/**
 * Interface ModelInterface
 *
 * This is the standard interface most models should implements to get a roughly
 * complete implementation. All of these methods are already implemented on the
 * abstract SuperModel class, so they may not all need to be overridden.
 *
 * @package SuperModel
 */
interface ModelInterface {

  /**
   * Get the human readable name.
   *
   * By default, we return the machine name. Override this to return a human
   * readable name.
   *
   * @return string
   *   A Human readable name.
   */
  public function getHumanName();

  /**
   * Get the pluralised model name.
   *
   * @return string
   *   A Pluralised model name.
   */
  public function getHumanNamePlural();

  /**
   * Return the model name for this Model.
   *
   * @return string
   *   The model name. All lowercase, alpha only.
   */
  public function getModelName();

  /**
   * Get the primary identifying value for this item.
   *
   * @return string
   *   The value.
   */
  public function getPrimaryIdentifier();

  /**
   * Define the structure.
   *
   * This is usually done using the addProperty() method, which returns a
   * ModelProperty object, which can be further manipulated. See the base
   * SuperModel class for an example.
   */
  public function getStructure();
}
