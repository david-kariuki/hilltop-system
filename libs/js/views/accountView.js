function open_accountForm_view(viewName, id) {
    var action = "openUserAccount";
    var view = "accounts";
    var data = $("[name='passwordConfirm']").val();

    if (isEmpty(data)) {
        alert("Please Enter Password");
        return;
    }

    sendDataToHandler(action, view, data, callback, id);

    function callback(msg) {
        var data = JSON.parse(msg)

        if (data.status) {
            var action = "launch";
            var view = "accounts";
            var data = $("[name='passwordConfirm']").val();

            if (isEmpty(data)) {
                alert("Please Enter Password");
                return;
            }

            sendDataToHandler(action, view, data, callback2, id);

            function callback2(msg) {
                var renderedElement = $(".contentArea_panel");

                renderedElement.html(msg);
            }
        } else {
            alert(data.response);
        }
    }
}

function update_password(id = null) {
    var action = "updatePassword";
    var view = "accounts";
    var data = {
        "password": $("[name='Password']").val(),
        "confirmPassword": $("[name='confirmPassword']").val()
    };

    if (isEmpty(data.password) || isEmpty(data.confirmPassword)) {
        alert("No values entered");
        return;
    }

    if (data.password !== data.confirmPassword) {
        alert("Passwords do not match");
        return;
    }

    sendDataToHandler(action, view, data, callback, id);

    function callback(msg) {
        var data = JSON.parse(msg);

        if (data.status) {
            alert("Password was updated successfully");
        } else {
            alert("Error updating password");
        }


    }
}