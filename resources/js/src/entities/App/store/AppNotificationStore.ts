import { computed, ref } from 'vue'
import { defineStore } from 'pinia'

interface INotification {
    id: number
    text: string
    type: 'danger' | 'success'
}

export const useAppNotificationStore = defineStore('app-notification', () => {
    // store
    const nextNotificationId = ref<number>(0)
    const notifications = ref<INotification[]>([])

    // getters
    const getNotifications = computed(() => {
        return notifications.value
    })

    // actions
    const addNotification = (text: string, type: 'success' | 'danger') => {
        notifications.value.push({
            id: nextNotificationId.value,
            text,
            type
        })

        nextNotificationId.value = nextNotificationId.value + 1
    }

    const deleteNotification = (id: number) => {
        notifications.value = notifications.value.filter(item => item.id !== id)
    }

    return {
        getNotifications,

        addNotification,
        deleteNotification
    }
})
