<script setup lang="ts">
import { PropType } from "vue";
import ViewerActions from "./ui/ViewerActions/ViewerActions.vue";
import { useViewerStore } from "@/entities/Viewer/store";
import IUser from "@/shared/api/types/models/User";

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    }
})

const viewerStore = useViewerStore()
const viewer = viewerStore.viewer
</script>

<template>
    <div class="profile-actions" v-if="viewer">
        <viewer-actions v-if="viewer.id === user.id"/>
        <div v-else>hello</div>
    </div>
</template>

<style scoped>
.profile-actions {
    margin-top: 15px;
}
</style>
