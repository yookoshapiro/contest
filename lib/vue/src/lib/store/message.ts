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

    created_at: Date

}

export const systemMessagesStore = defineStore('system-message', {

    state: () => ({
        messages: Array<SystemMessageInternal>(),
        time: new Date()
    }),

    actions: {

        add(message: SystemMessage)
        {

            this.messages.push({
                type: message.type,
                title: message.title,
                text: message.text,
                created_at: new Date()
            });

        },

        remove(index: number) {
            this.messages.splice(index, 1);
        }

    }

});