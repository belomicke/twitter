<script setup lang="ts">
import XModal from '@/shared/ui/XModal/XModal.vue'
import { ref } from 'vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import {
    useDeleteProfilePicture
} from '@/features/account/edit-public-data/features/profile-avatar-changer/hook/useDeleteProfilePicture'

defineExpose({
    open,
    close
})

const modal = ref<InstanceType<typeof XModal> | null>(null)
const { mutate: deleteProfilePicture } = useDeleteProfilePicture()

function open() {
    modal.value?.open()
}

function close() {
    modal.value?.close()
}

function confirmHandler() {
    deleteProfilePicture()
    close()
}
</script>

<template>
    <Teleport to="#portals">
        <x-modal
            ref="modal"
            centered
            @close="close"
        >
            <div class="dialog">
                <div class="header">
                    <div class="title">
                        Вы уверены?
                    </div>
                </div>
                <div class="body">
                    Вы уверены что хотите удалить свой аватар?
                </div>
                <div class="footer">
                    <x-button
                        type="danger"
                        rounded
                        bold
                        @click="confirmHandler"
                    >
                        Удалить
                    </x-button>
                    <x-button
                        type="info"
                        rounded
                        bold
                        @click="close"
                    >
                        Отмена
                    </x-button>
                </div>
            </div>
        </x-modal>
    </Teleport>
</template>

<style scoped>
.dialog {
    display: flex;
    flex-direction: column;
    background-color: rgb(0, 0, 0);
    border-radius: 16px;
    padding: 20px;
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
}

.header {
    padding: 10px 20px;
}

.title {
    font-size: 20px;
    font-weight: 700;
}

.body {
    font-size: 15px;
    color: rgb(113, 118, 123);
    padding: 10px 20px;
    white-space: pre-wrap;
    word-wrap: break-word;
}

.footer {
    display: flex;
    flex-direction: column;
    justify-content: end;
    grid-gap: 10px;
    padding: 10px 20px;
}
</style>
