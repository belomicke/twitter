<script setup lang="ts">
import { computed, PropType } from 'vue'
import { storeToRefs } from 'pinia'
import PostCreator from '@/features/post/create-post/ui/PostCreator.vue'
import { useUserStore } from '@/entities/User/store'
import { IPost } from '@/shared/api/types/models/Post'
import UserUsername from '@/entities/User/ui/UserUsername.vue'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    }
})

const userStore = useUserStore()
const { getUserById } = storeToRefs(userStore)

const author = computed(() => {
    return getUserById.value(props.post.user_id)
})
</script>

<template>
    <div
        v-if="post && author"
        class="comment-creator"
    >
        <div class="extra-info">
            В ответ
            <user-username :username="author.username" />
        </div>
        <post-creator
            placeholder="Опубликовать ответ"
            :in-reply-to-post-id="post.id"
            submit-button-text="Ответить"
            :height="30"
            no-border-in-footer
        />
    </div>
</template>

<style scoped>
.comment-creator {
    display: flex;
    flex-direction: column;
    grid-gap: 5px;
    padding: 5px 15px 0;
    border-bottom: 1px solid var(--x-border-color);
}

.extra-info {
    padding-left: 50px;
    color: rgb(113, 118, 123);
    line-height: 19px;
    word-wrap: break-word;
    font-size: 14px;
    font-weight: 400;
}
</style>
