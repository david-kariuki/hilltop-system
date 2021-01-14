function toggle_product_details_section() {
    var element = $(event.currentTarget);
    var tab_name = element.html();

    switch (tab_name) {
        case "Store":
            toggle_Active_tab(element, $(".store_section"));
            render_navigation_Buttons(element);
            break;
        case "Wholesale":
            toggle_Active_tab(element, $(".wholesale_section"));
            render_navigation_Buttons(element);
            break;
        case "Vehicle":
            toggle_Active_tab(element, $(".vehicle_section"));
            render_navigation_Buttons(element);
            break;
        case "Product Details":
            toggle_Active_tab(element, $(".product_section"));
            render_navigation_Buttons(element);
            break;
        default:
            alert("Invalid Entry");
    }

    function toggle_Active_tab(elem, element2) {
        var parent = $(".sections_elem");

        var list = parent.find(".content_product_section");

        $.each(list, function(key, value) {
            var parent1 = $(value).parent();
            parent1.fadeOut();
        });
        $(element2).fadeIn()

    }

    function render_navigation_Buttons(element) {
        var parent = $(".section_navigation");

        var list = parent.find("li");

        $.each(list, function(key, value) {
            $(value).removeClass("high_lighted");
        });

        element.addClass("high_lighted");
    }
}

function select_current_product() {
    console.log("checked");
    event.stopImmediatePropagation();
}

function open_selected_product(viewName, loadingData = null, callBack = null) {
    var action = "openProduct";
    var View = "catalogue";
    var form = viewName;
    var token = 1;
    var data = viewName;
    var id = null;

    var renderedElement = $(".contentArea_panel");

    formViewHandler(action, View, form, data, callback, id);

    function callback(msg) {
        renderedElement.html(msg);
    }
}