// Posts
import PostIndex from '@/components/posts/Index.vue';
import PostCreate from '@/components/posts/Create.vue';
import PostEdit from '@/components/posts/Edit.vue';

// Jobs
import JobIndex from '@/components/jobs/Index.vue';
import JobCreate from '@/components/jobs/Create.vue';
import JobEdit from '@/components/jobs/Edit.vue';

// Team
import TeamIndex from '@/components/team/Index.vue';
import TeamCreate from '@/components/team/Create.vue';
import TeamEdit from '@/components/team/Edit.vue';

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

    // Jobs
    {
        name: 'jobs',
        path: '/admin/jobs',
        component: JobIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'job-create',
        path: '/admin/job/create',
        component: JobCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'job-edit',
        path: '/admin/jobs/edit/:id',
        component: JobEdit,
        meta: { requiresAuth: true },
    },

    // Team
    {
        name: 'team',
        path: '/admin/team',
        component: TeamIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'team-create',
        path: '/admin/team/create',
        component: TeamCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'team-edit',
        path: '/admin/team/edit/:id',
        component: TeamEdit,
        meta: { requiresAuth: true },
    },
];

export default routes