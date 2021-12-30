import Login from "../pages/user/Login";
import Register from "../pages/user/Register";
import UserList from "../pages/user/UserList";
import Profile from "../pages/user/Profile";
import ProfileEdit from "../pages/user/ProfileEdit";
import ChangePassword from "../pages/user/ChangePassword";
import PostList from "../pages/post/PostList";
import PostCreate from "../pages/post/PostCreate";
import PostEdit from "../pages/post/PostEdit";
import PostUpload from "../pages/post/PostUpload";

import store from "../store/index";
import Vue from "vue";
import VueRouter from "vue-router";
import constants from "../constants";
Vue.use(VueRouter);
const routes = [
    {
        path: "/vue/login",
        name: "login",
        component: Login
    },
    {
        path: "/vue/profile",
        name: "profile",
        component: Profile,
        meta: {
            authorize: [
                constants.USER_TYPE_LIST[0],
                constants.USER_TYPE_LIST[1]
            ]
        }
    },
    {
        path: "/vue/profile/edit",
        name: "profile-edit",
        component: ProfileEdit,
        meta: {
            authorize: [
                constants.USER_TYPE_LIST[0],
                constants.USER_TYPE_LIST[1]
            ]
        }
    },
    {
        path: "/vue/user/change_password",
        name: "change-password",
        component: ChangePassword,
        meta: {
            authorize: [
                constants.USER_TYPE_LIST[0],
                constants.USER_TYPE_LIST[1]
            ]
        }
    },
    {
        path: "/vue/user/register",
        name: "register",
        component: Register,
        meta: {
            authorize: [constants.USER_TYPE_LIST[0]]
        }
    },
    {
        path: "/vue/user/list",
        name: "user-list",
        component: UserList,
        meta: {
            authorize: [constants.USER_TYPE_LIST[0]]
        }
    },
    {
        path: "/vue/post/list",
        name: "post-list",
        component: PostList,
        meta: {
            authorize: []
        }
    },
    {
        path: "/vue/post/create",
        name: "create-post",
        component: PostCreate,
        meta: {
            authorize: [
                constants.USER_TYPE_LIST[0],
                constants.USER_TYPE_LIST[1]
            ]
        }
    },
    {
        path: "/vue/post/edit/:id",
        name: "edit-post",
        component: PostEdit,
        meta: {
            authorize: [
                constants.USER_TYPE_LIST[0],
                constants.USER_TYPE_LIST[1]
            ]
        }
    },
    {
        path: "/vue/post/upload",
        name: "upload-post",
        component: PostUpload,
        meta: {
            authorize: [
                constants.USER_TYPE_LIST[0],
                constants.USER_TYPE_LIST[1]
            ]
        }
    },
    {
        path: "/vue/*",
        redirect: "/vue/post/list"
    },
    ,
    {
        path: "/vue",
        redirect: "/vue/post/list"
    }
];

const router = new VueRouter({
    mode: "history",
    routes
});

/**
 * This is to handle and check authentication for routing.
 */
router.beforeEach((to, from, next) => {
    const { authorize } = to.meta;
    const loggedIn = store.getters.isLoggedIn;
    const userType = store.getters.userType;
    if (authorize && authorize.length) {
        if (!authorize.includes(constants.USER_TYPE_LIST[userType])) {
            return next("/vue/post/list");
        }
    } else if (loggedIn && to.name == "login") {
        return next("/vue/post/list");
    }

    next();
});

export default router;
