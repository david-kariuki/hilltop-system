//main module js file
const main_page = '/libs/js/System.js';

//jquery
const JQuery = 'https://code.jquery.com/jquery-3.5.1.min.js'

//reload the site on save
const live_page = '/libs/js/live.js';

//hooks
const postHook = '/libs/js/hooks/post.js';

//views

require([
    main_page,
    live_page,
    // hooks,
    postHook,
    // views


], function() {
    $(document).ready(function() {
        function callBack() {
            openCatalogue();
        }
    });
});