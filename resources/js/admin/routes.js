// News
import NewsIndex from '@/components/news/Index.vue';
import NewsCreate from '@/components/news/Create.vue';
import NewsEdit from '@/components/news/Edit.vue';

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

// Lectures
import LectureIndex from '@/components/lecture/Index.vue';
import LectureCreate from '@/components/lecture/Create.vue';
import LectureEdit from '@/components/lecture/Edit.vue';

// Categories
import CategoryIndex from '@/components/category/Index.vue';
import CategoryCreate from '@/components/category/Create.vue';
import CategoryEdit from '@/components/category/Edit.vue';

// Category Types
import CategoryTypeIndex from '@/components/categoryType/Index.vue';
import CategoryTypeCreate from '@/components/categoryType/Create.vue';
import CategoryTypeEdit from '@/components/categoryType/Edit.vue';

// Projects
import ProjectIndex from '@/components/project/Index.vue';
import ProjectCreate from '@/components/project/Create.vue';
import ProjectEdit from '@/components/project/Edit.vue';

// Project Grids
import ProjectGridIndex from '@/components/project/grid/Index.vue';

// Static content
import ContentIndex from '@/components/content/Index.vue';
import ContentCreate from '@/components/content/Create.vue';
import ContentEdit from '@/components/content/Edit.vue';

// Masonry
import HomeGridIndex from '@/components/home/Index.vue';

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

    // News
    {
        name: 'news',
        path: '/admin/news',
        component: NewsIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'news-create',
        path: '/admin/news/create',
        component: NewsCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'news-edit',
        path: '/admin/news/edit/:id',
        component: NewsEdit,
        meta: { requiresAuth: true },
    },
    {
        name: 'home',
        path: '/admin/home',
        component: HomeGridIndex,
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

    // Lectures
    {
        name: 'lectures',
        path: '/admin/lectures',
        component: LectureIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'lecture-create',
        path: '/admin/lecture/create',
        component: LectureCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'lecture-edit',
        path: '/admin/lecture/edit/:id',
        component: LectureEdit,
        meta: { requiresAuth: true },
    },

    // Categories
    {
        name: 'categories',
        path: '/admin/categories',
        component: CategoryIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'category-create',
        path: '/admin/category/create',
        component: CategoryCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'category-edit',
        path: '/admin/category/edit/:id',
        component: CategoryEdit,
        meta: { requiresAuth: true },
    },

    // Category Types
    {
        name: 'category-types',
        path: '/admin/types',
        component: CategoryTypeIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'category-type-create',
        path: '/admin/type/create',
        component: CategoryTypeCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'category-type-edit',
        path: '/admin/type/edit/:id',
        component: CategoryTypeEdit,
        meta: { requiresAuth: true },
    },

    // Projects
    {
        name: 'projects',
        path: '/admin/projects',
        component: ProjectIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'project-create',
        path: '/admin/project/create',
        component: ProjectCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'project-edit',
        path: '/admin/project/edit/:id',
        component: ProjectEdit,
        meta: { requiresAuth: true },
    },
    {
        name: 'project-grids',
        path: '/admin/project/grid/:id',
        component: ProjectGridIndex,
        meta: { requiresAuth: true },
    },

    // Content
    {
        name: 'contents',
        path: '/admin/contents',
        component: ContentIndex,
        meta: { requiresAuth: true },
    },
    {
        name: 'content-create',
        path: '/admin/content/create',
        component: ContentCreate,
        meta: { requiresAuth: true },
    },
    {
        name: 'content-edit',
        path: '/admin/content/edit/:id',
        component: ContentEdit,
        meta: { requiresAuth: true },
    },
];

export default routes