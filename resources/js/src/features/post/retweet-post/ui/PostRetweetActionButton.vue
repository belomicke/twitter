<script setup lang="ts">

import XIconButton from '@/shared/ui/XIconButton/XIconButton.vue'
import { computed, PropType, ref } from 'vue'
import { IPost } from '@/shared/api/types/models/Post'
import XDropdown from '@/shared/ui/XDropdown/XDropdown.vue'
import { useRetweetPost } from '@/features/post/retweet-post/hook/useRetweetPost'
import { useUndoRetweetPost } from '@/features/post/retweet-post/hook/useUndoRetweetPost'
import { useCreatePostModel } from '@/features/post/create-post/model'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import { useAppModalPostCreatorStore } from '@/entities/App/store/AppModalPostCreatorStore'

const props = defineProps({
    post: {
        type: Object as PropType<IPost>,
        required: true
    },
    iconSize: {
        type: Number,
        required: true
    }
})

const appStore = useAppModalPostCreatorStore()
const createPostModel = useCreatePostModel()

const dropdownRef = ref<InstanceType<typeof XDropdown> | null>(null)

const isRetweeted = computed(() => {
    return props.post?.retweeted
})

const count = computed(() => {
    return props.post?.retweets_count
})

const { mutate: retweet } = useRetweetPost()
const { mutate: undoRetweet } = useUndoRetweetPost()

function retweetHandler() {
    retweet(props.post.id)

    if (!dropdownRef.value) return

    dropdownRef.value.close()
}

function undoRetweetHandler() {
    undoRetweet(props.post.id)

    if (!dropdownRef.value) return

    dropdownRef.value.close()
}

function quoteHandler() {
    appStore.setModalPostCreatorIsOpen(true)
    createPostModel.setRetweetPostId(props.post.id)
}

</script>

<template>
    <x-dropdown ref="dropdownRef">
        <template #default>
            <x-icon-button
                icon="retweet"
                :filled="isRetweeted"
                :size="iconSize"
                :active="isRetweeted"
                color="0, 186, 124"
                :count="count"
            />
        </template>
        <template #dropdown>
            <div
                class="dropdown"
                @click.stop
            >
                <div
                    v-if="isRetweeted"
                    class="dropdown-item"
                    @click="undoRetweetHandler()"
                >
                    <x-icon icon="retweet" />
                    <span class="text">Отменить ретвит</span>
                </div>
                <div
                    v-else
                    class="dropdown-item"
                    @click="retweetHandler"
                >
                    <x-icon icon="retweet" />
                    <span class="text">Ретвит</span>
                </div>
                <div
                    class="dropdown-item"
                    @click="quoteHandler"
                >
                    <x-icon icon="edit" />
                    <span class="text">Цитата</span>
                </div>
            </div>
        </template>
    </x-dropdown>
</template>

<style scoped>

.dropdown {
    background-color: var(--x-bg-color-page);
    border-radius: 15px;
    padding: 10px 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    grid-gap: 10px;
    padding: 10px 15px;
    min-width: 200px;
    font-weight: 700;
    font-size: 14px;
    cursor: pointer;
    transition: background-color .15s;
}

.dropdown-item:hover {
    background-color: rgba(255, 255, 255, .1);
}
</style>
