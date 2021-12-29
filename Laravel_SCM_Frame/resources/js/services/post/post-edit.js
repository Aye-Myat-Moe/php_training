import constants from "../../constants";

export default {
    data: () => ({
        errors: "",
        valid: true,
        title: "",
        description: "",
        dialog: false,
        postInfo: null,
        status: false,
        statusList: constants.POST_STATUS_LIST,
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
         * This is to reset edit post form.
         * @returns void
         */
        resetForm() {
            this.$refs.form.reset();
        },

        /**
         * This is to submit edit post form.
         * @returns void
         */
        submitForm() {
            const formData = new FormData();
            formData.append("title", this.title);
            formData.append("description", this.description);
            if (this.status) formData.append("status", 1);
            else formData.append("status", 0);
            axios
                .post(`/post/edit/${this.$route.params.id}`, formData, {
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
    },
    mounted() {
        axios
            .get(`/post/${this.$route.params.id}`)
            .then(response => {
                if (!response.data.title) {
                    this.$router.push({ name: "post-list" });
                }
                this.postInfo = response.data;
                this.title = response.data.title;
                this.description = response.data.description;
                if (response.data.status) this.status = true;
                if (!response.data.status) this.status = false;
            })
            .catch(err => {
                console.log(err);
            });
    }
};
