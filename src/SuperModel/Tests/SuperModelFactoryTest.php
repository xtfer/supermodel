<?php

/**
 * @file
 * Contains a SuperModelFactoryTest.
 */


namespace SuperModel\Tests;

use SuperModel\SuperModelFactory;

/**
 * Class SuperModelFactoryTest
 *
 * @package SuperModel
 */
class SuperModelFactoryTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests the loading functions.
   *
   * @throws \SuperModel\Exception\ModelException
   */
  public function testLoad() {

    $supermodel = SuperModelFactory::load('foo', '\SuperModel\\Tests\\TestSuperModel');

    $this->assertEquals('SuperModel\Tests\TestSuperModel', get_class($supermodel));
  }
}
