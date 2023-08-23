<div class="header">

    <h2>
        ADD PROPERTY
    </h2>
    <i class="close icon"></i>
</div>
<hr>
<!-- body modal -->
<div class="content">
    <form class="ui form add-update" enctype="multipart/form-data">
        <?php
        if (!empty($errMessageTag)) {
            echo "<h3>* $errMessageTag</h3>";
        }
        if (!empty($errMessageCate)) {
            echo "<h3>* $errMessageCate</h3>";
        }
        if (!empty($errMessageEmpty)) {
            echo "<h3>* $errMessageEmpty</h3>";
        }
        ?>
        <div class="field">
            <div class="field">
                <label for="addNewTag">TAG</label>
                <input type="text" id="addNewTag" name="tag" placeholder="tag..." <?php 
                    if (!empty($tagInput)) {
                        echo 'value="'. $tagInput .'"';
                    }
                ?>>
                <div class="field">
                    <label for="addNewCate">CATEGORY</label>
                    <input type="text" id="addNewCate" name="category" placeholder="category..." <?php 
                        if (!empty($cateInput)) {
                            echo 'value="'. $cateInput .'"';
                        }
                    ?>>
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