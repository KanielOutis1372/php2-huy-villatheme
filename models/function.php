<?php

require_once 'ProductModel.php';

// define func
$qrBuilderBase = 'SELECT P.product_id, P.sku, P.title, P.price, P.featured_image, P.description, P.created_date, P.modified_date,
                    GROUP_CONCAT(DISTINCT C.category_name) AS category_name,
                    GROUP_CONCAT(DISTINCT T.tag_name) AS tag_name,
                    GROUP_CONCAT(DISTINCT G.image) AS image 
                    FROM product P
                    LEFT JOIN product_category PC ON P.product_id = PC.product_id
                    LEFT JOIN category C ON PC.category_id = C.category_id
                    LEFT JOIN product_tag PT ON P.product_id = PT.product_id
                    LEFT JOIN tag T ON PT.tag_id = T.tag_id
                    LEFT JOIN gallery G ON P.product_id = G.product_id WHERE 1 = 1';

function optionFilter($dataFilter)
{
    if (!empty($dataFilter)) {
        $filterStr = '';
        $cateFilter = $dataFilter['cateFilter'] ?? NULL;
        $tagFilter = $dataFilter['tagFilter'] ?? NULL;
        $startdayFilter = $dataFilter['startdayFilter'] ?? NULL;
        $enddayFilter = $dataFilter['enddayFilter'] ?? NULL;
        $pricefromFilter = $dataFilter['pricefromFilter'] ?? NULL;
        $pricetoFilter = $dataFilter['pricetoFilter'] ?? NULL;

        $pricefromFilter = intval($pricefromFilter);
        $pricetoFilter = intval($pricetoFilter);

        if (!empty($cateFilter)) {
            $filterStr .= " AND EXISTS (
            SELECT 1 FROM product_category PC2
            INNER JOIN category C2 ON PC2.category_id = C2.category_id
            WHERE PC2.product_id = P.product_id AND C2.category_id = $cateFilter)";
        }
        if (!empty($tagFilter)) {
            $filterStr .= " AND EXISTS (
            SELECT 1 FROM product_tag PT2
            INNER JOIN tag T2 ON PT2.tag_id = T2.tag_id
            WHERE PT2.product_id = P.product_id AND T2.tag_id = $tagFilter)";
        }
        if (!empty($startdayFilter)) {
            $filterStr .= ' AND P.created_date >= "' . $startdayFilter . '"';
        }
        if (!empty($enddayFilter)) {
            $filterStr .= ' AND P.created_date <= "' . $enddayFilter . '"';
        }
        if (!empty($pricefromFilter)) {
            $filterStr .= ' AND P.price >= ' . $pricefromFilter;
        }
        if (!empty($pricetoFilter)) {
            $filterStr .= ' AND P.price <= ' . $pricetoFilter;
        }

        $filterStr .= ' GROUP BY P.product_id';
        return $filterStr;
    }
}

function quantityPage($searchProduct, $limit, $dataFilter)
{
    global $qrBuilderBase;
    $qrBuilder = '';
    if (!empty($searchProduct)) {
        $qrBuilder = 'SELECT COUNT(*) AS total FROM (' . $qrBuilderBase . ' GROUP BY P.product_id HAVING P.title LIKE "%' . $searchProduct . '%"' . ') AS Subquery';
    }

    if (!empty($dataFilter)) {
        $qrBuilder = '';
        $qrBuilder = 'SELECT COUNT(*) AS total FROM (' . $qrBuilderBase;
        if (!empty(optionFilter($dataFilter))) {
            $qrBuilder .= optionFilter($dataFilter) . ') AS Subquery';
        }
    }

    $quantityPro = ProductModel::getQuantityProduct($searchProduct, $qrBuilder);
    $quantityPage = 0;
    $limit = $limit ?? 0;
    if ($quantityPro % $limit == 0) {
        $quantityPage = $quantityPro / $limit;
    } else {
        $quantityPage = (int)($quantityPro / $limit) + 1;
    }
    return $quantityPage;
}

function getAllData($keySearch = NULL, $dataFilter = NULL)
{
    global $qrBuilderBase;
    $qrBuilder = $qrBuilderBase . ' GROUP BY P.product_id';
    if (!empty($keySearch)) {
        $qrBuilder .= ' HAVING P.title LIKE "%' . $keySearch . '%"';
    }

    if (!empty($dataFilter)) {
        $qrBuilder = $qrBuilderBase . optionFilter($dataFilter);
    }
    
    $products = ProductModel::getAllProduct($qrBuilder);
    return $products;
}


