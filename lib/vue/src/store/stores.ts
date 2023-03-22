import { defineStore } from 'pinia';
import axios from 'axios';

export const teamsStore = defineStore('teams', {

    state: () => ({
        teams: Array()
    }),

    actions: {
        load: function () {
            axios.get('http://localhost/api/teams').then((response) => {
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
        load: function() {
            axios.get('http://localhost/api/stations').then((response) => {
                this.stations = response.data.data;
            });
        }
    }

});