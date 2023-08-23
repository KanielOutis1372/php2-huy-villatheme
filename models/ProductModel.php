<?php
require_once 'Product.php';
require_once 'function.php';
class ProductModel
{
    public static $db;

    public function __construct()
    {
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

    static function getQuantityProduct($searchProduct, $qrBuilder)
    {
        $quantityPro = 0;
        $query = '';
        self::connectDB();
        if (!empty($searchProduct)) {
            $query = $qrBuilder;
        }
        if (!empty($qrBuilder)) {
            $query = $qrBuilder;
        } else {
            $query = "SELECT COUNT(*) AS total FROM product";
        }
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return $quantityPro = $stmt->get_result()->fetch_assoc()['total'];
    }


    //-> ok
    static function getAllProduct($qrBuilder)
    {
        self::connectDB();
        $qrBuilder = $qrBuilder ?? '';
        if (!empty($qrBuilder)) {
            $stmt = self::$db->prepare($qrBuilder);
            $stmt->execute();
            $result = $stmt->get_result();
            $list = array();
            while ($row = $result->fetch_assoc()) {
                $product = new Product();
                $product->setId($row['product_id']);
                $product->setSku($row['sku']);
                $product->setTitle($row['title']);
                $product->setPrice($row['price']);
                $product->setFeaturedImage($row['featured_image']);
                $product->setDescription($row['description']);
                $product->setCreatedDate($row['created_date']);
                $product->setModifiedDate($row['modified_date']);
                $product->setCategory($row['category_name']);
                $product->setTag($row['tag_name']);
                $product->setGallery($row['image']);
                array_push($list, $product);
            }
            return $list;
        }
    }

    //->ok
    //add product
    static function getLastProductId()
    {
        self::connectDB();
        $query = 'SELECT MAX(product_id) AS ID FROM product';
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = new Product();
        $product->setId($result->fetch_assoc()['ID']);
        return $product->getId();
    }

    //->ok
    static function addProduct($product)
    {
        try {
            self::connectDB();
            $query = 'INSERT INTO product (sku, title, price, sale_price, featured_image, description, created_date, modified_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
            $sku = $product->getSku();
            $title = $product->getTitle();
            $price = $product->getPrice();
            $salePrice = $product->getSalePrice();
            $featuredImage = $product->getFeaturedImage();
            $description = $product->getDescription();
            $createdDate = $product->getCreatedDate();
            $modifiedDate = $product->getModifiedDate();
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('ssiissss', $sku, $title, $price, $salePrice, $featuredImage, $description, $createdDate, $modifiedDate);
            $stmt->execute();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    //sync product
    static function syncProduct($productList)
    {
        if (!empty($productList)) {
            self::connectDB();
            $values = [];
            $createdDate = $modifiedDate = date('Y-m-d');

            foreach ($productList as $value) {
                $title = $value['title'];
                if (empty($value['sku'])) {
                    $sku = $title;
                    $sku = strtolower($sku);
                    $sku = str_replace(' ', '-', $sku);
                    $sku = str_replace('&#8211;', '-', $sku);
                    $sku = str_replace('---', '-', $sku);
                }
                else {
                    $sku = $value['sku'];
                }
                $price = $value['price'];
                $sale_price = $value['sale_price'];
                $featured_image = $value['featured_image'];
                $description = $value['description'];
                $galleryArr[] = $value['gallery'];
                $values[] = "('{$sku}', '{$title}', '{$price}', '{$sale_price}', '{$featured_image}', '{$description}', '{$createdDate}', '{$modifiedDate}')";
            }

            $qrStr = "INSERT INTO product (sku, title, price, sale_price, featured_image, description, created_date, modified_date)
                        VALUES " . implode(',', $values) . "
                        ON DUPLICATE KEY UPDATE
                        title = VALUES(title),
                        price = VALUES(price),
                        sale_price = VALUES(sale_price),
                        featured_image = VALUES(featured_image),
                        description = VALUES(description)";
            // echo $qrStr;
            mysqli_query(self::$db, $qrStr);

            $valueG = $valueT = $valueC = [];
            foreach ($productList as $value) {
                $selectProductId = "SELECT product_id FROM product WHERE title = '{$value['title']}'";
                $result = mysqli_query(self::$db, $selectProductId);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $productId = $row['product_id'];
                }

                //delete gallery of old product
                $qrDeleteGallery = "DELETE FROM gallery WHERE product_id = $productId";
                mysqli_query(self::$db, $qrDeleteGallery);
                foreach ($value['gallery'] as $item) {
                    //upload file to server and add to sql string
                    $valueG[] = "('$productId', '$item')";
                    
                }

                //sync category product
                $qrDeleteCateProduct = "DELETE FROM product_category WHERE product_id = $productId";
                mysqli_query(self::$db, $qrDeleteCateProduct);
                $selectCateId = "SELECT category_id FROM category WHERE category_name = '{$value['category']}'";
                mysqli_query(self::$db, $qrDeleteGallery);
                $result = mysqli_query(self::$db, $selectCateId);
                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $cateId = $row['category_id'];
                }
                $valueC[] = "('$productId', '$cateId')";

                //sync category product
                $qrDeleteTagProduct = "DELETE FROM product_tag WHERE product_id = $productId";
                mysqli_query(self::$db, $qrDeleteTagProduct);
                foreach ($value['tag'] as $item) {
                    $selectTagId = "SELECT tag_id FROM tag WHERE tag_name = '$item'";
                    $result = mysqli_query(self::$db, $selectTagId);
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        $tagId = $row['tag_id'];
                    }
                    $valueT[] = "('$productId', '$tagId')";
                }
            }

            $insertGallery = "INSERT INTO gallery (product_id, image) VALUES " . implode(',', $valueG);
            $insertCategory = "INSERT INTO product_category (product_id, category_id) VALUES " . implode(',', $valueC);
            $insertTag = "INSERT INTO product_tag (product_id, tag_id) VALUES " . implode(',', $valueT);
            // echo $insertGallery;
            // echo $insertCategory;
            // echo $insertTag;
            mysqli_query(self::$db, $insertGallery);
            mysqli_query(self::$db, $insertCategory);
            mysqli_query(self::$db, $insertTag);
        }
    }

