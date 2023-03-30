import { defineStore } from 'pinia';

export enum SystemMessageType {
    error = 'error',
    warning = 'warning',
    success = 'success',
    info = 'info'

}

export interface SystemMessage
{

    type: SystemMessageType,
    title: string,
    text: string

}

interface SystemMessageInternal extends SystemMessage
{

    created_at: number

}

export const systemMessagesStore = defineStore('system-message', {

    state: () => ({
        messages: Array<SystemMessageInternal>() as Array<SystemMessageInternal>,
        time: new Date() as Date
    }),

    actions: {

        add(message: SystemMessage, timeout: number = 10000)
        {

            let timestamp = Date.now();

            this.messages.push({
                type: message.type,
                title: message.title,
                text: message.text,
                created_at: timestamp
            });

            setTimeout(() => {
                this.remove( timestamp );
            }, timeout);

        },

        remove(timestamp: number)
        {

            let index = this.messages.findIndex(messages => messages.created_at === timestamp);

            if (index > -1) {
                this.messages.splice(index, 1);
            }

        }

    }

});