<script setup lang="ts">
import { PropType } from 'vue'
import ViewerActions from './ui/ViewerActions/ViewerActions.vue'
import { useViewerStore } from '@/entities/Viewer/store'
import IUser from '@/shared/api/types/models/User'
import ForeignUserActions
    from '@/pages/Profile/ProfileLayout/ui/ProfileActions/ui/ForeignUserActions/ForeignUserActions.vue'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true,
    },
})

const viewerStore = useViewerStore()
const viewer = viewerStore.viewer
</script>

<template>
    <div
        v-if="viewer"
        class="profile-actions"
    >
        <viewer-actions v-if="viewer.id === user.id" />
        <foreign-user-actions
            v-else
            :username="user.username"
        />
    </div>
</template>

<style scoped>
.profile-actions {
    margin-top: 15px;
}
</style>