    //->ok
    static function updateOrInsertProductTag($tagId, $idProduct = null)
    {
        self::connectDB();
        if ($idProduct == null) {
            $idProduct = ProductModel::getLastProductId();
        } else {
            $idProduct = $idProduct;
        }

        if (!empty($idProduct) && !empty($tagId)) {
            $query = 'INSERT INTO product_tag (product_id, tag_id) VALUES (?, ?)';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('ii', $idProduct, $tagId);
            $stmt->execute();
        }
    }

    //->ok
    static function updateOrInsertProductCategory($categoryId, $idProduct = null)
    {
        self::connectDB();
        if ($idProduct == null) {
            $idProduct = ProductModel::getLastProductId();
        } else {
            $idProduct = $idProduct;
        }
        if (!empty($categoryId) && !empty($idProduct)) {
            $query = 'INSERT INTO product_category (product_id, category_id) VALUES (?, ?)';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('ii', $idProduct, $categoryId);
            $stmt->execute();
        }
    }

    //->ok
    static function addGallery($imgName)
    {
        self::connectDB();
        $lastProductId = ProductModel::getLastProductId();
        if (!empty($lastProductId)) {
            $query = 'INSERT INTO gallery (product_id, image) VALUES (?, ?)';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('is', $lastProductId, $imgName);
            $stmt->execute();
        }
    }


    //->ok
    static function addGalleryByProductId($id, $imgGalName)
    {
        self::connectDB();
        $query = 'INSERT INTO gallery (product_id, image) VALUES (?, ?)';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('is', $id, $imgGalName);
        $stmt->execute();
    }


