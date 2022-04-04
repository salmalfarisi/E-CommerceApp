const Main = () => import('./components/content/account/main.vue');
const Registration = () => import('./components/content/account/registration.vue');
const ProductIndex = () => import('./components/content/product/index.vue');
const ProductForm = () => import('./components/content/product/form.vue');
const UserIndex = () => import('./components/content/user/index.vue');
const UserForm = () => import('./components/content/user/form.vue');

export const routes = [
    {
        name: 'Main',
        path: '/',
        component: Main,
    },
	{
        name: 'Registration',
        path: '/registration',
        component: Registration,
    },
	{
        name: 'ProductIndex',
        path: '/product',
        component: ProductIndex,
    },
	{
        name: 'ProductForm',
        path: '/product/:status/:id',
        component: ProductForm,
    },
	{
        name: 'UserIndex',
        path: '/user',
        component: UserIndex,
    },
	{
        name: 'UserForm',
        path: '/user/:status/:id',
        component: UserForm,
    },
]