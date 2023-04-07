import { defineStore } from 'pinia';
import { AxiosResponse } from 'axios';
import api from '../api/Api';
import { useInfiniteScroll, useLocalStorage } from "@vueuse/core";

interface UserData {

    small_navigation?: boolean

}

export const AuthStore = defineStore('auth', {

    state: () => ({
        auth: useLocalStorage('auth', {
            token: undefined
        }),

        data: useLocalStorage('data', {} as UserData)
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

        },


        setUserData(data: UserData): void {
            this.data = {...this.data, ...data};
        }

    }

});