function getDataInputForm()
{
    $product = new Product();
    $tagSelected = $cateSelected = $gallerySelected = [];

    $sku = $_POST['sku'] ?? NULL;
    $title = $_POST['title'] ?? NULL;
    $price = $_POST['price'] ?? NULL;
    $salePrice = $_POST['saleprice'] ?? NULL;
    $featuredImg = $_FILES['featuredimg']['name'] ?? NULL;
    $desc = $_POST['desc'] ?? NULL;

    $selectedOptionTag = isset($_POST["mySelectTag"]) ? array_unique($_POST["mySelectTag"]) : '';
    if (!empty($selectedOptionTag)) {
        foreach ($selectedOptionTag as $tag) {
            $tagSelected[] = $tag;
        }
    }

    $selectedOptionCate = isset($_POST["mySelectCate"]) ? array_unique($_POST["mySelectCate"]) : '';
    if (!empty($selectedOptionCate)) {
        foreach ($selectedOptionCate as $cate) {
            $cateSelected[] = $cate;
        }
    }

    if (!empty($_FILES['gallary']['name'][0])) {
        $selectedFiles = $_FILES['gallary']['name'];
    } else {
        $selectedFiles = [];
    }
    if (!empty($selectedFiles)) {
        foreach ($selectedFiles as $value) {
            $gallerySelected[] = $value;
        }
    }

    $product->setSku($sku);
    $product->setTitle($title);
    $product->setPrice($price);
    $product->setSalePrice($salePrice);
    $product->setFeaturedImage($featuredImg);
    $product->setDescription($desc);
    $product->setTag($tagSelected);
    $product->setCategory($cateSelected);
    $product->setGallery($gallerySelected);

    return $product;
}

function uploadFile($imgProduct, $imgTmpName)
{
    $target_dir = 'assets/img/';
    $target_file = $target_dir . $imgProduct;
    move_uploaded_file($imgTmpName, $target_file);
}

function add($product) {
    $product->setCreatedDate(date('Y-m-d'));
    $product->setModifiedDate($product->getCreatedDate());
    $errorAdd = ProductModel::addProduct($product);

    if(!empty($errorAdd)) {
        return $errorAdd;
    }
 
    // upload file
    if (!empty($_FILES["featuredimg"]['tmp_name'])) {
        uploadFile($product->getFeaturedImage(), $_FILES["featuredimg"]['tmp_name']);
    }

    $selectedFiles = $product->getGallery();
    foreach ($selectedFiles as $key => $value) {
        ProductModel::addGallery($value);
        if (!empty($_FILES['gallary']['tmp_name'][$key])) {
            uploadFile($value, $_FILES['gallary']['tmp_name'][$key]);
        }
    }

    $selectedOptionTagId = $product->getTag();
    foreach ($selectedOptionTagId as $tagId) {
        ProductModel::updateOrInsertProductTag($tagId);
    }

    $selectedOptionCateId = $product->getCategory();
    foreach ($selectedOptionCateId as $cateId) {
        ProductModel::updateOrInsertProductCategory($cateId);
    }
}

function delete($id)
{
    if (isset($id)) {
        ProductModel::deleteProductTags($id);
        ProductModel::deleteProductCates($id);
        ProductModel::deleteProductGalleries($id);
        ProductModel::deleteProduct($id);
    }
}

function update($product, $id)
{
    if (empty($product->getFeaturedImage())) {
        $product->setFeaturedImage(ProductModel::getProductById($id)->getFeaturedImage());
    } else {
        if (!empty($_FILES['featuredimg']['tmp_name'])) {
            uploadFile($product->getFeaturedImage(), $_FILES['featuredimg']['tmp_name']);
        }
    }

    if (empty($product->getGallery())) {
        $product->setGallery(ProductModel::getProductById($id)->getGallery());
    } else {
        ProductModel::deleteProductGalleries($id);
        foreach ($_FILES['gallary']['name'] as $key => $value) {
            if (!empty($_FILES['gallary']['tmp_name'][$key])) {
                uploadFile($value, $_FILES['gallary']['tmp_name'][$key]);
                ProductModel::addGalleryByProductId($id, $value);
            }
        }
    }

    $product->setCreatedDate(ProductModel::getProductById($id)->getCreatedDate());
    $product->setModifiedDate(date('Y-m-d'));

    $arrTagU = $product->getTag();
    if (!empty($arrTagU)) {
        ProductModel::deleteProductTags($id);
        foreach ($arrTagU as $tag) {
            ProductModel::updateProductTags($id, $tag);
        }
    }

    $arrCateU = $product->getCategory();
    if (!empty($arrCateU)) {
        ProductModel::deleteProductCates($id);
        foreach ($arrCateU as $cate) {
            ProductModel::updateProductCates($id, $cate);
        }
    }

    ProductModel::updateProduct($id, $product);
}

function addproperty($typeProperty, $propertyName)
{
    if (!empty($typeProperty) && !empty($propertyName)) {
        return PropertyModel::addProperty($typeProperty, $propertyName);
    }
}

