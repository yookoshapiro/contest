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
    text: string,
    icon?: string,
    timeout?: number

}

export const DefaultNotificationIcon = new Map<NotificationType, string>([
    [NotificationType.warning, 'icon-error-outline'],
    [NotificationType.error, 'icon-dangerous'],
    [NotificationType.success, 'icon-check_circle'],
    [NotificationType.info, 'icon-circle_notifications']
]);

export const NotificationsStore = defineStore('notifications', {

    state: () => ({
        notifications: new Map<number, Notification>
    }),

    actions: {

        add(notification: Notification)
        {

            if (typeof notification.timeout === "undefined") {
                notification.timeout = 10000;
            }

            if (typeof notification.icon === "undefined") {
                notification.icon = DefaultNotificationIcon.get( notification.type );
            }

            let timestamp = Date.now();
            this.notifications.set(timestamp, notification);

            setTimeout(() => {
                this.notifications.delete(timestamp);
            }, notification.timeout);

        },

        remove(timestamp: number) {
            this.notifications.delete(timestamp);
        }

    }

});