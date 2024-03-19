<script setup lang="ts">
import { computed, PropType } from 'vue'
import { useRouter } from 'vue-router'
import { useUserStore } from '@/entities/User/store'
import UserNames from '@/entities/User/ui/UserNames.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import PostBody from '@/entities/Post/ui/PostBody.vue'
import { IPost } from '@/shared/api/types/models/Post'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    }
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
                <span class="separator">·</span>
                <span>7 ч.</span>
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
}

.header {
    display: flex;
    align-items: center;
    color: rgb(113, 118, 123);
    line-height: 19px;
    font-size: 14px;
    font-weight: 400;
}

.separator {
    margin: 0 5px;
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