function validate($product)
{
    $validateData = [];
    $skuErr = $titleErr = $descErr = $galleryErr = [];
    $skuValue = $titleValue = $descValue = '';
    $salePriceErr = $featuredImgErr = $priceErr = '';

    if (empty($product->getSku())) {
        $skuErr['skuErrRequired'] = 'Sku is required!';
    } else {
        $skuValue = trim($product->getSku());
        if (!preg_match("/^[a-zA-Z0-9-]+$/", $skuValue)) {
            $skuErr['skuErrCharacter'] = 'Sku is only allow: letters, digits, sign (-)';
        }
        if (preg_match("/\s/", $skuValue)) {
            $skuErr['skuErrSpace'] = "Sku don't allow space in strings!";
        }
    }

    if (empty($product->getTitle())) {
        $titleErr['titleErrRequired'] = 'Title is required!';
    } else {
        $titleValue = trim($product->getTitle());
        if (preg_match("/\s{2,}/", $titleValue)) {
            $titleErr['titleErrSpace'] = "Title doesn't allow extra spaces in strings!";
        }
    }

    $descValue = trim($product->getDescription());
    if (preg_match("/\s{2,}/", $descValue)) {
        $descErr['descErrSpace'] = "Description is containing a lot of extra spaces in the string!";
    }

    if (!empty($product->getPrice())) {
        if ($product->getPrice() < 0) {
            $priceErr = 'Price must be greater than 0';
        }
    }

    if (!empty($product->getSalePrice())) {
        if ($product->getSalePrice() >= $product->getPrice() && $product->getSalePrice() >= 0) {
            $salePriceErr = 'Sale price must be less than the price!';
        } elseif ($product->getSalePrice() < 0) {
            $salePriceErr = 'Sale price must be greater than 0';
        }
    }

    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

    if (!empty($product->getFeaturedImage())) {
        $filename = $_FILES['featuredimg']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array(strtolower($extension), $allowedExtensions)) {
            $featuredImgErr = 'Invalid image! Only allowed (.jpg, .jpeg, .png, .gif)';
        }
    }

    if (!empty($product->getGallery())) {
        $filename = $_FILES['gallary']['name'];
        foreach ($filename as $value) {
            $extension = pathinfo($value, PATHINFO_EXTENSION);
            if (!in_array(strtolower($extension), $allowedExtensions)) {
                $galleryErr[] = '"' . $value . '"' . ' is invalid imgage! Only allowed (.jpg, .jpeg, .png, .gif)';
            }
        }
    }
    //add all validate err and data of input to array validateData array
    $validateData['skuErr'] = $skuErr;
    $validateData['titleErr'] = $titleErr;
    $validateData['descErr'] = $descErr;
    $validateData['priceErr'] = $priceErr;
    $validateData['salePriceErr'] = $salePriceErr;
    $validateData['featuredImgErr'] = $featuredImgErr;
    $validateData['galleryErr'] = $galleryErr;

    return $validateData;
}

function checkValidate($validateData)
{
    if (
        empty($validateData['skuErr']) &&
        empty($validateData['titleErr']) &&
        empty($validateData['descErr']) &&
        empty($validateData['priceErr']) &&
        empty($validateData['salePriceErr']) &&
        empty($validateData['galleryErr']) &&
        empty($validateData['featuredImgErr'])
    ) {
        return true;
    }
    return false;
}

function resetFolderImg()
{
    $folder_path = './assets/img/'; // Đường dẫn đến thư mục chứa ảnh
    $pattern = '/^[a-zA-Z0-9]+_.*\.(jpg|png|gif|jpeg)$/'; // Biểu thức chính quy

    if ($handle = opendir($folder_path)) {
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                // Kiểm tra xem tên file có khớp với biểu thức chính quy không
                if (preg_match($pattern, $file)) {
                    // Xóa file
                    $full_path = $folder_path . $file;
                    unlink($full_path);
                }
            }
        }
        closedir($handle);
    }
}


//->ok
function loadImgToServer($url)
{
    if (!empty($url)) {
        $destination = './assets/img/' . $url;
        $imgData = file_get_contents($url);
        file_put_contents($destination, $imgData);
    }
}

//quick sort for filter
function quickSort($arr, $option, $direction = 'ASC')
{
    if (count($arr) <= 1) {
        return $arr;
    }

    $pivot = $arr[0];
    $left = $right = array();

    for ($i = 1; $i < count($arr); $i++) {
        if ($option === 'Title') {
            $cmp = strcmp($arr[$i]->getTitle(), $pivot->getTitle());
        } elseif ($option === 'Createddate') {
            $cmp = strtotime($arr[$i]->getCreatedDate()) - strtotime($pivot->getCreatedDate());
        } elseif ($option === 'Price') {
            $cmp = $arr[$i]->getPrice() - $pivot->getPrice();
        } else {
            // Handle other options if needed
            $cmp = 0;
        }

        if ($direction === 'DESC') {
            $cmp = -$cmp; // Đảo ngược kết quả so sánh nếu giảm dần
        }

        if ($cmp < 0) {
            $left[] = $arr[$i];
        } else {
            $right[] = $arr[$i];
        }
    }

    return array_merge(quickSort($left, $option, $direction), array($pivot), quickSort($right, $option, $direction));
}
