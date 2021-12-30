// The plugin function for adding a new filtering routine
$.fn.dataTableExt.afnFiltering.push(function(oSettings, aData, iDataIndex) {
    if (!$("#dateStart").val() && !$("#dateEnd").val()) {
        return true;
    }
    var dateStart = moment($("#dateStart").val(), "YYYY-MM-DD").valueOf();
    var dateEnd = moment($("#dateEnd").val(), "YYYY-MM-DD").valueOf();
    var evalDate = moment(aData[8], "YYYY/MM/DD").valueOf();
    if (evalDate >= dateStart && evalDate <= dateEnd) {
        return true;
    } else {
        return false;
    }
});
/**
 * To set data table
 */
$(document).ready(function() {
    const userTable = $("#user-list").DataTable({
        sDom: "lrtip"
    });

    $("#search-click").click(function() {
        userTable
            .columns(1)
            .search($("#search-name").val())
            .columns(2)
            .search($("#search-email").val())
            .draw();
    });
});

/**
 * To show user detail
 * @param {Object} userInfo userinfo
 * @returns void
 */
function showUserDetail(userInfo) {
    $("#user-detail #user-name").text(userInfo.name);
    if (userInfo.type == "0") {
        $("#user-detail #user-type").text("Admin");
    } else if(userInfo.type == "1") {
        $("#user-detail #user-type").text("User");
    } else {
      $("#user-detail #user-type").text("Visitor");
    }
    $("#user-detail #user-email").text(userInfo.email);
    $("#user-detail #user-phone").text(userInfo.phone);
    $("#user-detail #user-dob").text(moment(userInfo.dob).format("YYYY/MM/DD"));
    $("#user-detail #user-address").text(userInfo.address);
    $("#user-detail #user-profile").attr(
        "src",
        "/profile/" + userInfo.id + "/" + userInfo.profile
    );
    $("#user-detail #user-created-at").text(
        moment(userInfo.created_at).format("YYYY/MM/DD")
    );
    $("#user-detail #user-created-user").text(userInfo.created_user);
    $("#user-detail #user-updated-at").text(
        moment(userInfo.updated_at).format("YYYY/MM/DD")
    );
    $("#user-detail #user-updated-user").text(userInfo.updated_user);
}

/**
 * To show user delete confirm
 * @param {Object} userInfo userInfo
 * @returns void
 */
function showDeleteConfirm(userInfo) {
    $("#user-delete #user-id").text(userInfo.id);
    $("#user-delete #user-name").text(userInfo.name);
    if (userInfo.type == "0") {
        $("#user-delete #user-type").text("Admin");
    } else if (userInfo.type == "1") {
        $("#user-delete #user-type").text("User");
    } else {
        $("#user-delete #user-type").text("Visitor");
    }
    $("#user-delete #user-email").text(userInfo.email);
    $("#user-delete #user-phone").text(userInfo.phone);
    $("#user-delete #user-dob").text(userInfo.dob);
    $("#user-delete #user-address").text(userInfo.address);
}

/**
 * To delete user by id
 * @returns void
 */
async function deleteUserById(csrf_token) {
    await $.ajax({
        url: "/user/delete/" + $("#user-delete #user-id").text(),
        type: "DELETE",
        data: {
            _token: csrf_token
        },
        dataType: "text",
        success: function(result) {
            console.log(result);
            location.reload();
        }
    });
}
