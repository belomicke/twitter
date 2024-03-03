<script setup lang="ts">

import { useUserStore } from '@/entities/User/store'
import { storeToRefs } from 'pinia'
import { computed } from 'vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import UserNames from '@/entities/User/ui/UserNames.vue'
import { useRouter } from 'vue-router'

const props = defineProps({
    id: {
        type: Number,
        required: true,
    },
})

const emit = defineEmits(['click'])

const router = useRouter()

const userStore = useUserStore()
const { getUserById } = storeToRefs(userStore)

const user = computed(() => {
    return getUserById.value(props.id)
})

function clickHandler() {
    router.push(`/profile/${user.value?.username}`)
    emit('click')
}

</script>

<template>
    <div
        v-if="user"
        class="user-list-item"
        @click="clickHandler"
    >
        <user-avatar
            :username="user.username"
            :size="40"
            rounded
        />
        <user-names :user="user" />
    </div>
</template>

<style scoped>
.user-list-item {
    display: flex;
    grid-gap: 10px;
    padding: 10px;
    width: 100%;
    cursor: pointer;
    transition: background-color .15s;
}

.user-list-item:hover {
    background-color: rgba(255, 255, 255, .1);
}
</style>
