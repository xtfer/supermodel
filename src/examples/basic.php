<?php

/**
 * @file
 * Contains a basic SuperModel example
 */

class Car extends \SuperModel\SuperModel {

  /**
   * Return the model name for this Model.
   *
   * @return string
   *   The model name. All lowercase, alpha only.
   */
  public function getModelName() {
    return 'car';
  }

  /**
   * Define the structure of the model.
   */
  public function getStructure() {

    $this->addProperty('id')
      ->setLabel('Identifier')
      ->setWidget('textfield')
      ->setRequired(TRUE)
      ->setUpdateStrategy(\SuperModel\Operation\UpdateTypes::UPDATE_IMMUTABLE);

    $this->addProperty('marque')
      ->setLabel('Marque')
      ->setRequired(TRUE)
      ->setWidget('select')
      ->setChoicesCallback('getMarqueOptionsList');

    $this->addProperty('type')
      ->setLabel('Type')
      ->setRequired(TRUE)
      ->setWidget('select')
      ->setChoicesCallback('getTypeOptionsList');
  }

}

$car = \SuperModel\SuperModelFactory::load('car', 'Car');
$fields = $car->getStructure();

$car['id'] = '1';
$car['marque'] = 'ford';
$car['type'] = 'sedan';

$all_properties = $car->getData();
