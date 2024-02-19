<script setup lang="ts">
import { computed, inject } from 'vue'

import { useCreatePost } from '@/shared/api/hook/posts/useCreatePost'
import XButton from '@/shared/ui/XButton/XButton.vue'
import FillableCircle from '@/widgets/PostCreator/FillableCircle.vue'
import { PostBodyDefaultValue } from '@/widgets/PostCreator/types'

const emit = defineEmits(['publish'])

const postBody = inject('postBody', PostBodyDefaultValue)

const formIsValid = computed(() => {
    return postBody.text.length
})

const { mutate: createPost } = useCreatePost()

function publish() {
    const formattedText = postBody.text.replace(/\n+/g, '\n\n')

    createPost({
        text: formattedText,
    })
    emit('publish')
}
</script>

<template>
    <div class="footer">
        <div class="footer-right-block">
            <div
                v-if="postBody.text.length"
                class="progress"
            >
                <fillable-circle
                    :value="postBody.text.length"
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
