import { defineStore } from 'pinia';
import { AxiosResponse } from 'axios';
import api from '../api/Api';
import { useInfiniteScroll, useLocalStorage } from "@vueuse/core";

export const AuthStore = defineStore('auth', {

    state: () => ({
        auth: useLocalStorage('auth', {
            token: undefined
        })
    }),

    actions: {

        login(login: string, password: string): Promise<any>
        {

            return api.login(login, password)
                .then((response: AxiosResponse<any>) => {

                    this.auth.token = response.data.data.token;
                    return response;

                });

        },

        logout(): Promise<any>
        {

            return api.logout(this.auth.token ?? '')
                .then((response: AxiosResponse) =>
                {

                    this.auth.token = undefined;
                    return response;

                });

        },

        validate(): Promise<any>
        {

            if (this.auth.token === undefined)
            {

                return new Promise((resolve, reject) => {
                    reject();
                });

            }

            return api.validate().catch(() => {
                this.auth.token = undefined;
            });

        }

    }

});