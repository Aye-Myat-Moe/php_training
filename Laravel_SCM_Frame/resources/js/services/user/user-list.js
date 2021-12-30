import constants from "../../constants";
import moment from "moment";
import { mapGetters } from "vuex";
export default {
    data() {
        return {
            isDeleteDialog: false,
            dialogTitle: "",
            dialog: false,
            valid: true,
            fromDate: "",
            toDate: "",
            fromMenu: false,
            toMenu: false,
            typeList: constants.USER_TYPE_LIST,
            name: "",
            email: "",
            headers: [
                {
                    text: "ID",
                    align: "start",
                    value: "id"
                },
                { text: "Name", value: "name" },
                { text: "Email", value: "email" },
                { text: "Created User", value: "created_user", width: 150 },
                { text: "Type", value: "type" },
                { text: "Phone", value: "phone" },
                { text: "Date of Birth", value: "dob" },
                { text: "Address", value: "address" },
                { text: "Created Date", value: "created_at" },
                { text: "Updated Date", value: "updated_at" },
                { text: "Operation", value: "operation" }
            ],
            userList: [],
            showList: [],
            userInfo: null
        };
    },
    computed: {
        ...mapGetters(["userId"])
    },
    mounted() {
        axios
            .get("/user/list")
            .then(response => {
                this.userList = response.data;
                this.showList = this.userList;
            })
            .catch(err => {
                console.log(err);
            });
    },
    methods: {
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
         * This is to show user detail information.
         * @param {Object} userInfo User information
         * @returns void
         */
        showUserDetail(userInfo) {
            this.dialogTitle = "User Detail";
            this.dialog = true;
            this.userInfo = userInfo;
        },

        /**
         * This is to show user delete dialog.
         * @param {Object} userInfo user information
         * @returns void
         */
        showUserDeleteDialog(userInfo) {
            this.dialogTitle = "User Delete Confirmation";
            this.isDeleteDialog = true;
            this.dialog = true;
            this.userInfo = userInfo;
        },
        /**
         * This is to delete user and change on server
         * @returns void
         */
        deleteUser() {
            axios
                .delete(`/user/delete/${this.userInfo.id}`)
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
         * This to filter user of data table.
         * @returns userList to show on datatable
         */
        filterUsers() {
            this.showList = this.userList.filter(user => {
                let isBetweenDuration = true;
                if (this.fromDate && this.toDate) {
                    if (
                        moment(user.created_at).valueOf() >=
                            moment(this.fromDate).valueOf() &&
                        moment(user.created_at).valueOf() <=
                            moment(this.toDate).valueOf()
                    ) {
                        isBetweenDuration = true;
                    } else {
                        isBetweenDuration = false;
                    }
                }
                return (
                    user.name.includes(this.name) &&
                    user.email.includes(this.email) &&
                    isBetweenDuration
                );
            });
        }
    },
    updated() {
        if (this.fromDate || this.toDate) {
            this.valid =
                moment(this.toDate).valueOf() >=
                moment(this.fromDate).valueOf();
        }

        if (document.getElementById("detail-dialog")) {
            document.getElementById(
                "detail-name"
            ).textContent = this.userInfo.name;
            document.getElementById(
                "detail-email"
            ).textContent = this.userInfo.email;
            document.getElementById("detail-type").textContent = this.typeList[
                this.userInfo.type
            ];
            document.getElementById("detail-dob").textContent = moment(
                this.userInfo.dob
            ).format("YYYY/MM/DD");
            document.getElementById(
                "detail-phone"
            ).textContent = this.userInfo.phone;
            document.getElementById(
                "detail-address"
            ).textContent = this.userInfo.address;
            document.getElementById("detail-created-date").textContent = moment(
                this.userInfo.created_at
            ).format("YYYY/MM/DD");
            document.getElementById(
                "detail-created-user"
            ).textContent = this.userInfo.created_user;
            document.getElementById("detail-updated-date").textContent = moment(
                this.userInfo.updated_at
            ).format("YYYY/MM/DD");
            document.getElementById(
                "detail-updated-user"
            ).textContent = this.userInfo.updated_user;
            const image = document.getElementById("profile-preview");
            axios
                .get(`/profile/${this.userInfo.id}/${this.userInfo.profile}`)
                .then(response => {
                    image.src = "data:image/png;base64," + response.data;
                    image.style.border = "1px solid rgb(206, 212, 218)";
                    image.style.display = "block";
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
