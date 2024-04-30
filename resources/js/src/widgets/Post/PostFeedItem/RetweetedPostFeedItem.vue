<script setup lang="ts">
import { computed } from 'vue'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'
import PostFeedItemEntity from './PostFeedItemEntity.vue'
import { usePostStore } from '@/entities/Post/store'
import { useUserStore } from '@/entities/User/store'

const props = defineProps({
    id: {
        type: Number,
        required: true
    },
    withOptions: {
        type: Boolean,
        required: false,
        default: false
    }
})

const router = useRouter()

const postStore = usePostStore()
const { getPostById } = storeToRefs(postStore)

const userStore = useUserStore()
const { getUserById } = storeToRefs(userStore)

const post = computed(() => {
    return getPostById.value(props.id)
})

const author = computed(() => {
    if (!post.value) return undefined

    return getUserById.value(post.value.user_id)
})

function goToRetweeter() {
    const retweeter = author.value

    if (!retweeter) return

    router.push(`/profile/${retweeter.username}`)
}

</script>

<template>
    <post-feed-item-entity
        v-if="post && author"
        :id="id"
        :with-options="withOptions"
        :extra-status-options="{
            icon: 'retweet',
            text: `${author.name} сделал(-а) репост`,
            visible: true,
            withUnderline: true,
            action: goToRetweeter
        }"
    />
</template>

<style scoped>

</style>
