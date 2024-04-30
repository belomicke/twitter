import { computed, ref } from 'vue'
import { defineStore } from 'pinia'
import { Media } from '@/shared/api/types/models/Media'

export const useMediaStore = defineStore('media', () => {
    // store
    const medias = ref<Media[]>([])

    // getters
    const getPostMediaById = computed(() => {
        return (id: number) => {
            return medias.value.filter(item => item.post_id === id)
        }
    })

    // actions
    function addMedia(media: Media) {
        if (!medias.value.find(item => item.id === media.id)) {
            medias.value.push(media)
        }
    }

    return {
        getPostMediaById,
        addMedia
    }
})
