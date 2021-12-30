import constants from "../../constants";
import DateOfBirthPicker from "../../components/DateOfBirthPicker";

export default {
    components: {
        DateOfBirthPicker
    },
    data() {
        return {
            errors: "",
            valid: true,
            name: "",
            email: "",
            password: "",
            confirmPassword: "",
            type: "",
            dob: "",
            phone: "",
            address: "",
            profile: null,
            dialog: false,
            userInfo: null,

            // validataion rules for user name
            nameRules: [
                value => !!value || "The name field is required.",
                value =>
                    !value ||
                    value.length <= constants.USER_VALIDATED_VALUES.name.max ||
                    `The name filed must be at most ${constants.USER_VALIDATED_VALUES.name.max} characters.`
            ],

            // validation rules for user email
            emailRules: [
                value => !!value || "The email field is required..",
                value =>
                    /.+@.+\..+/.test(value) ||
                    "The email field must be an email.",
                value =>
                    !value ||
                    value.length <= constants.USER_VALIDATED_VALUES.email.max ||
                    `The email filed must be at most ${constants.USER_VALIDATED_VALUES.email.max} characters.`
            ],

            // validation rules for user type
            typeRules: [value => !!value || "The Type field is required."],

            // validataion rules for user phone
            phoneRules: [
                value =>
                    !value ||
                    value.length <= constants.USER_VALIDATED_VALUES.phone.max ||
                    `The phone filed must be at most ${constants.USER_VALIDATED_VALUES.phone.max} characters.`
            ],

            // validation rules for user address
            addressRules: [
                value =>
                    !value ||
                    value.length <=
                        constants.USER_VALIDATED_VALUES.address.max ||
                    `The address filed must be at most ${constants.USER_VALIDATED_VALUES.address.max} characters.`
            ],

            // validation rules for profile picture
            profileRules: [
                value =>
                    !value ||
                    value.size <
                        constants.USER_VALIDATED_VALUES.profile.size *
                            1000000 ||
                    `Profile size should be less than ${constants.USER_VALIDATED_VALUES.profile.size} MB!`,
                value =>
                    !value ||
                    /^image/.test(value.type) ||
                    "Profile must be image (png or jpg)."
            ],

            // User Type list
            typeList: constants.USER_TYPE_LIST
        };
    },
    methods: {
        /**
         * This is to handle for profile inputting and to show profile preview.
         * @param {File} profile profile image
         * @returns void
         */
        handleProfileInput(profile) {
            const image = document.getElementById("profile-preview");
            image.style.display = "none";
            if (profile && /^image/.test(profile.type)) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    image.src = event.target.result;
                    image.style.border = "1px solid rgb(206, 212, 218)";
                    image.style.display = "block";
                };
                reader.readAsDataURL(profile);
            } else {
                this.showProfilePhoto("profile-preview");
            }
        },
        /**
         * This is to get profile photo from server side.
         * @param elementId element id to show
         * @returns void
         */
        showProfileDetail() {
            axios
                .get("/user/profile")
                .then(response => {
                    this.userInfo = response.data;
                    this.name = response.data.name;
                    this.email = response.data.email;
                    this.type = constants.USER_TYPE_LIST[response.data.type];
                    if (response.data.dob) this.dob = response.data.dob;
                    if (response.data.phone) this.phone = response.data.phone;
                    if (response.data.address)
                        this.address = response.data.address;
                    this.showProfilePhoto("profile-preview");
                })
                .catch(err => {
                    console.log(err);
                });
        },
        /**
         * This is to show profile photo.
         * @param {String} elementId DOM element id
         * @returns void
         */
        showProfilePhoto(elementId) {
            const image = document.getElementById(elementId);
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
        },
        /**
         * This is to reset profile form.
         * @returns void
         */
        resetForm() {
            const image = document.getElementById("profile-preview");
            image.style.display = "none";
            this.$refs.form.reset();
        },
        /**
         * This is to submit register form.
         * @returns void
         */
        submitForm() {
            // To send data like form data including profile picture
            const formData = new FormData();
            formData.append("name", this.name);
            formData.append("email", this.email);
            formData.append("type", this.typeList.indexOf(this.type));
            formData.append("phone", this.phone);
            formData.append("address", this.address);
            formData.append("dob", this.dob);
            if (this.profile) formData.append("profile", this.profile);
            axios
                .post("/user/profile/edit", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(() => {
                    this.dialog = false;
                    this.errors = "";
                    this.$router.push({ name: "profile" });
                })
                .catch(err => {
                    this.valid = false;
                    this.errors = err.response.data.errors;
                    console.log(err);
                });
        },
        /**
         * This is to close dialog
         * @returns void
         */
        closeDialog() {
            this.dialog = false;
            this.errors = "";
            this.valid = true;
        }
    },
    mounted() {
        this.showProfileDetail();
    },
    updated() {
        const image = document.getElementById("profile-confirm-preview");
        if (image) {
            image.style.display = "none";
            if (this.profile && /^image/.test(this.profile.type)) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    image.src = event.target.result;
                    image.style.border = "1px solid rgb(206, 212, 218)";
                    image.style.display = "block";
                };
                reader.readAsDataURL(this.profile);
            } else {
                this.showProfilePhoto("profile-confirm-preview");
            }
        }
    }
};
