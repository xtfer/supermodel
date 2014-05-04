<?php

/**
 * @file
 * Contains a ModelPropertyTest.
 */


namespace SuperModel\Tests;

use SuperModel\Operation\UpdateTypes;
use SuperModel\Operation\OperationTypes;
use SuperModel\Property\ModelProperty;

/**
 * Class ModelPropertyTest
 *
 * @package SuperModel\Property
 */
class ModelPropertyTest extends \PHPUnit_Framework_TestCase {

  /**
   * Test the isEditable functionality.
   */
  public function testIsEditable() {

    $property = new ModelProperty('test');

    // Test a default property.
    $this->assertTrue($property->isEditable(OperationTypes::OP_CREATE));
    $this->assertFalse($property->isEditable(OperationTypes::OP_READ));
    $this->assertTrue($property->isEditable(OperationTypes::OP_UPDATE));
    $this->assertTrue($property->isEditable(OperationTypes::OP_DELETE));

    // Change the property so it can only be set on update.
    $property->setUpdateStrategy(UpdateTypes::UPDATE_CREATE);

    $this->assertTrue($property->isEditable(OperationTypes::OP_CREATE));
    $this->assertFalse($property->isEditable(OperationTypes::OP_READ));
    $this->assertFalse($property->isEditable(OperationTypes::OP_UPDATE));
    $this->assertTrue($property->isEditable(OperationTypes::OP_DELETE));

    // Change the property so it cant be changed at all.
    $property->setUpdateStrategy(UpdateTypes::UPDATE_IMMUTABLE);

    $this->assertFalse($property->isEditable(OperationTypes::OP_CREATE));
    $this->assertFalse($property->isEditable(OperationTypes::OP_READ));
    $this->assertFalse($property->isEditable(OperationTypes::OP_UPDATE));
    $this->assertTrue($property->isEditable(OperationTypes::OP_DELETE));

  }
}
