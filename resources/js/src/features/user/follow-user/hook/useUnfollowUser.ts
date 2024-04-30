import { useMutation } from '@tanstack/vue-query'
import { api } from '@/shared/api/methods'
import { useViewerStore } from '@/entities/Viewer/store'
import { useUserStore } from '@/entities/User/store'

export const useUnfollowUser = () => {
    return useMutation({
        mutationKey: ['unfollow-user'],
        mutationFn: async (username: string) => {
            const res = await api.users.unfollow(username)

            return res.data
        },
        onSuccess(data, variables) {
            if (!data.success) return

            const viewerStore = useViewerStore()
            const viewer = viewerStore.viewer

            if (!viewer) return

            const userStore = useUserStore()

            userStore.decrementFollowsCount(viewer.username)

            userStore.unfollowUser(variables)
        }
    })
}
