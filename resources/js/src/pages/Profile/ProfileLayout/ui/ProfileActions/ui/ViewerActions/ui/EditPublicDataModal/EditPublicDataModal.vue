<script setup lang="ts">
import XModal from '@/shared/ui/XModal/XModal.vue'
import { computed, ref } from 'vue'
import XModalContainer from '@/shared/ui/modal/XModalContainer/XModalContainer.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import XInput from '@/shared/ui/XInput/XInput.vue'
import { useViewerStore } from '@/entities/Viewer/store'
import XTextarea from '@/shared/ui/XTextarea/XTextarea.vue'
import { useEditViewerPublicData } from '@/shared/api/hook/account/useEditViewerPublicData'

const emit = defineEmits(['close'])

defineExpose({
    open,
    close,
})

const modal = ref<InstanceType<typeof XModal> | null>(null)

function open() {
    modal.value?.open()
}

function close() {
    modal.value?.close()
    emit('close')
    reset()
}

function reset() {
    credentials.value = {
        name: viewer ? viewer.name : '',
        bio: viewer ? viewer.bio : '',
        location: viewer ? viewer.location : '',
        link: viewer ? viewer.link : '',
    }
}

const viewerStore = useViewerStore()
const viewer = viewerStore.viewer

const credentials = ref({
    name: viewer ? viewer.name : '',
    bio: viewer ? viewer.bio : '',
    location: viewer ? viewer.location : '',
    link: viewer ? viewer.link : '',
})

const formIsValid = computed(() => {
    if (!viewer) return false

    if (credentials.value.name.length && credentials.value.name !== viewer.name) return true
    if (credentials.value.bio !== viewer.bio) return true
    if (credentials.value.location !== viewer.location) return true

    return credentials.value.link !== viewer.link
})

const { mutate: editViewerPublicData } = useEditViewerPublicData()

function submit() {
    editViewerPublicData(credentials.value, {
        onSuccess(data) {
            if (data.data.success) {
                close()
            }
        },
    })
}
</script>

<template>
    <x-modal
        @close="close"
        centered
        ref="modal"
    >
        <x-modal-container>
            <template #header>
                <div class="header-content">
                    <div class="header-title">Изменить профиль</div>
                    <x-button
                        type="info"
                        rounded
                        :disabled="!formIsValid"
                        @click="submit"
                    >
                        Сохранить
                    </x-button>
                </div>
            </template>
            <div class="content">
                <div class="form">
                    <x-input
                        placeholder="Имя"
                        v-model="credentials.name"
                        maxlength="50"
                        show-word-limit
                    />
                    <x-input
                        placeholder="Местоположение"
                        v-model="credentials.location"
                        maxlength="30"
                        show-word-limit
                    />
                    <x-input
                        placeholder="Веб-сайт"
                        v-model="credentials.link"
                        maxlength="100"
                        show-word-limit
                    />
                    <x-textarea
                        placeholder="О себе"
                        v-model="credentials.bio"
                        maxlength="160"
                        show-word-limit
                    />
                </div>
            </div>
        </x-modal-container>
    </x-modal>
</template>

<style scoped>
.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
}

.header-title {
    font-size: 20px;
    font-weight: 700;
    margin-left: 10px;
}

.content {
    overflow: auto;
}

.form {
    display: flex;
    flex-direction: column;
    grid-gap: 20px;
    padding: 20px 50px;
}
</style>
