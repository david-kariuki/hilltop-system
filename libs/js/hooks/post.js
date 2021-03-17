/**
 * Render the main View
 * @param {string} action intended action @example "openForm"
 * @param {string} handler file that handles the request
 * @param {[json string]} data the data to be processed
 * @param {[function name]} callback the function to be called after the response is sent back
 * @param {[string]} id id of direct record to be acted on
 */
function mainViewHandler(action, handler, data, callback, id) {
    $.post("app/php/control/" + handler + ".php", {
            action: action,
            data: data,
            id: id
        })
        .done(function(data) {
            if (callback != undefined) {
                callback(data);
            }
        });
}

/**
 * open a form from 
 * @param {string} action intended action @example "openForm"
 * @param {string} View name of view to open 
 * @param {string} form name of the form to open 
 * @param {json string} data data to be processed 
 * @param {[function name]} callback function to be called on receiving response
 */
function formViewHandler(action, View, form, data, loadingData, callback, id) {
    $.post("Views/" + View + "/" + form + ".php", {
            action: action,
            data: data,
            id: id,
            loadingData: loadingData
        })
        .done(function(data) {
            if (callback != undefined) {
                callback(data);
            }
        });
}

/**
 * send data to the control file of specified view
 * @param {string} action intended action to be done
 * @param {string} View view that holds the controller file
 * @param {json string} data data to be processed
 * @param {[function name]} callback call back function after response is received
 * @param {[string]} id id of direct record to be acted on
 */
function sendDataToHandler(action, view, data, callback, id) {
    $.post("Views/" + view + "/control.php", {
            action: action,
            data: data,
            id: id
        })
        .done(function(data) {
            if (callback != undefined) {
                callback(data);
            }
        });
}