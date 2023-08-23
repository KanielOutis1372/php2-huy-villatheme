<?php 
require_once 'Property.php';
    class PropertyModel {
        public static $db;

        public function __construct() {
            self::connectDB();
        }

        private static function connectDB()
        {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "product_mng";
            self::$db = new mysqli($servername, $username, $password, $dbname);
        }

        static function definePro($typeProperty) {
            $aboutProperty = [];
            $property = new Property();
            $tableName = '';
            $typeProperty = $typeProperty ?? NULL;
            switch ($typeProperty) {
                case 'tag':
                    $tableName = 'tag';                
                    break;
                case 'category':
                    $tableName = 'category';
                    break;
                default:
                    break;
            }

            switch ($tableName) {
                case 'tag':
                    $property->setPropertyId('tag_id');
                    $property->setPropertyName('tag_name');
                    break;
                case 'category':
                    $property->setPropertyId('category_id');
                    $property->setPropertyName('category_name');
                    break;
                default:
                    break;
            }
            $aboutProperty['table'] = $tableName;
            $aboutProperty['property']['propertyId'] = $property->getPropertyId();
            $aboutProperty['property']['propertyName'] = $property->getPropertyName();
            return $aboutProperty;
        }

        static function getAllProperty($typeProperty) {
            $list = array();
            $typeProperty = $typeProperty ?? NULL;
            $aboutProperty = PropertyModel::definePro($typeProperty);
            
            self::connectDB();
            $query = 'SELECT * FROM ' . $aboutProperty['table']; 
            $stmt = self::$db->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();
            $list = array();
            while ($row = $result->fetch_assoc()) {
                $property = new Property();
                $property->setPropertyId($row[$aboutProperty['property']['propertyId']]);
                $property->setPropertyName($row[$aboutProperty['property']['propertyName']]);
                array_push($list, $property);
            }
            return $list;
        }

        static function getIdofProperty($typeProperty, $propertyName) {
            try {
                self::connectDB();
                $typeProperty = $typeProperty ?? NULL;
                $aboutProperty = PropertyModel::definePro($typeProperty);
                $query = 'SELECT ' . $aboutProperty['property']['propertyId'] . ' FROM ' . $aboutProperty['table'] . ' WHERE ' . $aboutProperty['property']['propertyName'] . ' = ?';  
                $stmt = self::$db->prepare($query);
                $stmt->bind_param('s', $propertyName);
                $stmt->execute();
                $result = $stmt->get_result();
                return $result->fetch_assoc()[$aboutProperty['property']['propertyId']];
            } catch (\Throwable $e) {
                echo $e->getMessage();
            } 
            
        }

        static function addProperty($typeProperty, $propertyName, $qrBuilder = null) {
            try {
                self::connectDB();
                $typeProperty = $typeProperty ?? NULL;
                $propertyName = $propertyName ?? NULL;
                if(!empty($typeProperty) || !empty($propertyName)) {
                    $aboutProperty = PropertyModel::definePro($typeProperty);
                    $query = "INSERT INTO ";
                    $qrBase = $aboutProperty['table'] . " (" . $aboutProperty['property']['propertyName'] . ") VALUES (?)";
                    $qrExcue = !empty($qrBuilder) ? $qrBuilder . $qrBase : $query . $qrBase;
                    $stmt = self::$db->prepare($qrExcue);
                    $stmt->bind_param('s', $propertyName);
                    $stmt->execute();
                }
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }

        static function syncProperty($table, $propertyArr) {
            if (!empty($propertyArr)) {
                self::connectDB();
                $valueArr = [];
                foreach ($propertyArr as $value) {
                    $valueArr[] = "('{$value}')";
                }
                $qrStr = "INSERT IGNORE INTO {$table} ({$table}_name) VALUES " . implode(',', $valueArr);
                mysqli_query(self::$db, $qrStr);
                mysqli_close(self::$db);
            }
        }
    }
?>