import { createRouter, createWebHistory } from 'vue-router';

import AdminLayout from '../../components/layouts/Admin.vue';
import DefaultLayout from '../../components/layouts/Default.vue';

import Home from '../../components/pages/Home.vue';
import Users from '../../components/pages/Users.vue';
import Stations from '../../components/pages/Stations.vue';
import Results from '../../components/pages/Results.vue';
import ResultEdit from '../../components/pages/ResultEdit.vue';
import Evaluation from '../../components/pages/Evaluation.vue';
import Settings from '../../components/pages/Settings.vue';
import AdminSettings from '../../components/pages/AdminSettings.vue';
import Login from '../../components/pages/Login.vue';

import { default as TeamList } from '../../components/pages/team/List.vue';
import { default as TeamEdit } from '../../components/pages/team/Edit.vue';

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/', redirect: { name: 'showDashboard' }},
        {path: '/admin', component: AdminLayout, redirect: { name: 'showDashboard' }, children: [
            {path: 'dashboard', component: Home, name: 'showDashboard'},
            {path: 'user', component: Users, name: 'showUsers'},
            {path: 'team', component: DefaultLayout, children: [
                {path: '', component: TeamList, name: 'showTeams'},
                {path: 'add', component: TeamEdit, name: 'addTeam'},
                {path: ':id', component: TeamEdit, name: 'editTeam'}
            ]},
            {path: 'station', component: Stations, name: 'showStations'},
            {path: 'station/:id', component: Stations, name: 'showStation'},
            {path: 'result', component: Results, name: 'showResults'},
            {path: 'result/:id', component: ResultEdit, name: 'editResult'},
            {path: 'evaluation', component: Evaluation, name: 'showEvaluation'},
            {path: 'setting', component: Settings, name: 'showSettings'},
            {path: 'admin', component: AdminSettings, name: 'showAdminSettings'}
        ]},
        {path: '/logout', component: Login, name: 'showLogin'}

    ]
});