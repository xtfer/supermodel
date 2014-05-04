<?php

/**
 * @file
 * Contains a TestSuperModel
 */

namespace SuperModel\Tests;

use SuperModel\SuperModel;

/**
 * Class TestSuperModel
 *
 * @package SuperModel\Tests
 */
class TestSuperModel extends SuperModel {

  /**
   * Return the model name for this Model.
   *
   * @return string
   *   The model name. All lowercase, alpha only.
   */
  public function getModelName() {
    return 'test_supermodel';
  }

}
