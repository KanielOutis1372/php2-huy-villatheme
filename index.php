<?php
require_once 'models/function.php';
require_once 'models/sync.php';
require_once 'models/ProductModel.php';
require_once 'models/Product.php';
require_once 'models/PropertyModel.php';

$action = $_GET['action'] ?? '';
$formTitle = $_GET['form-title'] ?? '';
$tags = PropertyModel::getAllProperty('tag');
$cates = PropertyModel::getAllProperty('category');
$tags = $tags ?? NULL;
$cates = $cates ?? NULL;
$limit = 5;
$_currentPage = $_GET['currentPage'] ?? ($_POST['currentPage'] ?? 1);
$_flag = $_GET['flag'] ?? ($_POST['flag'] ?? NULL);
$_productId = $_GET['productId'] ?? ($_POST['productId'] ?? NULL);

switch ($action) {
    case 'sync':
        if(isset($_GET['resetFolderImg']) && $_GET['resetFolderImg']) {
            resetFolderImg();
            $linkArr = getLinkProducts();
            header('Content-Type: application/json');
            echo json_encode($linkArr);
        }
        
        if(isset($_POST['data'])) {
            syncData($_POST['data']);
            if (isset($_GET['reloadTable']) && $_GET['reloadTable']) {
                $productArr = getAllData();
                $quantityPage = quantityPage(NULL, $limit, NULL);
                $products = array_chunk($productArr, $limit)[$_currentPage - 1];
                include_once 'views/tabledata.php';
            }
        }
        break;
    case 'form':
        if (!empty($_flag)) {
            switch ($_flag) {
                case '1':
                    $formTitle = 'ADD PRODUCT';
                    include_once 'views/form.php';
                    break;
                case '2':
                    $formTitle = 'UPDATE PRODUCT';
                    if (!empty($_productId)) {
                        $product = ProductModel::getProductById($_productId);
                        $product->setGallery(explode(',', $product->getGallery()));
                        $product->setTag(explode(',', $product->getTag()));
                        $product->setCategory(explode(',', $product->getCategory()));
                        $btnAction = 'Update';
                        include_once 'views/form.php';
                    }
                    break;
                case '3':
                    include_once 'views/formproperty.php';
                    break;
                default:
                    break;
            }
        }
        break;

    case 'validate':
        if (!empty($_flag)) {
            $product = getDataInputForm();
            switch ($_flag) {
                case '1':
                    $validateData = validate($product);
                    if (checkValidate($validateData)) {
                        $errAdd = add($product);
                        if (!empty($errAdd)) {
                            $validateData['skuErr']['skuDuplicate'] = 'Sku already exists!';
                            $formTitle = 'ADD PRODUCT';
                            ob_start();
                            include_once 'views/form.php';
                            $html = ob_get_clean();
                            $response = array(
                                'html' => $html,
                                'error' => true
                            );
                        } else {
                            ob_start();
                            $productArr = getAllData();
                            $quantityPage = quantityPage(NULL, $limit, NULL);
                            $_currentPage = $quantityPage;
                            $products = array_chunk($productArr, $limit)[$_currentPage - 1];
                            include_once 'views/maincontent.php';
                            $html = ob_get_clean();
                            $response = array(
                                'html' => $html,
                                'error' => false
                            );
                        }
                    } else {
                        $formTitle = 'ADD PRODUCT';
                        ob_start();
                        include_once 'views/form.php';
                        $html = ob_get_clean();
                        $response = array(
                            'html' => $html,
                            'error' => true
                        );
                    }
                    break;

                case '2':
                    $validateData = validate($product);
                    if (checkValidate($validateData)) {
                        if (!empty($_productId)) {
                            update($product, $_productId);
                            ob_start();
                            $productArr = getAllData();
                            $quantityPage = quantityPage(NULL, $limit, NULL);
                            $products = array_chunk($productArr, $limit)[$_currentPage - 1];
                            include_once 'views/maincontent.php';
                            $html = ob_get_clean();

                            $response = array(
                                'html' => $html,
                                'error' => false
                            );
                        }
                    } else {
                        $formTitle = 'UPDATE PRODUCT';
                        ob_start();
                        $btnAction = 'Update';
                        include_once 'views/form.php';
                        $html = ob_get_clean();

                        $response = array(
                            'html' => $html,
                            'error' => true
                        );
                    }
                    break;
                case '3':
                    $response = [];
                    if (!empty($_POST['tag'])) {
                        addproperty('tag', $_POST['tag'], NULL);
                    }

                    if (!empty($_POST['category'])) {
                        addproperty('category', $_POST['category'], NULL);
                    }

                    $tagInput = $_POST['tag'];
                    $cateInput = $_POST['category'];
                    if (empty($tagInput) && empty($cateInput)) {
                        $errMessageEmpty = 'Nothing entered!';
                        $response['errMessageEmpty'] = $errMessageEmpty;
                    }

                    ob_start();
                    include_once 'views/formproperty.php';
                    $html = ob_get_clean();
                    $response['html'] = $html;

                    if(!isset($errMessageEmpty)) {
                        $response['errProperty'] = false;
                    }
                    break;

                default:
                    break;
            }

            header('Content-Type: application/json');
            echo json_encode($response);
        }
        break;
    case 'delete':
        if (!empty($_productId)) {
            ProductModel::deleteProduct($_productId);
            $productArr = getAllData();
            $quantityPage = quantityPage(NULL, $limit, NULL);
            if ($_currentPage > $quantityPage) {
                $_currentPage -= 1;
            }
            $products = array_chunk($productArr, $limit)[$_currentPage - 1];
            include_once 'views/tabledata.php';
        }
        break;
    case 'paginate':
        $keySearch = $_GET['keySearch'] ?? NULL;
        $dataFilter = $_POST ?? NULL;
        if (!empty($keySearch)) {
            $productArr = getAllData($keySearch);
            $quantityPage = quantityPage($keySearch, $limit, NULL);
        } else if (!empty($dataFilter)) {
            $productArr = getAllData(NULL, $dataFilter);
            $quantityPage = quantityPage(NULL, $limit, $dataFilter);
            if (!empty($dataFilter['optionFilter']) && !empty($dataFilter['ascFilter'])) {
                $productArr = quickSort($productArr, $dataFilter['optionFilter'], $dataFilter['ascFilter']);
            }
        } else {
            $productArr = getAllData();
            $quantityPage = quantityPage(NULL, $limit, NULL);
        }
        if (!empty($_currentPage)) {
            if ($quantityPage > 0) {
                $products = array_chunk($productArr, $limit)[$_currentPage - 1];
                include_once 'views/tabledata.php';
            } else {
                echo '<h1>No data!</h1>';
            }
        }
        break;
    case 'get-main-content':
        if (!empty($_currentPage)) {
            $productArr = getAllData();
            if (!empty($productArr)) {
                // print_r($productArr);
                $quantityPage = quantityPage(NULL, $limit, NULL);
                $products = array_chunk($productArr, $limit)[$_currentPage - 1];
                include_once 'views/maincontent.php';
            } else {
                include_once 'views/maincontent.php';
                echo '<h1>No data!</h1>';
            }
        }
        break;
    default:
        require_once 'views/list.php';
        break;
}