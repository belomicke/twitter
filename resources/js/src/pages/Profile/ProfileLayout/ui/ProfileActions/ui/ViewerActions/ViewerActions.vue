<script setup lang="ts">

import { ref } from 'vue'
import { EditPublicDataModal } from '@/features/account/edit-public-data'
import XButton from '@/shared/ui/XButton/XButton.vue'

const modal = ref<InstanceType<typeof EditPublicDataModal> | null>(null)

const modalIsOpen = ref<boolean>(false)

function openModalHandler() {
    modalIsOpen.value = true
    modal.value?.open()
}

function closeModalHandler() {
    modalIsOpen.value = false
}
</script>

<template>
    <x-button
        size="default"
        rounded
        :active="modalIsOpen"
        @click="openModalHandler"
    >
        Изменить профиль
    </x-button>
    <edit-public-data-modal
        ref="modal"
        @close="closeModalHandler"
    />
</template>

<style scoped>

</style>
