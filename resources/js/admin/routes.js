// Posts
import PostIndexComponent from '@/components/posts/PostIndexComponent.vue';
import PostCreateComponent from '@/components/posts/PostCreateComponent.vue';
import PostEditComponent from '@/components/posts/PostEditComponent.vue';

// Masonry
import GridIndexComponent from '@/components/home/GridIndexComponent.vue';

// Dashboard
import DashboardComponent from '@/components/DashboardComponent.vue';

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
        component: DashboardComponent,
        meta: { requiresAuth: true },
    },
    {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: DashboardComponent,
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
        component: PostIndexComponent,
        meta: { requiresAuth: true },
    },
    {
        name: 'post-create',
        path: '/admin/post/create',
        component: PostCreateComponent,
        meta: { requiresAuth: true },
    },
    {
        name: 'post-edit',
        path: '/admin/post/edit/:id',
        component: PostEditComponent,
        meta: { requiresAuth: true },
    },
    {
        name: 'masonry',
        path: '/admin/masonry',
        component: GridIndexComponent,
        meta: { requiresAuth: true },
    },
];

export default routes