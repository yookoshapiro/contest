import { createRouter, createWebHistory } from 'vue-router';

import Admin from '../src/components/layouts/Admin.vue';

import Home from '../src/components/pages/Home.vue';
import Users from '../src/components/pages/Users.vue';
import Teams from '../src/components/pages/Teams.vue';
import TeamEdit from '../src/components/pages/TeamEdit.vue';
import Stations from '../src/components/pages/Stations.vue';
import Results from '../src/components/pages/Results.vue';
import ResultEdit from '../src/components/pages/ResultEdit.vue';
import Evaluation from '../src/components/pages/Evaluation.vue';
import Settings from '../src/components/pages/Settings.vue';
import AdminSettings from '../src/components/pages/AdminSettings.vue';
import Login from '../src/components/pages/Login.vue';

export const router = createRouter({
    history: createWebHistory(),
    routes: [
        {path: '/admin', component: Admin, name: 'admin', redirect: { name: 'showDashboard' }, children: [
            {path: 'dashboard', component: Home, name: 'showDashboard'},
            {path: 'users', component: Users, name: 'showUsers'},
            {path: 'teams', component: Teams, name: 'showTeams'},
            {path: 'team/add', component: TeamEdit, name: 'addTeam'},
            {path: 'team/:id/edit', component: TeamEdit, name: 'editTeam'},
            {path: 'stations', component: Stations, name: 'showStations'},
            {path: 'station/:id', component: Stations, name: 'showStation'},
            {path: 'results', component: Results, name: 'showResults'},
            {path: 'result/:id/edit', component: ResultEdit, name: 'editResult'},
            {path: 'evaluation', component: Evaluation, name: 'showEvaluation'},
            {path: 'settings', component: Settings, name: 'showSettings'},
            {path: 'admin', component: AdminSettings, name: 'showAdminSettings'}
        ]},
        {path: '/logout', component: Login, name: 'showLogin'}

    ]
});