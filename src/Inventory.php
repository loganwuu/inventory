<?php
    class Inventory
    {
        private $description;
        private $id;

        function __construct($description, $id = null)
        {
            $this->description = $description;
            $this->id = $id;
        }

        function getId()
        {
            return $this->id;
        }

        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO inventories (description) VALUES ('{$this->getDescription()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_inventories = $GLOBALS['DB']->query("SELECT * FROM inventories;");
            $inventories = array();
            foreach($returned_inventories as $inventory) {
                $description = $inventory['description'];
                $id = $inventory['id'];
                $new_inventory = new Inventory($description, $id);
                array_push($inventories, $new_inventory);
            }
            return $inventories;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM inventories;");
        }

        static function find($search_id)
        {
            $found_inventory = null;
            $inventories = Inventory::getAll();
            foreach($inventories as $inventory) {
                $inventory_id = $inventory->getId();
                if ($inventory_id == $search_id) {
                    $found_inventory = $inventory;
                }
            }
            return $found_inventory;
        }
    }
?>
