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

// Books
import BookIndex from '@/components/books/Index.vue';
import BookCreate from '@/components/books/Create.vue';
import BookEdit from '@/components/books/Edit.vue';

// Press
import PressIndex from '@/components/press/Index.vue';
import PressCreate from '@/components/press/Create.vue';
import PressEdit from '@/components/press/Edit.vue';

// Awards
import AwardIndex from '@/components/award/Index.vue';
import AwardCreate from '@/components/award/Create.vue';
import AwardEdit from '@/components/award/Edit.vue';

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

    // Books
    {
        name: 'books',
        path: '/admin/books',
        component: BookIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'book-create',
        path: '/admin/book/create',
        component: BookCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'book-edit',
        path: '/admin/book/edit/:id',
        component: BookEdit,
        meta: { requiresAuth: true },
    },

    // Press
    {
        name: 'press',
        path: '/admin/press',
        component: PressIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'press-create',
        path: '/admin/press/create',
        component: PressCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'press-edit',
        path: '/admin/press/edit/:id',
        component: PressEdit,
        meta: { requiresAuth: true },
    },

    // Awards
    {
        name: 'awards',
        path: '/admin/awards',
        component: AwardIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'award-create',
        path: '/admin/award/create',
        component: AwardCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'award-edit',
        path: '/admin/awards/edit/:id',
        component: AwardEdit,
        meta: { requiresAuth: true },
    },
];

export default routes