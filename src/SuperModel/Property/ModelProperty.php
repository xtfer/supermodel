<?php

/**
 * @file
 * Contains a ModelProperty.
 */

namespace SuperModel\Property;

use SuperModel\Operation\UpdateTypes;
use SuperModel\Operation\OperationTypes;

/**
 * Class ModelProperty
 *
 * @package Vultan\Model
 */
class ModelProperty implements ModelPropertyInterface {

  const DEFAULT_WIDGET = 'text';

  /**
   * An array of callbacks to be used for different options.
   *
   * @var array
   */
  protected $callbacks;

  /**
   * The defaultValue variable.
   *
   * @var mixed
   */
  protected $defaultValue;

  /**
   * The defaultValueCallback variable.
   *
   * @var string
   */
  protected $defaultValueCallback;

  /**
   * The hidden variable.
   *
   * @var bool
   */
  protected $hidden;

  /**
   * The label variable.
   *
   * @var string
   */
  protected $label;

  /**
   * The optionsCallback variable.
   *
   * @var string
   */
  protected $listOptionsCallback;

  /**
   * The name variable.
   *
   * @var string
   */
  protected $name;

  /**
   * An array of options for this property.
   *
   * The possible options will be dependent on the tool used (e.g. Drupal,
   * Symfony etc) and the options that the model supports.
   *
   * @var array
   */
  protected $options;

  /**
   * The type variable.
   *
   * @var string
   */
  protected $propertyType;

  /**
   * The widget variable.
   *
   * @var string
   */
  protected $widgetType;

  /**
   * Constructor.
   *
   * @param string $name
   *   The name of the property.
   */
  public function __construct($name) {
    $this->name = $name;

    $this->setOption('update_strategy', UpdateTypes::UPDATE_MUTABLE);
  }

  /**
   * Lazy factory function.
   *
   * @param string $name
   *   The name of the property.
   *
   * @return ModelProperty
   *   This Property.
   */
  static public function create($name) {

    return new static($name);
  }

  /**
   * Get an option value.
   *
   * @param string $option
   *   The name of the option.
   *
   * @return null|string
   *   Value of the option callback, or NULL
   */
  public function getCallback($option) {

    if (isset($this->options[$option])) {
      return $this->options[$option];
    }

    return NULL;
  }

  /**
   * Get List Options for this property.
   *
   * @return array
   *   An array of options.
   */
  public function getChoices() {

    return $this->getOption('choices', NULL);
  }

  /**
   * Get the value for OptionsCallback.
   *
   * @throws \Exception
   * @return string
   *   The value of OptionsCallback.
   */
  public function getChoicesCallback() {

    return $this->getCallback('choices');
  }

  /**
   * Get the default value.
   *
   * @return mixed|null
   *   The default value or NULL.
   */
  public function getDefault() {

    return $this->getCallback('default_value', '');
  }

  /**
   * Get the default value callback.
   *
   * @return null|string
   *   Callback name, or NULL.
   */
  public function getDefaultCallback() {

    if (isset($this->defaultValueCallback)) {
      return $this->defaultValueCallback;
    }

    return NULL;
  }

  /**
   * Get the description.
   *
   * @return string|null
   *   The description, or nothing.
   */
  public function getDescription() {

    return $this->getOption('description', '');
  }

  /**
   * Get the value for Label.
   *
   * @return string
   *   The value of Label.
   */
  public function getLabel() {

    $label = $this->getOption('label');
    if (!empty($label)) {

      return $label;
    }

    return $this->getName();
  }

  /**
   * Get the value for Length.
   *
   * @return int
   *   The value of Length.
   */
  public function getMaxLength() {

    return $this->getOption('max_length');
  }

  /**
   * Get the value for Name.
   *
   * @throws \Exception
   * @return string
   *   The value of Name.
   */
  public function getName() {

    return $this->name;
  }

  /**
   * Get an option value.
   *
   * @param string $key
   *   The name of the option.
   * @param mixed|null $default
   *   Default value of the option.
   *
   * @return mixed
   *   Value of the option.
   */
  public function getOption($key, $default = NULL) {
    if (isset($this->options[$key])) {
      return $this->options[$key];
    }
    return $default;
  }

  /**
   * Get the value for Type.
   *
   * @return string
   *   The value of Type.
   */
  public function getType() {

    if (isset($this->propertyType)) {
      return $this->propertyType;
    }

    return NULL;
  }

  /**
   * Get the update strategy for this property.
   *
   * @return int
   *   A strategy constant.
   */
  public function getUpdateStrategy() {

    $strategy = $this->getOption('update_strategy');
    if (!empty($strategy)) {

      return $strategy;
    }

    return UpdateTypes::UPDATE_MUTABLE;
  }

  /**
   * Get the value for Widget.
   *
   * @return string
   *   The value of Widget.
   */
  public function getWidget() {

    if (isset($this->widgetType)) {
      return $this->widgetType;
    }

    return self::DEFAULT_WIDGET;
  }

  /**
   * Returns the opposite of isEditable() for convenience.
   *
   * @see ModelProperty::isEditable()
   */
  public function isDisabled($operation = OperationTypes::OP_UPDATE, $ignore_op = FALSE) {

    return !$this->isEditable($operation, $ignore_op);
  }

