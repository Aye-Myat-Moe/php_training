import constants from "../../constants";

export default {
    data: () => ({
        error: "",
        valid: true,
        csvFile: null,
        csvFileRules: [
            value => !!value || "The CSV File field is required.",
            value =>
                !value ||
                value.size <
                    constants.POST_VALIDATED_VALUES.csv.size * 1000000 ||
                `CSV File size should be less than ${constants.POST_VALIDATED_VALUES.csv.size} MB!`,

            value =>
                !value ||
                value.name.split(".").pop() == "csv" ||
                "CSV File must be CSV format."
        ]
    }),
    methods: {
        /**
         * This is to reset upload form.
         * @returns void
         */
        resetForm() {
            this.$refs.form.reset();
        },

        /**
         * This is to submit upload form.
         * @returns void
         */
        submitForm() {
            // To send data like form data including CSV File
            const formData = new FormData();
            formData.append("csv_file", this.csvFile);
            axios
                .post("/post/upload", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(() => {
                    this.error = "";
                    this.$router.push({ name: "post-list" });
                })
                .catch(err => {
                    this.valid = false;
                    this.error = err.response.data.error;
                    console.log(err);
                });
        }
    }
};
