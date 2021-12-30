import constants from "../../constants";
import { mapGetters } from "vuex";
import moment from "moment";
export default {
    data() {
        return {
            keyword: "",
            valid: true,
            postInfo: null,
            dialogTitle: "",
            dialog: false,
            isDeleteDialog: false,
            headerList: [
                {
                    text: "ID",
                    align: "start",
                    value: "id"
                },
                {
                    text: "Post Title",
                    value: "title"
                },
                {
                    text: "Post Desciption",
                    value: "description"
                },
                {
                    text: "Posted User",
                    value: "created_user"
                },
                {
                    text: "Operation",
                    value: "operation"
                }
            ],
            postList: [],
            showList: []
        };
    },
    computed: {
        ...mapGetters(["isLoggedIn"]),
        headers() {
            if (!this.isLoggedIn) {
                return this.headerList.slice(0, this.headerList.length - 1);
            } else {
                return this.headerList;
            }
        }
    },
    mounted() {
        axios
            .get("/post/list")
            .then(response => {
                this.postList = response.data;
                this.showList = this.postList;
            })
            .catch(err => {
                console.log(err);
            });
    },
    methods: {
        /**
         * This is to filter posts of datatable.
         * @returns void
         */
        filterPosts() {
            this.showList = this.postList.filter(post => {
                return (
                    post.title.includes(this.keyword) ||
                    post.description.includes(this.keyword) ||
                    post.created_user.includes(this.keyword)
                );
            });
        },
        /**
         * This is to show post detail.
         * @param {Object} postInfo post information
         * @returns void
         */
        showPostDetail(postInfo) {
            this.dialogTitle = "Post Detail";
            this.dialog = true;
            this.postInfo = postInfo;
        },
        /**
         * This is to close dialog.
         * @returns void
         */
        closeDialog() {
            this.dialogTitle = "";
            this.dialog = false;
            this.isDeleteDialog = false;
        },
        /**
         * This is to show post delete dialog.
         * @param {Object} postInfo post information
         * @returns void
         */
        showPostDeleteDialog(postInfo) {
            this.dialogTitle = "Post Delete Confirmation";
            this.isDeleteDialog = true;
            this.dialog = true;
            this.postInfo = postInfo;
        },
        /**
         * This is to delete post and change on server.
         * return void
         */
        deletePost() {
            axios
                .delete(`/post/delete/${this.postInfo.id}`)
                .then(response => {
                    location.reload();
                })
                .catch(err => {
                    console.log(err);
                });
            this.isDeleteDialog = false;
            this.dialog = false;
        },
        /**
         * This is to route post create page.
         * @returns void
         */
        createPost() {
            this.$router.push({ name: "create-post" });
        },
        /**
         * This is to show post edit page.
         * @param {integer} postId post id
         * @returns void
         */
        showPostEdit(postId) {
            this.$router.push({ name: "edit-post", params: { id: postId } });
        },
        /**
         * This is to route post upload page.
         * @return void
         */
        uploadPost() {
          this.$router.push({ name: "upload-post" });
        }
    },
    updated() {
        if (document.getElementById("detail-dialog")) {
            document.getElementById(
                "detail-title"
            ).textContent = this.postInfo.title;
            document.getElementById(
                "detail-description"
            ).textContent = this.postInfo.description;
            document.getElementById("detail-status").textContent =
                constants.POST_STATUS_LIST[this.postInfo.status];
            document.getElementById("detail-posted-date").textContent = moment(
                this.postInfo.created_at
            ).format("YYYY/MM/DD");
            document.getElementById(
                "detail-posted-user"
            ).textContent = this.postInfo.created_user;
            document.getElementById("detail-updated-date").textContent = moment(
                this.postInfo.updated_at
            ).format("YYYY/MM/DD");
            document.getElementById(
                "detail-updated-user"
            ).textContent = this.postInfo.updated_user;
        }
    }
};
