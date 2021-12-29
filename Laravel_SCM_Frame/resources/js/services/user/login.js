export default {
    data: () => ({
        valid: true,
        email: "",
        password: "",
        error: "",

        // validation rules for user email.
        emailRules: [
            value => !!value || "The email field is required.",
            value => /.+@.+\..+/.test(value) || "E-mail must be valid."
        ],

        // validation rules for password.
        pwdRules: [value => !!value || "The password field is required."]
    }),
    methods: {
        /**
         * This to submit login form.
         * @returns void
         */
        login() {
            this.$store
                .dispatch("login", {
                    email: this.email,
                    password: this.password
                })
                .then(() => {
                    this.error = "";
                    this.$router.push({ name: "post-list" });
                })
                .catch(err => {
                    this.error = err.response.data.errors.message;
                    console.log(err);
                });
        }
    }
};
