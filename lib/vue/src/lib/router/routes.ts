import { createRouter, createWebHistory } from 'vue-router';

import AdminLayout from '../../components/layouts/Admin.vue';
import DefaultLayout from '../../components/layouts/Default.vue';

import Home from '../../components/pages/Home.vue';
import Users from '../../components/pages/Users.vue';
import Stations from '../../components/pages/Stations.vue';
import Results from '../../components/pages/Results.vue';
import Evaluation from '../../components/pages/Evaluation.vue';
import Settings from '../../components/pages/Settings.vue';
import AdminSettings from '../../components/pages/AdminSettings.vue';
import Login from '../../components/pages/Login.vue';

import Team from '../../components/pages/Team.vue';

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/', redirect: { name: 'dashboard' }},
        {path: '/admin', component: AdminLayout, redirect: { name: 'dashboard' }, children: [
            {path: 'dashboard', component: Home, name: 'dashboard'},
            {path: 'user', component: Users, name: 'user'},
            {path: 'team', component: Team, name: 'team'},
            {path: 'station', component: Stations, name: 'station'},
            {path: 'result', component: Results, name: 'result'},
            {path: 'evaluation', component: Evaluation, name: 'evaluation'},
            {path: 'setting', component: Settings, name: 'settings'},
            {path: 'admin', component: AdminSettings, name: 'admin-settings'}
        ]},
        {path: '/login', component: Login, name: 'login'},
        {path: '/logout', component: Login, name: 'logout'}

    ]
});