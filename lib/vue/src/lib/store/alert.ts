import { defineStore } from 'pinia';

export enum SystemAlertType {

    alert = 'alert',
    confirm = 'confirm',
    custom = 'custom'

}

interface Func<T,TResult>
{
    (item: T): TResult;
}

export const systemAlertStore = defineStore('system-alert', {

    state: () => ({
        active: false as boolean,
        type: SystemAlertType.confirm as SystemAlertType,
        title: '' as string,
        text: '' as string,
        resolve:  (() => {}) as Func<any, void>,
        reject: (() => {}) as Func<any, void>
    }),

    actions: {

        async set(type: SystemAlertType, title: string = '', text: string = ''): Promise<any>
        {

            this.active = true;
            this.type = type;
            this.title = title;
            this.text = text;

            return new Promise((resolve: Func<any, void>, reject: Func<any, void>) => {
                this.resolve = resolve;
                this.reject = reject;
            }).finally(() => {
               this.unset();
            });

        },


        unset(): void {
            this.active = false;
            this.resolve = (n: any) => {};
            this.reject = (n: any) => {};
        }

    }

});