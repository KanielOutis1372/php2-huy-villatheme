var productId, currentPage, keySearch, dataFilter;
var linkArr = [];
var formAddProduct, formAddProperty, mainContent;

export function init() {
    $.ajax({
        type: "GET",
        url: "./index.php?action=get-main-content",
        dataType: "html",
        success: function (response) {
            $('.myapp').html(response);
            $('.ui.dropdown').dropdown();
            mainContent = response;
        }
    });
}

//sync
export async function sync() {

    //handle sync
    disableAll();
    try {
        let resetFolderImg = true;
        if (resetFolderImg) {
            await $.ajax({
                type: "GET",
                url: "./index.php?action=sync&resetFolderImg="+resetFolderImg,
                dataType: "json",
                success: function (response) {
                    linkArr = response;
                }
            });
        }
        
        let chunkSize = linkArr.length / 5;
        let chunkedArray = arrayChunk(linkArr, chunkSize);
        let reloadTable = true;
        let url = "./index.php?action=sync";
        for (let i = 0; i < chunkedArray.length; i++) {
            if (i == chunkedArray.length - 1) {
                url += "&reloadTable=" + reloadTable;
            }
            await $.ajax({
                type: "POST",
                data: {data: chunkedArray[i]},
                url: url,
                dataType: "html",
                success : function (response) {
                    $('.table-part').html(response);
                }
            });
        }

        enableAll();
    } catch (error) {
        enableAll();
    }
    return Promise.resolve(false);
}

function arrayChunk(array, chunkSize) {
    const chunks = [];
    for (let i = 0; i < array.length; i += chunkSize) {
        chunks.push(array.slice(i, i + chunkSize));
    }
    return chunks;
}

function disableAll() {
    $('.modal-sync').addClass('load-sync').append(`
        <div class="ui segment">
            <div class="ui active inverted dimmer">
            <div class="ui medium text loader">Syncing</div>
            </div>
        </div>
    `);
}

function enableAll() {
    $('.modal-sync').removeClass('load-sync').empty();
}

//add product
export function addProduct() {
    if(formAddProduct != null) {
        $('.myapp').html(formAddProduct);
        $('.ui.dropdown').dropdown();
        previewImg();
    }
    else {
        const url = "./index.php?action=form&flag=1";
        callFormProduct(url, 1);
    }
}


//update product
export function updateProduct() {
    productId = $(this).attr('id');
    currentPage = $('.page-link.active').data('value');
    const url = "./index.php?action=form&flag=2&productId=" + productId;
    callFormProduct(url, 2);
}

//delete product
export function handleDelete() {
    productId = $(this).attr('id');
    currentPage = $('.page-link.active').data('value');
    const url = "./index.php?action=delete&productId=" + productId + '&currentPage=' + currentPage;
    const confirmed = confirm('Are you sure delete this product?');
    if (confirmed) {
        $.ajax({
            type: "GET",
            url: url,
            dataType: "html",
            success: function (response) {
                $('.table-part').html(response);
            }
        });
    }
}

//add property
export function addProperty() {
    if(formAddProperty != null) {
        $('.myapp').html(formAddProperty);
    }
    else {
        const url = "./index.php?action=form&flag=3";
        callFormProduct(url, 3);
    }
}

//search
export function search() {
    dataFilter = null;
    keySearch = $('.searchInput').val();
    const params = {
        action: 'paginate',
        keySearch: keySearch,
    };
    const qrString = httpBuildQuery(params);
    $.ajax({
        type: "GET",
        url: "./index.php?" + qrString,
        dataType: "html",
        success: function (response) {
            $('.table-part').html(response);
        }
    });
}

//filter
export function filter(e) {
    keySearch = null;
    dataFilter = new FormData(this);
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "./index.php?action=paginate",
        data: dataFilter,
        processData: false,
        contentType: false,
        dataType: 'html',
        success: function (response) {
            $('.table-part').html(response);
        }
    });
}

//pagination
export function eventClickPagintion() {
    let currentPage = $(this).data('value');
    const params = {
        action: 'paginate',
        currentPage: currentPage,
    };

    if (keySearch != null) {
        params.keySearch = keySearch;
    }

    const qrString = httpBuildQuery(params);
    let url = "./index.php?" + qrString;

    if (dataFilter != null) {
        $.ajax({
            type: "POST",
            url: url,
            data: dataFilter,
            processData: false, // Tắt xử lý dữ liệu tự động để tránh biến đổi FormData
            contentType: false, // Tắt thiết lập tiêu đề 'Content-Type' tự động
            dataType: "html",
            success: function (response) {
                $('.table-part').html(response);
            }
        });
    }
    else {
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'html',
            success: function (response) {
                $('.table-part').html(response);
            }
        });
    }
}

//submit form
export function formSubmit(e) {
    e.preventDefault();
    let formData = new FormData(this);
    const formTitle = $('.myapp .header h2').text().trim();
    let flag = 0;
    if (formTitle == 'ADD PRODUCT') {
        flag = 1;
    }

    let params = {
        action: 'validate',
        flag: flag,
    };

    if (formTitle == 'UPDATE PRODUCT') {
        flag = 2;
        params.flag = 2;
        params.productId = productId;
        params.currentPage = currentPage;
    }

    if (formTitle == 'ADD PROPERTY') {
        flag = 3;
        params.flag = 3;
    }

    const qrString = httpBuildQuery(params);

    $.ajax({
        type: "POST",
        url: "./index.php?" + qrString,
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (response) {
            $('.myapp').html(response.html);
            $('.ui.dropdown').dropdown();
            if (flag == 1 || flag == 2) {
                previewImg();
            }
            if (response.errProperty == false) {
                $('#addNewTag').val(null);
                $('#addNewCate').val(null);
            }
        }
    });
}


//config form
function previewImg() {
    $("input#featuredimgId").change(function () {
        $('div.err-img div.pointing.red.label').remove();
        $(".featured-img").empty();
        $(".list-g.f").empty();
        var file = this.files[0];
        var url = URL.createObjectURL(file);
        var imgElement = $("<img>")
            .attr("src", url)
            .addClass("featured preview_img");
        $(".featured-img").append(imgElement);
    });

    $("input#gallariesId").change(function () {
        $('div.err-img div.pointing.red.label').remove();
        $(".box-gallery").empty();
        $('div.ui.small.images.g').remove();
        var files = this.files;
        for (let index = 0; index < files.length; index++) {
            var file = this.files[index];
            var url = URL.createObjectURL(file);
            var imgElement = $("<img>")
                .attr("src", url)
                .addClass("gal preview_img" + index);
            $(".box-gallery").append(imgElement);
        }
    });
}

export function callFormProduct(url, flag) {
    $.ajax({
        type: "GET",
        url: url,
        dataType: "html",
        success: function (response) {
            $('.myapp').html(response);
            $('.ui.dropdown').dropdown();
            if(flag == 1 || flag == 2) {
                previewImg();
            }
            
            if(flag == 1) {
                formAddProduct = response;
            }

            if(flag == 3) {
                formAddProperty = response;
            }
        }
    });
}

export function exitForm() {
    if (mainContent != null) {
        $('.myapp').html(mainContent);
        $('.ui.dropdown').dropdown();
    }
    else {
        init();
    }
}

//query builder
function httpBuildQuery(params) {
    const queryString = Object.keys(params)
        .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
        .join('&');
    return queryString;
}