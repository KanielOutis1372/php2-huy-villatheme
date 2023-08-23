<?php 
    require_once 'PropertyModel.php';
    require_once 'ProductModel.php';
    require_once 'Product.php';
    require_once 'function.php';

    $categoryList = $tagList = $productList = [];
    $temp = 0;

    function getLinkProducts() {
        $url = 'https://villatheme.com/extensions/';
        $html = file_get_contents($url);
        $regex = '/<h2 class="woocommerce-loop-product__title"><a href="(.+?)">(?:.+?)<\/a><\/h2>/is';
        preg_match_all($regex, $html, $linkPros);
        if(!empty($linkPros)) {
            return $linkPros[1];
        }
    }

    function getAllDetailProducts($link) {

        if(!empty($link)) {
            global $categoryList, $tagList, $productList, $temp;
            $regex_sku = '/<span class="sku_wrapper">.*?<span .*?>([a-z -_]+?)<\/span><\/span>/ius';
            $regex_title = '/<h1 class="product_title entry-title">(.+?)<\/h1>/is';
            $regex_price = '/<div.*?>.*?(<p.*?class="price">.*?<\/p>).*?<\/div>/ius';
            $sub_regex_price = '/<bdi>.*?<\/span>([0-9.]+)<\/bdi>/ius';
            $regex_featured_img = '/<div.*?class="woocommerce-product-gallery__image.*?".*?><a.*?href="(.+?)".*?<\/div>/ius'; // Tạo biểu thức chính quy để lấy các thẻ img với class="wp-post-image" và liên kết bên trong chúng
            $regex_gallery = '/<div.*?class="woocommerce-product-gallery__wrapper".*?>(.+)<\/div>/ius';
            $sub_regex_gallery = '/<div.*?data-thumb.*?>.*?<a.*?href="(.+?)".*?>.*?<\/div>/ius';
            $regex_category = '/<span class="posted_in">Category.*?>(\w+).*?<\/span>/is';
            $regex_tag = '/<div class="product_meta">.*?<span class="tagged_as">Tags.*?(<a.*?>[a-z _-]+<\/a>.*?).?<\/div>/ius';
            $regex_description = '/<div.*?id="tab-description".*?>(.+?)<\/div>/ius';
    
            $html = file_get_contents($link);
    
            $gallery_Arr = $tag_Arr = [];
    
            if(!empty(preg_match($regex_sku, $html, $sku))) {
                // echo '<strong>SKU:</strong> ' . $sku[1] . '</br>';
                // $product->setSku($sku[1]);
                $productList[$temp]['sku'] = $sku[1];
            }
            else {
                $productList[$temp]['sku'] = '';
            }
    
            if(!empty(preg_match($regex_title, $html, $title))) {
                // echo '<strong>Name:</strong> ' . $title[1] . '</br>';
                // $product->setTitle($title[1]);
                $productList[$temp]['title'] = $title[1];
            }
            else {
                $productList[$temp]['title'] = '';
            }
    
            if(!empty(preg_match($regex_price, $html, $containPrice))) {
                if(!empty($containPrice[1])) {
                    preg_match_all($sub_regex_price, $containPrice[1], $priceArr);
                    if(!empty($priceArr[1])) {
                        // echo '<strong>Price:</strong> ' . $priceArr[1][0] . '</br>';
                        // $product->setPrice($priceArr[1][0]);
                        $productList[$temp]['price'] = $priceArr[1][0];
                        if(!empty($priceArr[1][1])) {
                            // echo '<strong>Sale Price:</strong> ' . $priceArr[1][1] . '</br>';
                            // $product->setSalePrice($priceArr[1][1]);
                            $productList[$temp]['sale_price'] = $priceArr[1][1];
                        }
                        else {
                            $productList[$temp]['sale_price'] = '';
                        }
                    }
                    else {
                        $productList[$temp]['price'] = '';
                        $productList[$temp]['sale_price'] = '';
                    }
                }
            }
            
    
            if(!empty(preg_match($regex_gallery, $html, $containGallery))) {
                if(!empty($containGallery[1])) {
                    preg_match_all($sub_regex_gallery, $containGallery[1], $galleryArr);
                    if(!empty($galleryArr[1])) {
                        // echo '<strong>Featured Img:</strong> ' . $galleryArr[1][0] . '</br>';
                        // $product->setFeaturedImage($galleryArr[1][0]);
                        foreach($galleryArr[1] as $value) {
                            // echo '<strong>Gallery Item:</strong> ' . $value . '</br>';
                            $url = uniqid() . '_' . basename($value);
                            $destination = './assets/img/' . $url;
                            $imgData = file_get_contents($value);
                            file_put_contents($destination, $imgData);
                            $gallery_Arr[] = $url;
                        }
                        // $product->setGallery($gallery_Arr);
                        $productList[$temp]['featured_image'] = $gallery_Arr[0];
                        $productList[$temp]['gallery'] = $gallery_Arr;
                    }
                }
            }
            else {
                $productList[$temp]['featured_image'] = '';
                $productList[$temp]['gallery'] = '';
            }
    
            if (!empty(preg_match($regex_category, $html, $cateArr))) {
                // echo '<strong>Category:</strong> ' . $cateArr[1] . '</br>';
                // $product->setCategory($cateArr[1]);
                $categoryList[] = $cateArr[1];
                $productList[$temp]['category'] = $cateArr[1];
            }
            else {
                $productList[$temp]['category'] = '';
            }
    
            if(!empty(preg_match($regex_tag, $html, $tagArr))) {
                // echo '<strong>Tags:</strong> ' . strip_tags($tagArr[1]) . '</br>';
                $tag_Arr = explode(', ', strip_tags($tagArr[1]));
                // $product->setTag($tag_Arr);
                $productList[$temp]['tag'] = $tag_Arr;
                foreach ($tag_Arr as $value) {
                    $tagList[] = $value;
                }
                // print_r(strip_tags($tagArr[1]));
            }
            else {
                $productList[$temp]['tag'] = '';
            }
    
            if(!empty(preg_match($regex_description, $html, $desc))) {
                $encodeDesc = htmlentities($desc[1]);
                // $decodeDesc = html_entity_decode($encodeDesc);
                // echo '<strong>Short Desc:</strong> ' . 'Hiden!' . '</br>';
                // $product->setDescription('Hiden!');
                $productList[$temp]['description'] = 'Hiden!';
            }
            else {
                $productList[$temp]['description'] = '';
            }
        }
    }

    function syncData($linkArr) {
        global $temp, $tagList, $categoryList, $productList;
        for ($i=0; $i < count($linkArr); $i++) { 
           getAllDetailProducts($linkArr[$i]);
           $temp++;
        }
        PropertyModel::syncProperty('tag', $tagList); 
        PropertyModel::syncProperty('category', $categoryList);
        ProductModel::syncProduct($productList);
    }

    // // print_r(getLinkProducts());
    // $linkArr = getLinkProducts();
    // for ($i=0; $i < 10; $i++) { 
    //     getAllDetailProducts($linkArr[$i]);
    //     $temp++;
    // }
    // print_r($productList);

    // foreach ($productList as $key => $value) {
    //     print_r($value->getTag());
    // }
    // print_r($tagList);
    // print_r($categoryList);
    // print_r($productList);
    // PropertyModel::syncProperty2('tag', $tagList); //ok
    // PropertyModel::syncProperty2('category', $categoryList); //ok
    // ProductModel::syncProduct2($productList); //ok
?>
      

