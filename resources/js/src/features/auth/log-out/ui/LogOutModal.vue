<script setup lang="ts">
import { ref } from 'vue'
import { useDeleteAccessToken } from '../hook/useDeleteAccessToken'
import XModal from '@/shared/ui/XModal/XModal.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'

defineExpose({
    open,
})

const modal = ref<InstanceType<typeof XModal> | null>(null)

const { mutate: deleteToken } = useDeleteAccessToken()

function deleteTokenHandler() {
    deleteToken()
}

function open() {
    modal.value?.open()
}

function close() {
    modal.value?.close()
}
</script>

<template>
    <div>
        <x-modal
            ref="modal"
            centered
            @close="close"
        >
            <div class="dialog">
                <div class="logo">
                    <x-icon
                        icon="logo"
                        :size="48"
                    />
                </div>
                <div class="title">
                    Выйти из X?
                </div>
                <div class="subtitle">
                    Вы всегда можете вернуться обратно.
                </div>
                <div class="buttons">
                    <x-button
                        type="info"
                        block
                        size="large"
                        bold
                        @click="deleteTokenHandler"
                    >
                        Выйти
                    </x-button>
                    <x-button
                        type="default"
                        block
                        size="large"
                        bold
                        @click="close"
                    >
                        Отмена
                    </x-button>
                </div>
            </div>
        </x-modal>
    </div>
</template>

<style scoped>
.dialog {
    display: flex;
    flex-direction: column;
    grid-gap: 10px;
    background-color: var(--x-bg-color-page);
    padding: 40px;
    border-radius: 15px;
    max-width: 320px;
    width: 100%;
    margin: 0 auto;
}

.logo {
    display: flex;
    justify-content: center;
}

.title {
    color: rgb(231, 233, 234);
    line-height: 29px;
    font-size: 24px;
    font-weight: 700;
}

.subtitle {
    color: rgb(113, 118, 123);
    font-size: 18px;
    line-height: 24px;
    font-weight: 400;
    word-wrap: break-word;
}

.buttons {
    display: flex;
    flex-direction: column;
    grid-gap: 10px;
    margin-top: 20px;
}
</style>
