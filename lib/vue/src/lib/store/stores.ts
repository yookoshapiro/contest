import { defineStore } from 'pinia';
import { AxiosResponse } from 'axios';
import api from '../api/Api';

export const teamsStore = defineStore('teams', {

    state: () => ({
        teams: Array()
    }),

    actions: {
        load: function ()
        {

            api.list('team').then((response: AxiosResponse<any>) => {
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

            api.list('station').then((response) => {
                this.stations = response.data.data;
            });

        }
    }

});