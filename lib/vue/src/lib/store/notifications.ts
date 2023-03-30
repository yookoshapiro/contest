import { defineStore } from 'pinia';

export enum NotificationType {
    error = 'error',
    warning = 'warning',
    success = 'success',
    info = 'info'

}

export interface Notification
{

    type: NotificationType,
    title: string,
    text: string

}

interface NotificationInternal extends Notification
{

    created_at: number

}

export const NotificationsStore = defineStore('notifications', {

    state: () => ({
        messages: Array<NotificationInternal>() as Array<NotificationInternal>,
        time: new Date() as Date
    }),

    actions: {

        add(notification: Notification, timeout: number = 10000)
        {

            let timestamp = Date.now();

            this.messages.push({
                type: notification.type,
                title: notification.title,
                text: notification.text,
                created_at: timestamp
            });

            setTimeout(() => {
                this.remove( timestamp );
            }, timeout);

        },

        remove(timestamp: number)
        {

            let index = this.messages.findIndex(notification => notification.created_at === timestamp);

            if (index > -1) {
                this.messages.splice(index, 1);
            }

        }

    }

});