import { createRouter, createWebHistory } from 'vue-router';

import Admin from '../../components/layouts/Admin.vue';

import Home from '../../components/pages/Home.vue';
import Users from '../../components/pages/Users.vue';
import Teams from '../../components/pages/Teams.vue';
import TeamEdit from '../../components/pages/TeamEdit.vue';
import Stations from '../../components/pages/Stations.vue';
import Results from '../../components/pages/Results.vue';
import ResultEdit from '../../components/pages/ResultEdit.vue';
import Evaluation from '../../components/pages/Evaluation.vue';
import Settings from '../../components/pages/Settings.vue';
import AdminSettings from '../../components/pages/AdminSettings.vue';
import Login from '../../components/pages/Login.vue';

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/admin', component: Admin, name: 'admin', redirect: { name: 'showDashboard' }, children: [
            {path: 'dashboard', component: Home, name: 'showDashboard'},
            {path: 'users', component: Users, name: 'showUsers'},
            {path: 'teams', component: Teams, name: 'showTeams'},
            {path: 'team/add', component: TeamEdit, name: 'addTeam', props: { 'data-mode': 'add' }},
            {path: 'team/:id', component: TeamEdit, name: 'editTeam', props: { 'data-mode': 'edit' }},
            {path: 'stations', component: Stations, name: 'showStations'},
            {path: 'station/:id', component: Stations, name: 'showStation'},
            {path: 'results', component: Results, name: 'showResults'},
            {path: 'result/:id', component: ResultEdit, name: 'editResult'},
            {path: 'evaluation', component: Evaluation, name: 'showEvaluation'},
            {path: 'settings', component: Settings, name: 'showSettings'},
            {path: 'admin', component: AdminSettings, name: 'showAdminSettings'}
        ]},
        {path: '/logout', component: Login, name: 'showLogin'}

    ]
});