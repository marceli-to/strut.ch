// Posts
import PostIndex from '@/components/posts/Index.vue';
import PostCreate from '@/components/posts/Create.vue';
import PostEdit from '@/components/posts/Edit.vue';

// Masonry
import GridIndex from '@/components/home/GridIndex.vue';

// Page
import PageComponent from '@/layout/Page.vue';

// Auth 
import LoginComponent from '@/components/auth/LoginComponent.vue';
import LogoutComponent from '@/components/auth/LogoutComponent.vue';

const routes = [
    {
        path: '/',
        redirect: { name: 'login' }
    },
    {
        path: '/admin',
        name: 'admin',
        component: PageComponent,
        meta: { requiresAuth: true },
    },
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: PageComponent,
        meta: { requiresAuth: true },
    },
    {
        path: '/admin/login',
        name: 'login',
        component: LoginComponent
    },
    {
        path: '/admin/logout',
        name: 'logout',
        component: LogoutComponent
    },
    {
        name: 'posts',
        path: '/admin/posts',
        component: PostIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'post-create',
        path: '/admin/post/create',
        component: PostCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'post-edit',
        path: '/admin/post/edit/:id',
        component: PostEdit,
        meta: { requiresAuth: true },
    },
    {
        name: 'masonry',
        path: '/admin/masonry',
        component: GridIndex,
        meta: { requiresAuth: true },
    },
];

export default routes