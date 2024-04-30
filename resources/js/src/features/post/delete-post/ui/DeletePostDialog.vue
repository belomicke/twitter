<script setup lang="ts">
import { ref } from 'vue'
import XModal from '@/shared/ui/XModal/XModal.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import { useDeletePost } from '@/features/post/delete-post/hook/useDeletePost'
import { useRoute, useRouter } from 'vue-router'

const props = defineProps({
    id: {
        type: Number,
        required: true
    }
})

defineExpose({
    open,
    close
})

const modal = ref<InstanceType<typeof XModal> | null>(null)

function open() {
    if (!modal.value) return

    modal.value.open()
}

function close() {
    if (!modal.value) return

    modal.value.close()
}

const router = useRouter()
const route = useRoute()
const { mutate: deletePost } = useDeletePost()

function deletePostHandler() {
    deletePost(props.id, {
        onSuccess(data) {
            if (!data.data.success) return

            if (route.path.startsWith('/post/')) {
                router.push('/')
            }
        }
    })
}
</script>

<template>
    <x-modal
        ref="modal"
        centered
        @close="close"
    >
        <div class="dialog">
            <div class="title">
                Удалить пост?
            </div>
            <div class="text">
                Вы уверены что хотите безвозвратно удалить пост?
            </div>
            <div class="buttons">
                <x-button
                    type="danger"
                    rounded
                    @click="deletePostHandler"
                >
                    Удалить
                </x-button>
                <x-button
                    type="info"
                    rounded
                    @click="close"
                >
                    Отмена
                </x-button>
            </div>
        </div>
    </x-modal>
</template>

<style scoped>
.dialog {
    display: flex;
    flex-direction: column;
    grid-gap: 10px;
    max-width: 300px;
    border-radius: 10px;
    border: 1px solid var(--x-border-color);
    background-color: rgb(33, 33, 33, .87);
    backdrop-filter: blur(10px);
    padding: 20px;
    margin: 0 auto;
}

.title {
    font-size: 20px;
    font-weight: 600;
}

.text {
    font-size: 14px;
}

.buttons {
    display: flex;
    justify-content: end;
    grid-gap: 10px;
}
</style>
