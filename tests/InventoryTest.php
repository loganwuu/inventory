<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/inventory.php";

    $server = 'mysql:host=localhost;dbname=inventory_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class InventoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Inventory::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $description = "Wash the dog";
            $test_inventory = new Inventory($description);

            //Act
            $test_inventory->save();

            //Assert
            $result = Inventory::getAll();
            $this->assertEquals($test_inventory, $result[0]);
        }

        function test_getAll()
        {
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_inventory = new Inventory($description);
            $test_inventory->save();
            $test_inventory2 = new Inventory($description2);
            $test_inventory2->save();

            $result = Inventory::getAll();

            $this->assertEquals([$test_inventory, $test_inventory2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_inventory = new Inventory($description);
            $test_inventory->save();
            $test_inventory2 = new Inventory($description2);
            $test_inventory2->save();

            //Act
            Inventory::deleteAll();

            //Assert
            $result = Inventory::getAll();
            $this->assertEquals([], $result);
        }

        function test_getId()
        {
            $description = "Wash the dog";
            $id = 1;
            $test_inventory = new Inventory($description, $id);

            $result = $test_inventory->getId();

            $this->assertEquals(1, $result);
        }

        function test_find()
        {
            $description = "Wash the dog";
            $description2 = "Water the lawn";
            $test_inventory = new Inventory($description);
            $test_inventory->save();
            $test_inventory2 = new Inventory($description2);
            $test_inventory2->save();

            $id = $test_inventory->getId();
            $result = Inventory::find($id);

            $this->assertEquals($test_inventory, $result);

        }
    }
?>
