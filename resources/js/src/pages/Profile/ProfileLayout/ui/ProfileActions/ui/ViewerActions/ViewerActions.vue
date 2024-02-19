<script setup lang="ts">

import { ref } from 'vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import EditPublicDataModal from './ui/EditPublicDataModal/EditPublicDataModal.vue'

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
    <div>
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
    </div>
</template>

<style scoped>

</style>
