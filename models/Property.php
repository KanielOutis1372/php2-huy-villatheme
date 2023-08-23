<?php 
    class Property {
        private $propertyId;
        private $propertyName;
        
        function __construct() {}

        function setPropertyId($propertyId) {
            $this->propertyId = $propertyId;
        }
   
        function getPropertyId() {
            return $this->propertyId;
        }

        function setPropertyName($propertyName) {
            $this->propertyName = $propertyName;
        }

        function getPropertyName() {
            return $this->propertyName;
        }
    }
?>