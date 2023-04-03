import { defineStore } from 'pinia';

interface Auth {

    user?: string,
    token?: string

}

export const AuthStore = defineStore('auth', {

    state: () => ({
        auth: {
            user: undefined,
            token: undefined
        } as Auth
    }),

    actions: {



    }

});