  /**
   * Get the disabled state.
   *
   * @param int $operation
   *   (optional) The operation being performed on the model. This can be one of
   *   of the following:
   *   - UpdateTypes::OP_READ:  This is treated as a read operation only.
   *   - UpdateTypes::OP_CREATE:  This is an update operation.
   *   - UpdateTypes::OP_UPDATE:  An update operation. Immutable or
   *      on-create properties should be locked.
   *   - UpdateTypes::OP_DELETE:  A delete operation.
   * @param bool $ignore_op
   *   (optional)
   *
   * @return bool
   *   TRUE if the property should be non-editable for the current operation.
   */
  public function isEditable($operation = OperationTypes::OP_UPDATE, $ignore_op = FALSE) {

    // Read operations are, by definition, non-editable.
    if ($operation == OperationTypes::OP_READ) {

      return FALSE;
    }

    // Start by getting the default disabled property.
    $enabled = !$this->getOption('disabled', FALSE);

    // Operations and update strategies are both integers. If the update
    // strategy turns out to be lower than the operation, then that operation
    // is prevented for this change. This can be overridden by passing
    // TRUE for the $ignore_op argument.
    if ($operation >= $this->getUpdateStrategy() && $ignore_op == FALSE) {

      $enabled = FALSE;
    }

    // Return the opposite of the disabled value, since this isEnabled().
    return $enabled;
  }

  /**
   * Determine if this property should be hidden.
   *
   * Hidden properties usually need a default value, but can be set in
   * the beforeSave method.
   *
   * @return bool
   *   TRUE if hidden.
   */
  public function isHidden() {

    if (isset($this->hidden)) {
      return $this->hidden;
    }

    return FALSE;
  }

  /**
   * Get the value for Required.
   *
   * @return bool
   *   The value of Required.
   */
  public function isRequired() {

    if (isset($this->options['required'])) {
      return $this->options['required'];
    }

    return FALSE;
  }

  /**
   * Determine if a property is unique.
   *
   * @return bool
   *   TRUE if the property is unique.
   */
  public function isUnique() {
    if (isset($this->options['unique'])) {
      return $this->options['unique'];
    }

    return FALSE;
  }

  /**
   * Set an option.
   *
   * @param string $option
   *   The name of the option.
   * @param mixed $callback
   *   The value of the option.
   *
   * @return ModelPropertyInterface
   *   This class, for chaining.
   */
  public function setCallback($option, $callback) {

    $this->options[$option] = $callback;

    return $this;
  }

  /**
   * Set the choices available if this is a selectable choice.
   *
   * @param array $options
   *   An array options as key => human_readable value
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setChoices(array $options) {

    return $this->setOption('choices', $options);
  }

  /**
   * Set the value for OptionsCallback.
   *
   * @param string $options_callback
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setChoicesCallback($options_callback) {

    $this->setCallback('choices', $options_callback);
  }

  /**
   * Set the default value.
   *
   * @param mixed $value
   *   A default value
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setDefault($value) {

    $this->defaultValue = $value;

    return $this;
  }

  /**
   * Define a callback for retrieving a default value.
   *
   * @param string $callback
   *   Callback to use.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setDefaultCallback($callback) {

    $this->setCallback('default_value', $callback);
  }

  /**
   * Set the Description.
   *
   * @param string $description
   *   A description.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setDescription($description) {

    return $this->setOption('description', $description);
  }

  /**
   * Set whether the value should be hidden on edit forms.
   *
   * @param bool $value
   *   TRUE if hidden.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setHidden($value = TRUE) {

    $this->hidden = $value;

    return $this;
  }

  /**
   * Set the value for Label.
   *
   * @param string $label
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setLabel($label) {

    return $this->setOption('label', $label);
  }

  /**
   * Set the value for Length.
   *
   * @param int $length
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setMaxLength($length) {

    return $this->setOption('max_length', $length);
  }

  /**
   * Set the value for Name.
   *
   * @param string $name
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setName($name) {

    $this->name = $name;

    return $this;
  }

  /**
   * Set an option.
   *
   * @param string $key
   *   The name of the option.
   * @param mixed $value
   *   The value of the option.
   *
   * @return ModelPropertyInterface
   *   This class, for chaining.
   */
  public function setOption($key, $value) {
    $this->options[$key] = $value;

    return $this;
  }

  /**
   * Set the value for Required.
   *
   * @param bool $required
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setRequired($required) {

    return $this->setOption('required', $required);
  }

  /**
   * Set the value for Type.
   *
   * @param string $type
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setType($type) {

    $this->propertyType = $type;

    return $this;
  }

  /**
   * Set whether this property should be unique.
   *
   * SuperModel cannot enforce uniqueness for a property, but this can be used
   * by objects handling SuperModels. Calling this method without any arguments
   * will flag the property as unique.
   *
   * @param bool $value
   *   (Optional) TRUE if the value is unique. FALSE if not. Defaults to TRUE.
   *
   * @return ModelPropertyInterface
   *   This class, for chaining.
   */
  public function setUnique($value = TRUE) {

    return $this->setOption('unique', $value);
  }

  /**
   * Set the update strategy for an item.
   *
   * @param int $strategy
   *   One of the Update Strategy constants
   *
   * @return ModelPropertyInterface
   *   This class, for chaining.
   */
  public function setUpdateStrategy($strategy = UpdateTypes::UPDATE_MUTABLE) {

    return $this->setOption('update_strategy', $strategy);
  }

  /**
   * Set the value for Widget.
   *
   * @param string $widget
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setWidget($widget) {

    $this->widgetType = $widget;

    return $this;
  }
}
