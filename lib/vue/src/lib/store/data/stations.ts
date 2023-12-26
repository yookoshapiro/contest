import { defineStore } from 'pinia';
import { AxiosResponse } from 'axios';
import api from '../../api/Api';

export const stationsStore = defineStore('stations', {

    state: () => ({
        stations: Array()
    }),

    actions: {

        async load(): Promise<any>
        {

            return api.list('station')
                .then((response) => {
                    this.stations = response.data.data;
                });

        },

    }

});