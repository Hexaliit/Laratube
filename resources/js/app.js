require('./bootstrap');

import {createApp} from 'vue'
import  * as VueRouter from 'vue-router'
import root from './components/root.vue'
import Swal from "sweetalert2/dist/sweetalert2";
import 'sweetalert2/dist/sweetalert2.css';
import AboutComponent from "./components/AboutComponent";
import login from "./components/auth/login";
//admin
import homeAdmin from "./components/admin/homeAdmin";
import adminAboutIndex from './components/admin/about/Index';
import adminServiceIndex from './components/admin/services/Index';
import adminSkillsIndex from './components/admin/skills/Index';
import adminEducationsIndex from './components/admin/educations/Index';
import adminExperienceIndex from './components/admin/experience/Index';
import adminProjectsIndex from './components/admin/projects/Index';
import adminProjectsNew from './components/admin/projects/New';
import adminProjectsEdit from './components/admin/projects/Edit';
import adminTestimonialsIndex from './components/admin/testimonials/Index';
import adminTestimonialsNew from './components/admin/testimonials/New';
import adminTestimonialsEdit from './components/admin/testimonials/Edit';
import adminMessagesIndex from './components/admin/messages/Index';
import adminUsersIndex from './components/admin/users/Index';
import adminUsersProfile from './components/admin/users/Profile';

const routes = [
    {
        path:'/',
        component:root,
        name: 'Home',
        meta: {
            requiresAuth: false
        }
    },
    {
        path:'/about',
        component:AboutComponent
    },
    {
        path:'/login',
        name : 'Login',
        component:login,
        meta: {
            requiresAuth: false
        }
    },
    {
        path:'/admin/home',
        component:homeAdmin,
        name: 'adminHome',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/about',
        component:adminAboutIndex,
        name: 'adminAbout',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/services',
        component:adminServiceIndex,
        name: 'adminService',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/skills',
        component:adminSkillsIndex,
        name: 'adminSkill',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/educations',
        component:adminEducationsIndex,
        name: 'adminEducation',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/experiences',
        component:adminExperienceIndex,
        name: 'adminExperience',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/projects',
        component:adminProjectsIndex,
        name: 'adminProject',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/projects/new',
        component:adminProjectsNew,
        name: 'adminProjectNew',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/projects/edit/:id',
        component:adminProjectsEdit,
        name: 'adminProjectEdit',
        meta: {
            requiresAuth:true
        },
        props : true,
    },
    {
        path:'/admin/testimonials',
        component:adminTestimonialsIndex,
        name: 'adminTestimonial',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/testimonials/new',
        component:adminTestimonialsNew,
        name: 'adminTestimonialNew',
        meta: {
            requiresAuth:true
        }
    },
    {
        path:'/admin/testimonials/edit/:id',
        component:adminTestimonialsEdit,
        name: 'adminTestimonialEdit',
        meta: {
            requiresAuth:true
        },
        props : true,
    },
    {
        path:'/admin/messages',
        component:adminMessagesIndex,
        name: 'adminMessages',
        meta: {
            requiresAuth:true
        },
    },
    {
        path:'/admin/users',
        component:adminUsersIndex,
        name: 'adminUsers',
        meta: {
            requiresAuth:true
        },
    },
    {
        path:'/admin/users/profile',
        component:adminUsersProfile,
        name: 'adminUsersProfile',
        meta: {
            requiresAuth:true
        },
    },
]

const router = VueRouter.createRouter({
    history : VueRouter.createWebHistory('/'),
    routes,
})

router.beforeEach((to,from) => {
    if(to.meta.requiresAuth && !localStorage.getItem('token')){
        return { name : 'Login'}
    }
    if(to.meta.requiresAuth === false && localStorage.getItem('token')){
        return { name : 'adminHome'}
    }
})

const app = createApp({})

app.use(router)

app.component('root' , root)

app.mount('#app')

window.Swal = Swal

const toast = Swal.mixin({
    toast : true,
    position : 'top-end',
    sowConfirmButton : false ,
    timer : 3000,
    timeProgressBar : true
})

window.toast = toast

