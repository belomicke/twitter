<script setup lang="ts">
import { computed, PropType } from 'vue'
import { useCreatePost } from '../hook/useCreatePost'
import XFillableCircle from '@/shared/ui/XFillableCircle/XFillableCircle.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import { CreatePostDTO } from '@/features/post/create-post/types/CreatePostDTO'

const props = defineProps({
    createPostData: {
        type: Object as PropType<CreatePostDTO>,
        required: true,
    },
})

const emit = defineEmits(['publish'])

const formIsValid = computed(() => {
    const data = props.createPostData

    if (!data) return

    return data.text.length
})

const { mutate: createPost } = useCreatePost()

function publish() {
    createPost(props.createPostData)
    emit('publish')
}
</script>

<template>
    <div
        v-if="createPostData"
        class="footer"
    >
        <div class="footer-right-block">
            <div
                v-if="createPostData.text.length"
                class="progress"
            >
                <x-fillable-circle
                    :value="createPostData.text.length"
                    :max-value="280"
                />
            </div>
            <x-button
                class="publish"
                :disabled="!formIsValid"
                type="primary"
                rounded
                @click="publish"
            >
                Опубликовать
            </x-button>
        </div>
    </div>
</template>

<style scoped>
.footer {
    display: flex;
    align-items: center;
    width: 100%;
    padding-top: 10px;
    border-top: 1px solid var(--x-border-color);
}

.footer-right-block {
    display: flex;
    align-items: center;
    grid-gap: 10px;
    margin-left: auto;
}

.publish {
    display: flex;
}
</style>
