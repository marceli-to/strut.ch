// Posts
import PostIndexComponent from '@/components/posts/PostIndexComponent.vue';
import PostCreateComponent from '@/components/posts/PostCreateComponent.vue';
import PostEditComponent from '@/components/posts/PostEditComponent.vue';

// Masonry
import MasonryIndexComponent from '@/components/masonry/MasonryIndexComponent.vue';

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
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardComponent,
        meta: { requiresAuth: true },
    },
    {
        path: '/login',
        name: 'login',
        component: LoginComponent
    },
    {
        path: '/logout',
        name: 'logout',
        component: LogoutComponent
    },
    {
        name: 'posts',
        path: '/posts',
        component: PostIndexComponent,
        meta: { requiresAuth: true },
    },
    {
        name: 'post-create',
        path: '/post/create',
        component: PostCreateComponent,
        meta: { requiresAuth: true },
    },
    {
        name: 'post-edit',
        path: '/post/edit/:id',
        component: PostEditComponent,
        meta: { requiresAuth: true },
    },
    {
        name: 'masonry',
        path: '/masonry',
        component: MasonryIndexComponent,
        meta: { requiresAuth: true },
    },
];

export default routes