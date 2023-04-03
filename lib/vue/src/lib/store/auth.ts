import { defineStore } from 'pinia';
import { AxiosResponse } from 'axios';
import api from '../api/Api';
import { useLocalStorage } from "@vueuse/core";

export const AuthStore = defineStore('auth', {

    state: () => ({
        auth: useLocalStorage('auth', {
            token: undefined,
            expired: new Date(0)
        })
    }),

    actions: {

        login(login: string, password: string): Promise<any>
        {

            return api.login(login, password)
                .then((response: AxiosResponse<any>) => {

                    let data = response.data.data;

                    this.auth.token = data.token;
                    this.auth.expired = new Date( data.expired_at );

                    return response;
                });

        },

        logout(): Promise<any>
        {

            return api.logout(this.auth.token ?? '')
                .then((response: AxiosResponse) =>
                {

                    this.auth.token = undefined;
                    this.auth.expired = new Date(0);

                    return response;

                });

        }

    }

});