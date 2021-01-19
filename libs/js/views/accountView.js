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

function time_function() {

}

function showTime() {
    const monthNames = ["January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    var date = new Date();

    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    var day = date.getDate();
    var mt = date.getMonth();
    var y = date.getFullYear();

    if (h == 0) {
        h = 12;
    }

    if (h > 12) {
        h = h - 12;
        session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    $("#hour").html(h)
    $("#min").html(m)
    $("#sec").html(s)
    $("#period").html(session)

    $("#day").html(day)
    $("#month").html(monthNames[mt]);
    $("#Year").html(y)
}
window.setInterval(function() {
    showTime()
}, 1000);