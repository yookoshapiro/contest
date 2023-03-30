import { defineStore } from 'pinia';

export enum AlertType {

    alert,
    confirm,
    custom

}

interface PromiseCallback
{
    (item: any): void;
}

export interface Alert {

    type?: AlertType,
    title?: string,
    text?: string

}

interface AlertInternal extends Alert {

    active: boolean,
    resolve: PromiseCallback,
    reject: PromiseCallback

}

export const AlertStore = defineStore('alert', {

    state: () => ({

        alert: {
            active: false,
            resolve: () => {},
            reject: () => {}
        } as AlertInternal

    }),

    actions: {

        async set(alert: Alert = {}): Promise<any>
        {

            this.alert.active = true;
            this.alert.type = (typeof alert.type === "undefined" ? AlertType.alert : alert.type);

            if (typeof alert.title === "string") {
                this.alert.title = alert.title;
            }

            if (typeof alert.text === "string") {
                this.alert.text = alert.text;
            }

            return new Promise((resolve: PromiseCallback, reject: PromiseCallback) => {

                this.alert.resolve = resolve;
                this.alert.reject = reject;

            }).finally(() => {
               this.unset();
            });

        },


        unset(): void
        {

            this.alert.active = false;
            this.alert.resolve = () => {};
            this.alert.reject = () => {};

            delete this.alert.type;
            delete this.alert.title;
            delete this.alert.text;

        }

    }

});