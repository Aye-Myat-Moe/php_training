import constants from "../../constants";

export default {
    data() {
        return {
            errors: "",
            valid: true,
            oldPassword: "",
            newPassword: "",
            confirmNewPassword: "",
            oldPwdRules: [
                value => !!value || "The old password field is required."
            ],
            newPwdRules: [
                value => !!value || "The new password field is required.",
                value =>
                    !value ||
                    value.length >=
                        constants.USER_VALIDATED_VALUES.password.min ||
                    `The new password filed must be at least ${constants.USER_VALIDATED_VALUES.password.min} characters.`
            ]
        };
    },
    computed: {
        /**
         * THis is custom validation rule for confirm new password.
         * @returns Array rules
         */
        confirmNewPwdRules() {
            const rules = [];
            if (this.newPassword) {
                const rule = value =>
                    (!!value && value) === this.newPassword ||
                    "Password do not match.";
                rules.push(rule);
            }
            return rules;
        }
    },
    methods: {
        /**
         * This is to reset change password form.
         * @returns void
         */
        resetForm() {
            this.errors = "";
            this.$refs.form.reset();
        },

        /**
         * This is to submit change password form.
         * @returns void
         */
        submitForm() {
            const formData = new FormData();
            formData.append("current_password", this.oldPassword);
            formData.append("new_password", this.newPassword);
            formData.append("new_confirm_password", this.confirmNewPassword);
            axios
                .post("user/change-password", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(() => {
                    this.$router.push({ name: "profile" });
                })
                .catch(err => {
                    this.valid = false;
                    this.errors = err.response.data.errors;
                    console.log(err);
                });
        }
    }
};
