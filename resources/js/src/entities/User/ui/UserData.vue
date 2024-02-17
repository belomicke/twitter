<script setup lang="ts">
import XLink from '@/shared/ui/XLink/XLink.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import { computed, PropType } from 'vue'
import IUser from '@/shared/api/types/models/User'
import moment from 'moment/moment'

const { user } = defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    }
})

const registrationDate = computed(() => {
    return moment(user?.created_at)
        .locale('ru')
        .format('MMMM YYYYг.')
})
</script>

<template>
    <div class="user-data" v-if="user">
        <div class="user-data-item" v-if="user.location">
            <x-icon
                icon="location"
                :size="20"
                color="rgb(113, 118, 123)"
            />
            {{ user.location }}
        </div>
        <div class="user-data-item" v-if="user.link">
            <x-icon
                icon="link"
                :size="20"
                color="rgb(113, 118, 123)"
            />
            <x-link :href="user.link"/>
        </div>
        <div class="user-data-item">
            <x-icon
                icon="calendar"
                :size="20"
                color="rgb(113, 118, 123)"
            />
            Регистрация: {{ registrationDate }}
        </div>
    </div>
</template>

<style scoped>
.user-data {
    display: flex;
    flex-direction: column;
    grid-gap: 5px;
}

.user-data-item {
    display: flex;
    align-items: center;
    grid-gap: 5px;
    color: rgb(113, 118, 123);
}
</style>
