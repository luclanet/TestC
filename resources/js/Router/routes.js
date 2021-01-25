const routes = [
    {
        path: '',
        component: () => import('../Pages/Home.vue'),
        name: 'home'
    },
    {
        path: '/login',
        component: () => import('../Pages/Login.vue'),
        name: 'login'
    }
];

export default routes;