<div class="header">

    <h2>
        <?php
        if (!empty($formTitle)) {
            echo $formTitle;
        }
        ?>
    </h2>
    <i class="close icon"></i>
</div>
<hr>
<!-- body modal -->
<div class="content">
    <form class="ui form add-update" enctype="multipart/form-data">
        <div class="field">
            <div class="ui small form">
                <div class="two fields">
                    <div class="field">
                        <label for="skuId">SKU</label>
                        <input type="text" id="skuId" name="sku" placeholder="SKU..." <?php
                                                                                        if (isset($product)) {
                                                                                            if (!empty($product->getSku())) {
                                                                                                echo "value={$product->getSku()}";
                                                                                            }
                                                                                        }
                                                                                        ?>>
                        <?php
                        if (!empty($validateData['skuErr'])) {
                            echo '<div class="ui pointing red basic label">';
                            foreach ($validateData['skuErr'] as $value) {
                                echo  "<li>{$value}</li>";
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <div class="field">
                        <label for="titleId">TITLE</label>
                        <input type="text" id="titleId" name="title" placeholder="title..." <?php
                                                                                            if (isset($product)) {
                                                                                                if (!empty($product->getTitle())) {
                                                                                                    echo 'value="' . $product->getTitle() . '"';
                                                                                                }
                                                                                            }
                                                                                            ?>>
                        <?php
                        if (!empty($validateData['titleErr'])) {
                            echo '<div class="ui pointing red basic label">';
                            foreach ($validateData['titleErr'] as $value) {
                                echo  "<li>{$value}</li>";
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <div class="two fields">
                    <div class="field">
                        <label for="priceId">PRICE</label>
                        <input type="number" id="priceId" name="price" placeholder="price..." <?php
                                                                                                if (isset($product)) {
                                                                                                    if (!empty($product->getPrice())) {
                                                                                                        echo "value={$product->getPrice()}";
                                                                                                    }
                                                                                                }
                                                                                                ?>>
                        <?php
                        if (!empty($validateData['priceErr'])) {
                            echo "<div class='ui pointing red basic label'>
                                            <li>{$validateData['priceErr']}</li>
                                            </div>";
                        }
                        ?>
                    </div>
                    <div class="field">
                        <label for="salepriceId">SALE PRICE</label>
                        <input type="number" id="salepriceId" name="saleprice" placeholder="sale price..." <?php
                                                                                                            if (isset($product)) {
                                                                                                                if (!empty($product->getSalePrice())) {
                                                                                                                    echo "value={$product->getSalePrice()}";
                                                                                                                }
                                                                                                            }
                                                                                                            ?>>
                        <?php
                        if (!empty($validateData['salePriceErr'])) {
                            echo "<div class='ui pointing red basic label'>
                                            <li>{$validateData['salePriceErr']}</li>
                                        </div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="field err-img">
                    <div class="field">
                        <label for="featuredimgId">FEATURED IMAGE</label>
                        <input type="file" id="featuredimgId" name="featuredimg">
                    </div>
                    <?php
                    if (!empty($product)) {
                        if (!empty($product->getFeaturedImage())) {
                            echo '<div class="ui small images list-g f">
                                    <img class="update-img f" src="./assets/img/' . $product->getFeaturedImage() . '">
                                </div>';
                        }
                    }
                    ?>

                    <?php
                    if (!empty($validateData['featuredImgErr'])) {
                        echo "<div class='ui pointing red basic label'>
                                            <li>{$validateData['featuredImgErr']}</li>
                                        </div>";
                    }
                    ?>
                    <div class="ui medium image featured-img"></div>
                </div>

                <div class="field err-img">
                    <div class="field">
                        <label for="gallariesId">GALLARIES</label>
                        <input type="file" id="gallariesId" name="gallary[]" multiple>
                    </div>
                    <?php
                    if (isset($product)) {
                        if (!empty($product->getGallery()[0])) {
                            echo '<div class="ui small images list-g g">';
                            foreach ($product->getGallery() as $gallery) {
                                echo '<img class="update-img g" src="./assets/img/' . $gallery . '">';
                            }
                            echo '</div>';
                        }
                    }
                    ?>
                    <?php
                    if (!empty($validateData['galleryErr'])) {
                        echo '<div class="ui pointing red basic label">';
                        foreach ($validateData['galleryErr'] as $value) {
                            echo "<li>{$value}</li>";
                        }
                        echo '</div>';
                    }
                    ?>
                    <div class="ui medium image box-gallery"></div>
                </div>

                <div class="field">
                    <div class="field">
                        <label>TAGS</label>

                        <select multiple class="ui dropdown tag" name="mySelectTag[]">
                            <option value="">Select Tag</option>
                            <?php
                            if (isset($tags)) {
                                foreach ($tags as $tag) {
                                    if (isset($product)) {
                                        if (!empty($product->getTag())) {
                                            foreach ($product->getTag() as $pTag) {
                                                if ($pTag == $tag->getPropertyId()) {
                                                    echo "<option value='{$tag->getPropertyId()}' selected>{$tag->getPropertyName()}</option>";
                                                    break;
                                                }
                                                if ($pTag == $tag->getPropertyName()) {
                                                    echo "<option value='{$tag->getPropertyId()}' selected>{$tag->getPropertyName()}</option>";
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    echo "<option value='{$tag->getPropertyId()}'>{$tag->getPropertyName()}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="field">
                    <div class="field">
                        <label>CATEGORIES</label>

                        <select multiple class="ui dropdown cate" name="mySelectCate[]">
                            <option value="">Select Category</option>
                            <?php
                            if (isset($cates)) {
                                foreach ($cates as $cate) {
                                    if (isset($product)) {
                                        if (!empty($product->getCategory())) {
                                            foreach ($product->getCategory() as $pCate) {
                                                if ($pCate == $cate->getPropertyId()) {
                                                    echo "<option value='{$cate->getPropertyId()}' selected>{$cate->getPropertyName()}</option>";
                                                    break;
                                                }
                                                if ($pCate == $cate->getPropertyName()) {
                                                    echo "<option value='{$cate->getPropertyId()}' selected>{$cate->getPropertyName()}</option>";
                                                    break;
                                                }
                                            }
                                        }
                                    }
                                    echo "<option value='{$cate->getPropertyId()}'>{$cate->getPropertyName()}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <div class="field">
                        <label for="descId">DESCRIPTION</label>
                        <textarea name="desc" id="descId" cols="30" rows="10"><?php
                                                                                if (isset($product)) {
                                                                                    if (!empty($product->getDescription())) {
                                                                                        echo $product->getDescription();
                                                                                    }
                                                                                }
                                                                                ?></textarea>
                        <?php
                        if (isset($product)) {
                            if (!empty($validateData['descErr'])) {
                                foreach ($validateData['descErr'] as $value) {
                                    echo "<div class='ui pointing red basic label'>
                                                        <li>{$value}</li>
                                                    </div>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                Cancel
            </div>
            <button type="submit" class="ui positive right labeled icon button do-action">
                <?php
                if (!empty($btnAction)) {
                    echo $btnAction;
                } else {
                    echo 'Add';
                }
                ?>
                <i class="checkmark icon"></i>
            </button>
        </div>
    </form>
</div>