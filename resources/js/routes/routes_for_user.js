import VueRouter from 'vue-router';

const routes_for_user = [
    { path: "/home", redirect: { name: "dashboard" } },
]

export const router_for_user = new VueRouter({
    mode: history,
    routes: routes_for_user
})
