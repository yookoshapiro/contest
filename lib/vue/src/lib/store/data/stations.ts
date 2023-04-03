import { defineStore } from 'pinia';
import { AxiosResponse } from 'axios';
import api from '../../api/Api';

export const stationsStore = defineStore('stations', {

    state: () => ({
        stations: Array()
    }),

    actions:
        {

            load: function() {
                api.list('station').then((response) => {
                    this.stations = response.data.data;
                });
            }

        }

});