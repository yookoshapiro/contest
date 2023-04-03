import { defineStore } from 'pinia';
import { AxiosResponse } from 'axios';
import api from '../api/Api';

interface Auth {

    token?: string,
    expired: Date

}

export const AuthStore = defineStore('auth', {

    state: () => ({
        auth: {
            token: undefined,
            expired: new Date(0)
        } as Auth
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

        logout(): void {

        }

    }

});