//main module js file
const main_page = '/libs/js/System.js';

//reload the site on save
const live_page = '/libs/js/live.js';

//hooks
const postHook = '/libs/js/hooks/post.js';

//views
const login_page = '/libs/js/views/loginView.js'
const home_page = '/libs/js/views/homeView.js'
const catalogue_page = '/libs/js/views/catalogueView.js'
const moderator_page = '/libs/js/views/moderatorView.js'
const sales_page = '/libs/js/views/salesView.js'
const transaction_page = '/libs/js/views/transactionView.js'
const pointOfSale_page = '/libs/js/views/pointOfSaleView.js'
const Account_page = '/libs/js/views/accountView.js'


require([
    main_page,
    live_page,
    // hooks,
    postHook,
    // views
    login_page,
    home_page,
    catalogue_page,
    moderator_page,
    sales_page,
    transaction_page,
    pointOfSale_page,
    Account_page

], function() {
    $(document).ready(function() {
        function callBack() {
            renderMainContentView('Catalogue');
        }

        callBack();

    });
    $('[data-toggle="tooltip"]').tooltip();
});