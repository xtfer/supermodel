<?php

/**
 * @file
 * Contains a base model.
 */

namespace SuperModel;

use SuperModel\Exception\ModelException;
use SuperModel\Exception\SupermodelException;
use SuperModel\Operation\UpdateTypes;
use SuperModel\Property\ModelPropertyInterface;
use SuperModel\Property\ModelProperty;

/**
 * Class SuperModel
 *
 * @package SuperModel
 */
abstract class SuperModel implements SuperModelInterface, ModelInterface, FormableInterface {

  /**
   * The item variable.
   *
   * @var array
   */
  public $item;

  /**
   * The data variable.
   *
   * @var array
   */
  protected $data;

  /**
   * The keys variable.
   *
   * @var
   */
  protected $keyTypes;

  /**
   * The keys variable.
   *
   * @var array
   */
  protected $keys;

  /**
   * The primaryKey variable.
   *
   * @var ModelProperty
   */
  protected $primaryKey;

  /**
   * The properties variable.
   *
   * @var ModelPropertyInterface[]
   */
  protected $properties = array();

  /**
   * Constructor.
   *
   * @param array $data
   *   (Optional) Any data to set.
   */
  public function __construct($data = array()) {

    $this->getStructure();

    if (!empty($data)) {
      foreach ($data as $key => $value) {
        $this->setValue($key, $value);
      }
    }
  }

  /**
   * Implements magic __get().
   */
  public function __get($name) {

    return $this->getValue($name);
  }

  /**
   * Implements magic __isset().
   */
  public function __isset($name) {

    if (isset($this->data[$name])) {
      return TRUE;
    }

    return FALSE;
  }

  /**
   * Implements magic __set().
   */
  public function __set($name, $value) {

    $this->setValue($name, $value);
  }

  /**
   * Implements magic __unset().
   */
  public function __unset($name) {

    if (isset($this->data[$name])) {
      unset($name);
    }
  }

  /**
   * Add a new property.
   *
   * @param string $name
   *   Name of the property.
   *
   * @return ModelPropertyInterface
   *   A ModelProperty
   */
  public function addProperty($name) {

    $property = new ModelProperty($name);
    $this->properties[$name] = $property;

    return $this->properties[$name];
  }

  /**
   * Get the value for Data.
   *
   * @return array
   *   The value of Data.
   */
  public function getData() {

    return $this->data;
  }

  /**
   * Get the human readable name.
   *
   * By default, we return the machine name. Override this to return a human
   * readable name.
   *
   * @return string
   *   A Human readable name.
   */
  public function getHumanName() {

    return $this->getModelName();
  }

  /**
   * Get the pluralised model name.
   *
   * @return string
   *   A Pluralised model name.
   */
  public function getHumanNamePlural() {

    return $this->getHumanName() . 's';
  }

  /**
   * {@inheritdoc}
   */
  public function getListItem() {

    $item = array();

    $keys = $this->getListKeys();
    if (!empty($keys) && is_array($keys)) {
      foreach ($keys as $key) {
        $item[$key] = $this->getValue($key);
      }
    }

    return $item;
  }

  /**
   * Get a list of headers.
   *
   * @return mixed
   *   An array of list header keys.
   */
  public function getListKeys() {

    return array(
      'id',
    );
  }

  /**
   * Return the model name for this Model.
   *
   * @return string
   *   The model name. All lowercase, alpha only.
   */
  abstract public function getModelName();

  /**
   * Get the primary identifying value for this item.
   *
   * @return string
   *   The value.
   */
  public function getPrimaryIdentifier() {

    $data = $this->getData();
    if (isset($data[$this->getPrimaryKey()])) {
      return $data[$this->getPrimaryKey()];
    }

    return FALSE;
  }

  /**
   * Define the primary key.
   *
   * @return string
   *   A valid property containing a primary key.
   */
  public function getPrimaryKey() {

    return $this->primaryKey->getName();
  }

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
  public function getProperty($name) {

    if (isset($this->properties[$name])) {
      return $this->properties[$name];
    }

    throw new ModelException(sprintf('Invalid property "%s" called', $name));
  }

  /**
   * Return a property list.
   */
  public function getPropertyNames() {

    return array_keys($this->properties);
  }

  /**
   * Define the structure.
   */
  public function getStructure() {

    $this->addProperty('id')
      ->setLabel('Identifier')
      ->setWidget('textfield')
      ->setRequired(TRUE)
      ->setUpdateStrategy(UpdateTypes::UPDATE_IMMUTABLE);

    $this->setPrimaryKey('id');
  }

  /**
   * Get a data value.
   *
   * @param string $key
   *   The key.
   *
   * @return mixed
   *   The result.
   */
  public function getValue($key) {

    if (isset($this->data[$key])) {
      return $this->data[$key];
    }

    return NULL;
  }

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
  public function setPrimaryKey($property_name) {
    try {
      $this->primaryKey = $this->getProperty($property_name);
    }
    catch (ModelException $e) {
      throw new SupermodelException(sprintf('Attempted to use non-existent property %s
      as a primary key. Do you need to add it?', $property_name));
    }

  }

  /**
   * Set the value for Data.
   *
   * If a method exists called "setValue{KeyName}", then that will be called
   * to set the value. If not, the value is simply set directly.
   *
   * @param string $key
   *   The property to set.
   * @param mixed $data
   *   The value to set.
   *
   * @return SuperModelInterface
   *   This class, for chaining.
   */
  public function setValue($key, $data) {

    if (method_exists($this, 'setValue' . ucfirst($key))) {
      $this->{'setValue' . ucfirst($key)}($data);
    }
    else {
      $this->data[$key] = $data;
    }

    return $this;
  }
}
