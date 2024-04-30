import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { useUserStore } from '@/entities/User/store'
import { useViewerStore } from '@/entities/Viewer/store'

export const useFollowUser = () => {
    return useMutation({
        mutationKey: ['follow-user'],
        mutationFn: async (username: string) => {
            const res = await api.users.follow(username)

            return res.data
        },
        onSuccess(data, variables) {
            if (!data.success) return

            const viewerStore = useViewerStore()
            const viewer = viewerStore.viewer

            if (!viewer) return

            const userStore = useUserStore()

            userStore.incrementFollowsCount(viewer.username)

            userStore.followUser(variables)
        }
    })
}
