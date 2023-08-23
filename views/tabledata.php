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

<div class="ui basic modal"></div>
<div class="modal-sync"></div>