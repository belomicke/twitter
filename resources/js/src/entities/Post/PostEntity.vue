<script setup lang="ts">
import { computed, PropType } from 'vue'
import { useUserStore } from '@/entities/User/store'
import UserNames from '@/entities/User/ui/UserNames.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import { IPost } from '@/shared/api/types/models/Post'
import PostBody from '@/entities/Post/PostBody.vue'
import { useRouter } from 'vue-router'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true,
    },
})

const router = useRouter()

const userStore = useUserStore()

const author = computed(() => {
    if (!props.post) return

    return userStore.getUserById(props.post.user_id)
})

function clickHandler() {
    router.push(`/post/${props.post.id}`)
}
</script>

<template>
    <div
        v-if="author"
        class="post-entity"
        @click.stop="clickHandler"
    >
        <div class="avatar">
            <user-avatar
                :username="author.username"
                :size="40"
                rounded
            />
        </div>
        <div class="content">
            <div class="header">
                <user-names
                    :user="author"
                    inline
                    links
                />
            </div>
            <post-body
                :post="post"
                with-retweet
            />
            <div class="actions">
                <slot name="actions" />
            </div>
        </div>
    </div>
</template>

<style scoped>
.post-entity {
    display: flex;
    grid-gap: 10px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.15s;
}

.post-entity:hover {
    background-color: rgba(255, 255, 255, 0.03);
}

.content {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.actions {
    padding-top: 10px;
}
</style>
