import { defineStore } from 'pinia';
import axios from 'axios';
import { AxiosResponse } from 'axios';
import api from '../api/Api';

export const teamsStore = defineStore('teams', {

    state: () => ({
        teams: Array()
    }),

    actions: {
        load: function ()
        {

            api.teams.get().then((response: AxiosResponse<any>) => {
                this.teams = response.data.data;
            });

        }
    }

});

export const stationsStore = defineStore('stations', {

    state: () => ({
        stations: Array()
    }),

    actions: {
        load: function()
        {

            api.stations.get().then((response) => {
                this.stations = response.data.data;
            });

        }
    }

});