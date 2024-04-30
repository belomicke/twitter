<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { PostCreator } from '@/features/post/create-post'
import { useCreatePostModel } from '@/features/post/create-post/model'
import { useAppModalPostCreatorStore } from '@/entities/App/store/AppModalPostCreatorStore'
import XModal from '@/shared/ui/XModal/XModal.vue'

const modal = ref<InstanceType<typeof XModal> | null>(null)
const creator = ref<InstanceType<typeof PostCreator> | null>(null)

defineExpose({
    open
})

const appStore = useAppModalPostCreatorStore()
const { getModalPostCreatorIsOpen } = storeToRefs(appStore)

const createPostModel = useCreatePostModel()
const { getRetweetPostId, getCommentForPostId } = storeToRefs(createPostModel)

watch(getModalPostCreatorIsOpen, (value) => {
    if (value) {
        open()
    } else {
        close()
    }
})

const commentForPostId = computed(() => {
    return getCommentForPostId.value
})

const retweetedPostId = computed(() => {
    return getRetweetPostId.value
})

function open() {
    appStore.setModalPostCreatorIsOpen(true)
    modal.value?.open()
}

function close() {
    appStore.setModalPostCreatorIsOpen(false)
    createPostModel.setRetweetPostId(null)
    createPostModel.setCommentForPostId(null)
    creator.value?.clear()
    modal.value?.close()
}
</script>

<template>
    <x-modal
        ref="modal"
        centered
        @close="close"
    >
        <div class="wrapper">
            <div
                class="background"
                @click="close"
            />
            <div class="container">
                <post-creator
                    ref="creator"
                    :height="getRetweetPostId ? 60 : 96"
                    :in-reply-to-post-id="commentForPostId"
                    :retweet-for-post-id="retweetedPostId"
                    use-modal-data
                    @publish="close"
                />
            </div>
        </div>
    </x-modal>
</template>

<style scoped>
.wrapper {
    position: relative;
    height: 100vh;
    max-width: 600px;
    width: 100%;
}

.background {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 30;
}

.container {
    margin-top: 100px;
    max-width: 600px;
    width: 100%;
    max-height: 90vh;
    background-color: rgb(0, 0, 0);
    border-radius: 16px;
    padding: 30px 15px 0;
    position: relative;
    z-index: 100;
    overflow: auto;
}
</style>
