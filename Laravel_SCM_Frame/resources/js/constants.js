const constants = {
    /**
     * App title
     */
    APP_TITLE: "SCM Bulletin Board",

    /**
     * API base url
     */
    API_BASE_URL: "http://localhost:8000/api",

    /**
     * User Type List
     */
    USER_TYPE_LIST: ["Admin", "User"],

    /**
     * User Validation values
     */
    USER_VALIDATED_VALUES: {
        name: {
            max: 255
        },
        email: {
            max: 255
        },
        password: {
            min: 8
        },
        phone: {
            max: 20
        },
        address: {
            max: 255
        },
        profile: {
            size: 2
        }
    },

    /**
     * post validated values
     */
    POST_VALIDATED_VALUES: {
        title: {
            max: 255
        },
        csv: {
          size: 2
        }
    },

    /**
     * post status list
     */
    POST_STATUS_LIST: ["Inactive", "Active"]
};

export default constants;
