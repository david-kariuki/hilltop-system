/**
 * All Global functionality goes here
 *  
 */

function isEmpty(str) {
    if (typeof str == 'undefined' || !str || str.length === 0 || str === "" || !/[^\s]/.test(str) || /^\s*$/.test(str) || str.replace(/\s/g, "") === "") {
        return true;
    } else {
        return false;
    }
}

function getToken() {
    var token;
    var body;

    body = document.getElementsByTagName('body');
    body = $(body);

    var token = body.attr('data-token');

    return token;
}
const root = "http://mtushimports.local";