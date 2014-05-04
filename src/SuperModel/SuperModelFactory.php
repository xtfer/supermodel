<?php

/**
 * @file
 * Contains a SuperModelFactory
 */

namespace SuperModel;

use SuperModel\Exception\ModelException;

/**
 * Class SuperModelFactory
 *
 * @package Plumbing\Models
 */
class SuperModelFactory {

  /**
   * Public constructor.
   */
  public function __construct() {

    return $this;
  }

  /**
   * Load a new model.
   *
   * @param string $model_name
   *   The model name to load.
   * @param string $class
   *   (Optional) The model class. This is required if there is no method of
   *   loading model information provided by getModelTypes().
   *
   * @throws Exception\ModelException
   *
   * @see SupermodelFactory::getModelTypes()
   *
   * @return SuperModelInterface
   *   A model.
   */
  static public function load($model_name, $class = NULL) {

    $factory = new static();
    /* @var SuperModelFactory $factory */

    if (!is_null($class)) {

      return $factory->createModel($model_name, $class);
    }

    $map = $factory->getModelTypes();
    if (!empty($map)) {
      if (array_key_exists($model_name, $map)) {

        return $factory->createModel($model_name, $map[$model_name]);
      }
    }

    throw new ModelException(sprintf('Invalid model name "%s"', $model_name));
  }

  /**
   * Load a new model.
   *
   * @param string $model_name
   *   The model name to load.
   * @param string $class
   *   The model class. This is required if there is no method of
   *   loading model information provided by getModelTypes().
   *
   * @throws Exception\ModelException
   *
   * @see SupermodelFactory::getModelTypes()
   *
   * @return SuperModelInterface
   *   A model.
   */
  public function createModel($model_name, $class) {

    if (class_exists($class)) {

      return new $class($model_name);
    }

    throw new ModelException(sprintf('Invalid Model class "%s" provided for model "%s"', $class, $model_name));
  }

  /**
   * Return an array of model names and classes.
   *
   * This does nothing by default, but can be overridden.
   *
   * @return array
   *   An array of model classes, keyed by model name.
   */
  public function getModelTypes() {

    return array();
  }
}
