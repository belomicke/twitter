<script setup lang="ts">
import { ref } from 'vue'
import { useChangeProfileBanner } from '../hook/useChangeProfileBanner'
import DeleteBannerConfirmDialog from './DeleteBannerConfirmDialog.vue'
import { useViewerStore } from '@/entities/Viewer/store'
import UserBanner from '@/entities/User/ui/UserBanner.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'

const viewerStore = useViewerStore()
const viewer = viewerStore.viewer

const input = ref<HTMLInputElement | null>(null)
const dialog = ref<InstanceType<typeof DeleteBannerConfirmDialog> | null>(null)

const { mutate: changeProfileBanner } = useChangeProfileBanner()

function openFilePicker() {
    input.value?.click()
}

function changeBanner(e: InputEvent) {
    const target = e.target as HTMLInputElement
    const file = target.files ? target.files[0] : null

    if (file) {
        changeProfileBanner(file)
    }
}
</script>

<template>
    <template v-if="viewer">
        <user-banner :username="viewer.username">
            <input
                ref="input"
                type="file"
                accept="image/jpeg, image/png, image/gif"
                style="display: none;"
                @change="changeBanner"
            >
            <div class="buttons">
                <x-button
                    class="button"
                    icon="add-photo"
                    no-border
                    circle
                    @click="openFilePicker"
                />
                <x-button
                    v-if="viewer.profile_banner.default !== ''"
                    class="button"
                    icon="trash-bin"
                    no-border
                    circle
                    @click="dialog?.open()"
                />
            </div>
        </user-banner>
        <delete-banner-confirm-dialog
            ref="dialog"
        />
    </template>
</template>

<style scoped>
.buttons {
    display: flex;
    grid-gap: 10px;
    position: absolute;
    z-index: 1000;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.button {
    background-color: rgba(0, 0, 0, .3);
}

.button:hover {
    background-color: rgba(0, 0, 0, .5);
}

.button:active,
.button:hover:active {
    background-color: rgba(0, 0, 0, .7);
}
</style>
