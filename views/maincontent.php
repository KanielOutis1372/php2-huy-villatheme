<div class="ui equal width grid main-content">
    <div class="row">
        <div class="column">
            <button class="add-product ui primary button">Add product</button>
            <button class="add-property ui button">Add property</button>
            <button class="ui sync button">Sync from VillaTheme</button>
        </div>
        <div class="column">
            <div class="ui icon input">
                <input class="searchInput" type="text" placeholder="Search..." name="key-search" <?php if (!empty($valuesearch)) {
                                                                                                        echo 'value="' . $valuesearch . '"';
                                                                                                    } ?>>
                <i class="inverted circular search link icon"></i>
            </div>
        </div>
    </div>

    <div class="row">
        <form class="ui form filter" enctype="multipart/form-data">
            <div class="width equal field">
                <select class="ui dropdown filter" name="optionFilter">
                    <option value="">Option</option>
                    <?php
                    $optionFilterArr = ['Title', 'Price', 'Createddate'];
                    foreach ($optionFilterArr as $value) {
                        if (!empty($dataFilter['optionFilter']) && $value == $dataFilter['optionFilter']) {
                            echo '<option selected value="' . $value . '">' . $value . '</option>';
                        } else {
                            echo '<option value="' . $value . '">' . $value . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="width equal field">
                <select class="ui dropdown filter" name="ascFilter">
                    <?php
                    $sort = ['ASC', 'DESC'];
                    foreach ($sort as $value) {
                        if (!empty($dataFilter['ascFilter']) && $value == $dataFilter['ascFilter']) {
                            echo '<option selected value="' . $dataFilter['ascFilter'] . '">' . $dataFilter['ascFilter'] . '</option>';
                        } else {
                            echo '<option value="' . $value . '">' . $value . '</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="width equal field">
                <select class="ui dropdown filter" name="cateFilter">
                    <option value="">Category</option>
                    <?php
                    if (!empty($cates)) {
                        foreach ($cates as $cate) {
                            if (!empty($dataFilter['cateFilter']) && $cate->getPropertyId() == $dataFilter['cateFilter']) {
                                echo '<option selected value="' . $cate->getPropertyId() . '">' . $cate->getPropertyName() . '</option>';
                                // break;
                            } else {
                                echo '<option value="' . $cate->getPropertyId() . '">' . $cate->getPropertyName() . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="width equal field">
                <select class="ui dropdown" name="tagFilter">
                    <option value="">Select tag</option>
                    <?php
                    if (!empty($tags)) {
                        foreach ($tags as $tag) {
                            if (!empty($dataFilter['tagFilter']) && $tag->getPropertyId() == $dataFilter['tagFilter']) {
                                echo '<option selected value="' . $tag->getPropertyId() . '">' . $tag->getPropertyName() . '</option>';
                                // break;
                            } else {
                                echo '<option value="' . $tag->getPropertyId() . '">' . $tag->getPropertyName() . '</option>';
                            }
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="width equal field">
                <div class="ui calendar list" id="standard_calendar">
                    <div class="ui fluid input">
                        <input type="date" id="startday" name="startdayFilter" <?php if (isset($dataFilter['startdayFilter'])) {
                                                                                    echo 'value="' . $dataFilter['startdayFilter'] . '"';
                                                                                } ?>>
                    </div>
                </div>
            </div>

            <div class="width equal field">
                <div class="ui calendar list" id="standard_calendar">
                    <div class="ui fluid input">
                        <input type="date" id="enday" name="enddayFilter" <?php if (isset($dataFilter['enddayFilter'])) {
                                                                                    echo 'value="' . $dataFilter['enddayFilter'] . '"';
                                                                                } ?>>
                    </div>
                </div>
            </div>

            <div class="width equal field">
                <div class="ui input list">
                    <input type="number" placeholder="Price from" name="pricefromFilter" <?php if (isset($dataFilter['pricefromFilter'])) {
                                                                                                echo 'value="' . $dataFilter['pricefromFilter'] . '"';
                                                                                            } ?>>
                </div>
            </div>

            <div class="width equal field">
                <div class="ui input list">
                    <input type="number" placeholder="Price to" name="pricetoFilter" <?php if (isset($dataFilter['pricetoFilter'])) {
                                                                                            echo 'value="' . $dataFilter['pricetoFilter'] . '"';
                                                                                        } ?>>
                </div>
            </div>

            <div class="width equal field">
                <button class="ui button">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- table -->
<div class="table-part">
    <table class="ui celled table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Product name</th>
                <th>SKU</th>
                <th>Price</th>
                <th>Feature Image</th>
                <th>Gallery</th>
                <th>Categories</th>
                <th>Tags</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($products)) :
                foreach ($products as $value) : ?>
                    <tr>
                        <td><?php echo $value->getCreatedDate() ?></td>
                        <td><?php echo $value->getTitle() ?></td>
                        <td><?php echo $value->getSku() ?></td>
                        <td><?php
                            if (!empty($value->getPrice())) {
                                echo '&#36;' . $value->getPrice();
                            } else {
                                echo '&#36;0';
                            } ?>
                        </td>
                        <td>
                            <?php 
                                if (!empty($value->getFeaturedImage())) {
                                    echo '<img class="featured-img main"  src="' . './assets/img/' . $value->getFeaturedImage() . '">'; 
                                }
                            ?>
                        </td>
                        <td>
                            <?php
                            if (!empty($value->getGallery())) {
                                $galleryArr = explode(',', $value->getGallery());
                                foreach ($galleryArr as $gallery) {
                                    echo '<img class="gallery-img main"  src="' . './assets/img/' . $gallery . '">';
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo $value->getCategory() ?></td>
                        <td><?php echo $value->getTag() ?></td>
                        <td>
                            <a class="update-link" id="<?php echo $value->getId() ?>"><i class="edit icon"></i></a>
                            <a class="delete-link" id="<?php echo $value->getId() ?>"><i class="trash icon"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php endif ?>
        </tbody>
    </table>
    <!-- pagination -->
    
    <div class="pagination-part">
        <div class="ui pagination menu">
            <?php
            if (!empty($quantityPage)) {
                for ($i = 1; $i <= $quantityPage; $i++) {
                    if (!empty($_currentPage) && $_currentPage == $i) {
                        echo '<a class="page-link item active" data-value="' . $i . '">' . $i . '</a>';
                    } else {
                        echo '<a class="page-link item" data-value="' . $i . '">' . $i . '</a>';
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

<div class="ui modal"></div>
<div class="modal-sync"></div>
