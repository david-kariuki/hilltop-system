function select_current_moderator() {
    console.log("checked");
    event.stopImmediatePropagation();
}

function open_selected_moderator(viewName, loadingData = null, id) {
    var action = "openModerator";
    var View = "moderators";
    var form = viewName;
    var token = 1;
    var data = viewName;

    var renderedElement = $(".contentArea_panel");

    formViewHandler(action, View, form, data, loadingData, callback, id);

    function callback(msg) {
        renderedElement.html(msg);
    }
}

function collect_user_Data(userAction = null) {

    var firstName = $("[name='firstName']").val();
    var lastName = $("[name='lastName']").val();
    var otherName = $("[name='otherName']").val();
    var userName = $("[name='userName']").val();
    var emailAddress = $("[name='emailAddress']").val();
    var gender = $("[name='gender']").val();
    var Password = $("[name='Password']").val();
    var confirmPassword = $("[name='confirmPassword']").val();
    var Address = $("[name='Address']").val();
    var nationalID = $("[name='nationalID']").val();
    var city = $("[name='city']").val();
    var role = $("[name='role']").val();
    var status = $("[name='status']").val();


    var data = {
        firstName: firstName,
        lastName: lastName,
        otherName: otherName,
        userName: userName,
        emailAddress: emailAddress,
        gender: gender,
        password: Password,
        confirmPassword: confirmPassword,
        Address: Address,
        city: city,
        nationalID: nationalID,
        role: role,
        status: status,
    }
    var i = 1;

    $.each(data, function(key, valueObj) {
        if (isEmpty(valueObj) && !userAction == "update") {
            data = false;
            return
        }
    });

    return data;
}

function create_user() {
    var data = collect_user_Data("update");

    if (data) {
        var action = "createNewUser";
        var view = "moderators";
        var data = data;

        sendDataToHandler(action, view, data, callback, null);

        function callback(msg) {
            var data = JSON.parse(msg);

            if (data.status === true) {
                console.log(data);
                alert("User " + data.response[0].userName + " created successfully");
            } else {
                alert(data.response);
            }
        }

    } else {
        alert("All fields are required");
    }
}

function update_user(id = null) {
    var data = collect_user_Data();

    if (data) {
        var action = "updateUser";
        var view = "moderators";
        var data = data;

        sendDataToHandler(action, view, data, callback, id);

        function callback(msg) {
            var data = JSON.parse(msg);

            if (data.status) {
                alert('User Updated successfully');
            } else {
                alert('an error occurred while updating record');
            }
        }

    } else {
        alert("All fields are required");
    }
}

function delete_multiple_moderators() {
    var action = "deleteMultipleUsers";
    var view = "moderators";
    var data = gather_select_moderator();

    sendDataToHandler(action, view, data, callback);

    function callback(msg) {
        console.log(msg);
    }
}

function gather_select_moderator() {
    var ids = [];
    var elem = $(".items_area");

    elem.find("tr>td>div>input").each(function() {
        var parent = $(this).parent().parent().parent();
        var id = parent.data("uid");

        ids.push(id);
    });

    return ids;
}