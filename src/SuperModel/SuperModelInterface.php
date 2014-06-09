<?php

/**
 * @file
 * Contains a SuperModelInterface
 */

namespace SuperModel;

use SuperModel\Exception\ModelException;
use SuperModel\Exception\SupermodelException;
use SuperModel\Property\ModelPropertyInterface;

/**
 * Interface SuperModelInterface
 *
 * @package SuperModel
 */
interface SuperModelInterface {

  /**
   * Constructor.
   *
   * @param array $data
   *   (Optional) Any data to set.
   */
  public function __construct($data = array());

  /**
   * Add a new property.
   *
   * @param string $name
   *   Name of the property.
   *
   * @return ModelPropertyInterface
   *   A ModelProperty
   */
  public function addProperty($name);

  /**
   * Get the value for Data.
   *
   * @return array
   *   The value of Data.
   */
  public function getData();

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
   * Get a list of headers.
   *
   * @return mixed
   *   An array of list header keys.
   */
  public function getListKeys();

  /**
   * Get keys to be rendered when listing.
   *
   * @return array
   *   An array of keys.
   */
  public function getListItem();

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
   * Define the primary key.
   *
   * @return string
   *   A valid property containing a primary key.
   */
  public function getPrimaryKey();

  /**
   * Get a property.
   *
   * @param string $name
   *   Name of the property.
   *
   * @throws \SuperModel\Exception\ModelException
   * @return \SuperModel\Property\ModelPropertyInterface
   *   A Model Property
   */
  public function getProperty($name);

  /**
   * Return a property list.
   */
  public function getPropertyNames();

  /**
   * Get a data value.
   *
   * @param string $key
   *   The key.
   *
   * @return mixed
   *   The result.
   */
  public function getValue($key);

  /**
   * Set the primary key for this model.
   *
   * This should pass a string containing the name of the Property which is the
   * primary key. This property MUST already exist.
   *
   * @param string $property_name
   *   Name of a valid property name.
   *
   * @throws Exception\SupermodelException
   */
  public function setPrimaryKey($property_name);

  /**
   * Set the value for Data.
   *
   * @param string $key
   *   The property to set.
   * @param mixed $data
   *   The value to set.
   *
   * @return SuperModelInterface
   *   This class, for chaining.
   */
  public function setValue($key, $data);
}
