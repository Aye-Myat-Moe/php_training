import constants from "../../constants";

export default {
    data: () => ({
        errors: "",
        valid: true,
        title: "",
        description: "",
        dialog: false,
        titleRules: [
            value => !!value || "The title field is required.",
            value =>
                !value ||
                value.length <= constants.POST_VALIDATED_VALUES.title.max ||
                `The title filed must be at most ${constants.POST_VALIDATED_VALUES.title.max} characters.`
        ],
        descriptionRules: [
            value => !!value || "The description field is required."
        ]
    }),
    methods: {
        /**
         * This is to reset create post form.
         * @returns void
         */
        resetForm() {
            this.$refs.form.reset();
        },

        /**
         * This is to submit create post form.
         * @returns void
         */
        submitForm() {
            const formData = new FormData();
            formData.append("title", this.title);
            formData.append("description", this.description);
            axios
                .post("/post/create", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(() => {
                    this.dialog = false;
                    this.errors = "";
                    this.$router.push({ name: "post-list" });
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
    }
};
