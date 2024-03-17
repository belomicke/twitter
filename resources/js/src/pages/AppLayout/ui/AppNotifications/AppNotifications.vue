<script setup lang="ts">
import { computed, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { useAppNotificationStore } from '@/entities/App/store/AppNotificationStore'

const appNotificationStore = useAppNotificationStore()
const { getNotifications } = storeToRefs(appNotificationStore)

const notifications = computed(() => {
    return getNotifications.value
})

const translateYValue = (index: number) => {
    return `(-100% - 10px) * ${index}`
}

watch(() => notifications.value, (newNotificationList) => {
    const lastNotification = newNotificationList.at(-1)

    if (lastNotification) {
        deleteNotificationAfterDelay(lastNotification.id)
    }
}, { deep: true })

function deleteNotificationAfterDelay(id: number) {
    setTimeout(() => appNotificationStore.deleteNotification(id), 5000)
}
</script>

<template>
    <div class="wrapper">
        <div
            v-for="(notification, index) in notifications"
            :key="notification.id"
            class="notification"
            data-index="1"
            :style="{
                'transform': `translateY(calc(${translateYValue(index)}))`
            }"
            :class="{
                'success': notification.type === 'success',
                'danger': notification.type === 'danger',
            }"
        >
            {{ notification.text }}
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    position: fixed;
    width: 100vw;
    height: 100vh;
    pointer-events: none;
    top: 0;
    left: 0;
    z-index: 200000;
}

.notification {
    padding: 10px 20px;
    max-width: 320px;
    position: absolute;
    background-color: rgba(var(--color), .1);
    color: rgb(var(--color));
    font-weight: 700;
    bottom: 10px;
    right: 25px;
    border-radius: 5px;
    overflow: hidden;
}

.notification::after {
    content: "";
    width: 5px;
    height: 100%;
    position: absolute;
    background-color: rgb(var(--color));
    top: 0;
    left: 0;
}

.notification.success {
    --color: 105, 195, 60;
}

.notification.danger {
    --color: 244, 33, 46;
}
</style>
