<script setup lang="ts">

import XButton from '@/shared/ui/XButton/XButton.vue'
import { useUserStore } from '@/entities/User/store'
import { storeToRefs } from 'pinia'
import { computed, ref, watch } from 'vue'
import _ from 'lodash'
import { useFollowUser } from '@/shared/api/hook/users/useFollowUser'
import { useUnfollowUser } from '@/shared/api/hook/users/useUnfollowUser'

const props = defineProps({
    username: {
        type: String,
        required: true,
    },
})

const { mutate: follow } = useFollowUser()
const { mutate: unfollow } = useUnfollowUser()


const userStore = useUserStore()
const { getUserByUsername } = storeToRefs(userStore)

const user = computed(() => {
    return getUserByUsername.value(props.username)
})

const isFollowing = ref<boolean | undefined>(user.value?.following ?? undefined)

watch(() => user.value, (newValue) => {
    if (!newValue) return
    console.log(newValue)
    isFollowing.value = newValue.following
})

const ButtonType = computed(() => {
    return isFollowing.value ? 'default' : 'info'
})

const ButtonText = computed(() => {
    return isFollowing.value ? 'Перестать читать' : 'Читать'
})

const debouncedFunction = _.debounce((value: boolean) => {
    if (!user.value) return
    if (value === user.value.following) return

    user.value.following = value

    if (value) {
        follow(user.value.username)
    } else {
        unfollow(user.value.username)
    }
}, 500)

function clickHandler() {
    const value = !isFollowing.value
    isFollowing.value = value
    debouncedFunction(value)
}
</script>

<template>
    <x-button
        :type="ButtonType"
        rounded
        @click="clickHandler"
    >
        {{ ButtonText }}
    </x-button>
</template>

<style scoped>

</style>
