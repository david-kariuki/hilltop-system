//main module js file
const main_page = '/libs/js/System.js';

//reload the site on save
const live_page = '/libs/js/live.js';

//hooks
const postHook = '/libs/js/hooks/post.js';

//views
const login_page = '/libs/js/views/loginView.js'
const home_page = '/libs/js/views/homeView.js'
const catalogue_form_page = '/libs/js/views/catalogueFormView.js'

require([
    main_page,
    live_page,
    // hooks,
    postHook,
    // views
    login_page,
    home_page,
    catalogue_form_page


], function() {
    $(document).ready(function() {
        function callBack() {
            openCatalogue();
        }
    });
    $('[data-toggle="tooltip"]').tooltip();
});