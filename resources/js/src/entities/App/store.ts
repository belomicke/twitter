import { computed, ref } from 'vue'
import { defineStore } from 'pinia'

export const useAppStore = defineStore('app', () => {
    // store
    const modalPostCreatorIsOpen = ref<boolean>(false)

    // getters
    const getModalPostCreatorIsOpen = computed(() => {
        return modalPostCreatorIsOpen.value
    })

    // actions
    const setModalPostCreatorIsOpen = (value: boolean) => {
        modalPostCreatorIsOpen.value = value
    }

    return {
        getModalPostCreatorIsOpen,
        setModalPostCreatorIsOpen,
    }
})
