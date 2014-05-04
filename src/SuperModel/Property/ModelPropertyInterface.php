<?php

/**
 * @file
 * Contains a ModelPropertyInterfaceInterface.
 */

namespace SuperModel\Property;

use SuperModel\Operation\UpdateTypes;
use SuperModel\Operation\OperationTypes;

/**
 * Interface ModelPropertyInterfaceInterface
 *
 * @package SuperModel\Model
 */
interface ModelPropertyInterface {

  /**
   * Get an option value.
   *
   * @param string $option
   *   The name of the option.
   *
   * @return null|string
   *   Value of the option callback, or NULL
   */
  public function getCallback($option);

  /**
   * Get List Options for this property.
   *
   * @return array
   *   An array of options.
   */
  public function getChoices();

  /**
   * Get the value for OptionsCallback.
   *
   * @throws \Exception
   * @return string
   *   The value of OptionsCallback.
   */
  public function getChoicesCallback();

  /**
   * Get the default value.
   *
   * @return mixed|null
   *   The default value or NULL.
   */
  public function getDefault();

  /**
   * Get the default value callback.
   *
   * @return null|string
   *   Callback name, or NULL.
   */
  public function getDefaultCallback();

  /**
   * Get the description.
   *
   * @return string|null
   *   The description, or nothing.
   */
  public function getDescription();

  /**
   * Get the value for Label.
   *
   * @return string
   *   The value of Label.
   */
  public function getLabel();

  /**
   * Get the value for Length.
   *
   * @return int
   *   The value of Length.
   */
  public function getMaxLength();

  /**
   * Get the value for Name.
   *
   * @throws \Exception
   * @return string
   *   The value of Name.
   */
  public function getName();

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
  public function getOption($key, $default = NULL);

  /**
   * Get the value for Type.
   *
   * @return string
   *   The value of Type.
   */
  public function getType();

  /**
   * Get the update strategy for this property.
   *
   * @return int
   *   A strategy constant.
   */
  public function getUpdateStrategy();

  /**
   * Get the value for Widget.
   *
   * @return string
   *   The value of Widget.
   */
  public function getWidget();

  /**
   * Returns the opposite of isEditable() for convenience.
   *
   * @see ModelProperty::isEditable()
   */
  public function isDisabled($operation = OperationTypes::OP_UPDATE, $ignore_op = FALSE);

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
  public function isEditable($operation = OperationTypes::OP_UPDATE, $ignore_op = FALSE);

  /**
   * Determine if this property should be hidden.
   *
   * Hidden properties usually need a default value, but can be set in
   * the beforeSave method.
   *
   * @return bool
   *   TRUE if hidden.
   */
  public function isHidden();

  /**
   * Get the value for Required.
   *
   * @return bool
   *   The value of Required.
   */
  public function isRequired();

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
  public function setCallback($option, $callback);

  /**
   * Set the choices available if this is a selectable choice.
   *
   * @param array $options
   *   An array options as key => human_readable value
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setChoices(array $options);

  /**
   * Set the value for OptionsCallback.
   *
   * @param string $options_callback
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setChoicesCallback($options_callback);

  /**
   * Set the default value.
   *
   * @param mixed $value
   *   A default value
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setDefault($value);

  /**
   * Define a callback for retrieving a default value.
   *
   * @param string $callback
   *   Callback to use.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setDefaultCallback($callback);

  /**
   * Set the Description.
   *
   * @param string $description
   *   A description.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setDescription($description);

  /**
   * Set whether the value should be hidden on edit forms.
   *
   * @param bool $value
   *   TRUE if hidden.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setHidden($value = TRUE);

  /**
   * Set the value for Label.
   *
   * @param string $label
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setLabel($label);

  /**
   * Set the value for Length.
   *
   * @param int $length
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setMaxLength($length);

  /**
   * Set the value for Name.
   *
   * @param string $name
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setName($name);

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
  public function setOption($key, $value);

  /**
   * Set the value for Required.
   *
   * @param bool $required
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setRequired($required);

  /**
   * Set the value for Type.
   *
   * @param string $type
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setType($type);

  /**
   * Set the update strategy for an item.
   *
   * @param int $strategy
   *   One of the Update Strategy constants
   *
   * @return ModelPropertyInterface
   *   This class, for chaining.
   */
  public function setUpdateStrategy($strategy = UpdateTypes::UPDATE_MUTABLE);

  /**
   * Set the value for Widget.
   *
   * @param string $widget
   *   The value to set.
   *
   * @return ModelProperty
   *   This class, for chaining.
   */
  public function setWidget($widget);
}
