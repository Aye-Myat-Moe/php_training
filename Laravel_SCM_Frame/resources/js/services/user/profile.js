import constants from "../../constants";

export default {
    computed: {
        data() {
            return {
                userInfo: null
            };
        }
    },
    mounted() {
        axios
            .get("/user/profile")
            .then(response => {
                this.userInfo = response.data;
                document.getElementById(
                    "detail-name"
                ).textContent = this.userInfo.name;
                document.getElementById(
                    "detail-email"
                ).textContent = this.userInfo.email;
                document.getElementById("detail-type").textContent =
                    constants.USER_TYPE_LIST[this.userInfo.type];
                document.getElementById(
                    "detail-dob"
                ).textContent = this.userInfo.dob;
                document.getElementById(
                    "detail-phone"
                ).textContent = this.userInfo.phone;
                document.getElementById(
                    "detail-address"
                ).textContent = this.userInfo.address;
                const image = document.getElementById("profile-preview");
                axios
                    .get(
                        `/profile/${this.userInfo.id}/${this.userInfo.profile}`
                    )
                    .then(response => {
                        image.src = "data:image/png;base64," + response.data;
                        image.style.border = "1px solid rgb(206, 212, 218)";
                        image.style.display = "block";
                        document.getElementById("loading-box").style.display =
                            "none";
                    })
                    .catch(err => {
                        console.log(err);
                    });
            })
            .catch(err => {
                console.log(err);
            });
    },
    methods: {
        /**
         * This to route to edit profile page.
         * @returns void
         */
        editProfile() {
            this.$router.push({ name: "profile-edit" });
        },
        /**
         * This is to route to change password.
         * @returns void
         */
        changePassword() {
            this.$router.push({ name: "change-password" });
        }
    }
};
