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

function formViewHandler(action, View, form, data, callback, id, ) {
    $.post("Views/" + View + "/" + form + ".php", {
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