    //delete product   
    //->ok
    static function deleteProduct($productId)
    {
        if (!empty($productId)) {
            self::connectDB();
            $query = 'DELETE FROM product WHERE product_id = ?';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('i', $productId);
            $stmt->execute();
        }
    }

    //->ok
    static function deleteProductTags($productId)
    {
        if (!empty($productId)) {
            self::connectDB();
            $query = 'DELETE FROM product_tag WHERE product_id = ?';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('i', $productId);
            $stmt->execute();
        }
    }

    //->ok
    static function deleteProductCates($productId)
    {
        if (!empty($productId)) {
            self::connectDB();
            $query = 'DELETE FROM product_category WHERE product_id = ?';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('i', $productId);
            $stmt->execute();
        }
    }

    //->ok
    static function deleteProductGalleries($productId)
    {
        if (!empty($productId)) {
            self::connectDB();
            $query = 'DELETE FROM gallery WHERE product_id = ?';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('i', $productId);
            $stmt->execute();
        }
    }

    //update product
    //->ok
    static function getProductById($productId)
    {
        self::connectDB();
        $query = 'SELECT P.product_id, P.sku, P.title, P.price, P.sale_price, P.featured_image, P.description, P.created_date, P.modified_date,
                    GROUP_CONCAT(DISTINCT C.category_name) AS Categories,
                    GROUP_CONCAT(DISTINCT T.tag_name) AS Tags,
                    GROUP_CONCAT(DISTINCT G.image) AS ImageURLs
                    FROM product P
                    LEFT JOIN product_category PC ON P.product_id = PC.product_id
                    LEFT JOIN category C ON PC.category_id = C.category_id
                    LEFT JOIN product_tag PT ON P.product_id = PT.product_id
                    LEFT JOIN tag T ON PT.tag_id = T.tag_id
                    LEFT JOIN gallery G ON P.product_id = G.product_id
                    WHERE P.product_id = ?
                    GROUP BY P.product_id';
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = new Product();
        while ($row = $result->fetch_assoc()) {
            $product->setId($row['product_id']);
            $product->setTitle($row['title']);
            $product->setSku($row['sku']);
            $product->setPrice($row['price'] ?? NULL);
            $product->setSalePrice($row['sale_price'] ?? NULL);
            $product->setFeaturedImage($row['featured_image'] ?? NULL);
            $product->setDescription($row['description'] ?? NULL);
            $product->setTag($row['Tags'] ?? NULL);
            $product->setCategory($row['Categories'] ?? NULL);
            $product->setGallery($row['ImageURLs'] ?? NULL);
        }
        return $product;
    }

    //->ok
    static function updateProduct($id, $product)
    {
        if (!empty($id) && !empty($product)) {
            self::connectDB();
            $id = $id;
            $title = $product->getTitle();
            $sku = $product->getSku();
            $price = $product->getPrice();
            $salePrice = $product->getSalePrice();
            $featuredImage = $product->getFeaturedImage();
            $description = $product->getDescription();
            $modifiedDate = $product->getModifiedDate();
            $query = 'UPDATE product SET title =?, sku =?, price =?, sale_price =?, featured_image =?, description =?, modified_date = ? WHERE product_id = ?';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('ssiisssi', $title, $sku, $price, $salePrice, $featuredImage, $description, $modifiedDate, $id);
            $stmt->execute();
        }
    }

    //->ok
    static function updateProductTags($productId, $tagId)
    {
        if (!empty($productId) && !empty($tagId)) {
            self::connectDB();
            $query = 'INSERT INTO product_tag (product_id, tag_id) VALUES (?, ?)';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('ii', $productId, $tagId);
            $stmt->execute();
        }
    }

    //->ok
    static function updateProductCates($productId, $cateId)
    {
        if (!empty($productId) && !empty($cateId)) {
            self::connectDB();
            $query = 'INSERT INTO product_category (product_id, category_id) VALUES (?, ?)';
            $stmt = self::$db->prepare($query);
            $stmt->bind_param('ii', $productId, $cateId);
            $stmt->execute();
        }
    }
}
