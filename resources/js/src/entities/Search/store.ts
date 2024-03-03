import { defineStore } from 'pinia'
import { computed, ref } from 'vue'
import { api } from '@/shared/api/methods'
import { useUserStore } from '@/entities/User/store'

interface ISearchResult {
    query: string
    result: number[]
}

export const useSearchStore = defineStore('search', () => {
    const results = ref<ISearchResult[]>([])

    const getResultByQuery = computed(() => {
        return (query: string) => {
            return results.value.find(result => result.query === query)
        }
    })

    async function getUsersByQuery(query: string) {
        if (results.value.find(item => item.query === query)) return

        const { data } = await api.search.getUsers(query)

        if (!data.success) return

        const userStore = useUserStore()

        userStore.addUsers(data.data.items)

        results.value.push({
            query,
            result: data.data.items.map(item => item.id),
        })
    }

    return {
        getResultByQuery,
        getUsersByQuery,
    }
})
