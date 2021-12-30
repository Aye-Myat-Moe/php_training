/**
 * To set data table
 */
$(document).ready(function() {
    const postTable = $("#post-list").DataTable({
        sDom: "lrtip"
    });

    $("#search-click").click(function() {
      postTable.search($("#search-keyword").val()).draw();
    });
});

/**
 * To show post detail
 * @param {Object} postInfo postinfo
 * @returns void
 */
function showPostDetail(postInfo) {
    $("#post-detail #post-title").text(postInfo.title);
    $("#post-detail #post-description").text(postInfo.description);
    if (postInfo.status == "0") {
        $("#post-detail #post-status").text("Inactive");
    } else {
        $("#post-detail #post-status").text("Active");
    }
    $("#post-detail #post-created-at").text(
        moment(postInfo.created_at).format("YYYY/MM/DD")
    );
    $("#post-detail #post-created-user").text(postInfo.created_user);
    $("#post-detail #post-updated-at").text(
        moment(postInfo.updated_at).format("YYYY/MM/DD")
    );
    $("#post-detail #post-updated-user").text(postInfo.updated_user);
}

/**
 * To show post delete confirm
 * @param {Object} postInfo postInfo
 * @returns void
 */
function showDeleteConfirm(postInfo) {
    $("#post-delete #post-id").text(postInfo.id);
    $("#post-delete #post-title").text(postInfo.title);
    $("#post-delete #post-description").text(postInfo.description);
    if (postInfo.status == "0") {
        $("#post-delete #post-status").text("Inactive");
    } else {
        $("#post-delete #post-status").text("Active");
    }
}

/**
 * To delete post by id
 * @returns void
 */
async function deletePostById(csrf_token) {
    await $.ajax({
        url: "/post/delete/" + $("#post-delete #post-id").text(),
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
