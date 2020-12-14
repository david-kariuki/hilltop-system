function sendToHandler(action, handler, data, callback, id) {
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