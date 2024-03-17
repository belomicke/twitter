<script setup lang="ts">
import { ref, watch } from 'vue'
import { storeToRefs } from 'pinia'
import { PostCreator } from '@/features/post/create-post'
import { useAppStore } from '@/entities/App/store'
import XModal from '@/shared/ui/XModal/XModal.vue'
import { useCreatePostModel } from '@/features/post/create-post/model'

const modal = ref<InstanceType<typeof XModal> | null>(null)
const creator = ref<InstanceType<typeof PostCreator> | null>(null)

defineExpose({
    open,
})

const appStore = useAppStore()
const { getModalPostCreatorIsOpen } = storeToRefs(appStore)

const createPostModel = useCreatePostModel()
const { getRetweetPostId } = storeToRefs(createPostModel)

watch(getModalPostCreatorIsOpen, (value) => {
    if (value) {
        open()
    } else {
        close()
    }
})

function open() {
    appStore.setModalPostCreatorIsOpen(true)
    modal.value?.open()
}

function close() {
    appStore.setModalPostCreatorIsOpen(false)
    createPostModel.setRetweetPostId(null)
    creator.value?.clear()
    modal.value?.close()
    console.log('close')
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
    padding-top: 100px;
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
    display: flex;
    justify-content: center;
    max-width: 600px;
    width: 100%;
    background-color: rgb(0, 0, 0);
    border-radius: 16px;
    padding-top: 20px;
    position: relative;
    z-index: 100;
}
</style>
