import * as myFunc from './funcEvent2.js';
$(function () {
    var isSyncing = false;

    myFunc.init();
    $('.myapp').on('click', 'a.page-link', myFunc.eventClickPagintion);
    $('.myapp').on('click', '.add-product.button', myFunc.addProduct);
    $('.myapp').on('submit', '.form.add-update', myFunc.formSubmit);
    $('.myapp').on('click', '.add-property', myFunc.addProperty);
    $('.myapp').on('click', '.sync.button', () => {
        if (isSyncing) {
            return;
        }
        isSyncing = true;
        myFunc.sync().then(result => {
            isSyncing = result; 
        });
    });
    $('.myapp').on('keypress', '.searchInput', (e) => {
        if (e.which === 13) {
            myFunc.search();
        }
    });
    $('.myapp').on('click', 'i.icon.search', myFunc.search);
    $('.myapp').on('submit', '.ui.form.filter', myFunc.filter);
    $('.myapp').on('click', 'a.update-link', myFunc.updateProduct);
    $('.myapp').on('click', 'a.delete-link', myFunc.handleDelete);
    $('.myapp').on('click', '.close.icon', myFunc.init);
    $('.myapp').on('click', '.deny.button', myFunc.init);
});

