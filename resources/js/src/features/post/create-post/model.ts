import { computed, ref } from 'vue'
import { defineStore } from 'pinia'

export const useCreatePostModel = defineStore('create-post', () => {
    // store
    const text = ref<string>('')
    const retweet_post_id = ref<number | null>(null)
    const comment_for_post_id = ref<number | null>(null)

    // getters
    const getText = computed(() => {
        return text.value
    })

    const getFormattedText = computed(() => {
        return text.value.replace(/\n+/g, '\n\n')
    })

    const getRetweetPostId = computed(() => {
        return retweet_post_id.value
    })

    const getCommentForPostId = computed(() => {
        return comment_for_post_id.value
    })

    // actions
    function setText(value: string) {
        text.value = value
    }

    function setRetweetPostId(value: number | null) {
        retweet_post_id.value = value
    }

    function setCommentForPostId(value: number | null) {
        comment_for_post_id.value = value
    }

    return {
        getText,
        getFormattedText,
        getRetweetPostId,

        getCommentForPostId,
        setCommentForPostId,

        setText,
        setRetweetPostId
    }
})
