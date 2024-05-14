<script setup lang="ts">

import XDropdownIconButton, { XDropdownIconButtonOption } from '@/shared/ui/XDropdownIconButton/XDropdownIconButton.vue'
import { computed, PropType, ref } from 'vue'
import { IPost } from '@/shared/api/types/models/Post'
import { useViewerStore } from '@/entities/Viewer/store'
import { storeToRefs } from 'pinia'
import { useUserStore } from '@/entities/User/store'
import { useUnfollowUser } from '@/features/user/follow-user/hook/useUnfollowUser'
import { useFollowUser } from '@/features/user/follow-user/hook/useFollowUser'
import { usePinPost, useUnpinPost } from '@/features/post/pin-post'
import DeletePostDialog from '@/features/post/delete-post/ui/DeletePostDialog.vue'
import { useAddPostToFavoriteList } from "@/features/post/favorite-post/hook/useAddPostToFavoriteList"
import { useRemovePostFromFavoriteList } from "@/features/post/favorite-post/hook/useRemovePostFromFavoriteList"

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    }
})

const viewerStore = useViewerStore()
const { getViewer } = storeToRefs(viewerStore)

const userStore = useUserStore()
const { getUserById } = storeToRefs(userStore)

const viewer = computed(() => {
    return getViewer.value
})

const viewerIsAuthor = computed(() => {
    return viewer.value?.id === props.post?.user_id
})

const author = computed(() => {
    if (!props.post) return undefined

    return getUserById.value(props.post.user_id)
})

const { mutate: pinPost } = usePinPost()
const { mutate: unpinPost } = useUnpinPost()

const { mutate: addToFavorite } = useAddPostToFavoriteList()
const { mutate: removeFromFavorite } = useRemovePostFromFavoriteList()

const optionsUsedIfViewerIsAnAuthorOfThisPost = computed((): XDropdownIconButtonOption[] => {
    if (!props.post) return []

    const isPinned = props.post.is_pinned
    const isFavorite = props.post.is_favorite

    return [
        {
            icon: 'trash-bin',
            label: 'Удалить',
            action: deletePost,
            style: 'color: var(--x-color-danger) !important;'
        },
        {
            icon: 'edit',
            label: 'Изменить',
            action: () => console.log('edit')
        },
        {
            icon: 'pin',
            label: isPinned ? 'Открепить от профиля' : 'Закрепить в профиле',
            action: () => isPinned ? unpinPost(props.post.id) : pinPost(props.post.id)
        },
        {
            icon: 'favorite',
            label: isFavorite ? 'Убрать из избранного в вашем профиле' : 'Добавить в избранное в вашем профиле',
            action: () => isFavorite ? removeFromFavorite(props.post.id) : addToFavorite(props.post.id)
        }
    ]
})

const { mutate: unfollowHandler } = useUnfollowUser()
const { mutate: followHandler } = useFollowUser()

const optionsUsedIfViewerIsNotAnAuthorOfThisPost = computed((): XDropdownIconButtonOption[] => {
    if (!author.value) return []

    const authorsUsername = author.value.username

    if (author.value.following) {
        return [
            {
                icon: 'unfollow',
                label: `Перестать читать @${author.value.username}`,
                action: () => unfollowHandler(authorsUsername)
            }
        ]
    }

    return [
        {
            icon: 'follow',
            label: `Начать читать @${author.value.username}`,
            action: () => followHandler(authorsUsername)
        }
    ]
})

const options = computed(() => {
    return viewerIsAuthor.value ? optionsUsedIfViewerIsAnAuthorOfThisPost.value : optionsUsedIfViewerIsNotAnAuthorOfThisPost.value
})

const deletePostDialogRef = ref<InstanceType<typeof DeletePostDialog> | null>(null)

function deletePost() {
    if (!deletePostDialogRef.value) return

    deletePostDialogRef.value.open()
}
</script>

<template>
    <template v-if="post">
        <x-dropdown-icon-button
            icon="other"
            :options="options"

            background-color="transparent"
        />
        <delete-post-dialog
            :id="post.id"
            ref="deletePostDialogRef"
        />
    </template>
</template>

<style scoped>

</style>
