<script setup lang="ts">
import { useViewerStore } from '@/entities/Viewer/store'
import XButton from '@/shared/ui/XButton/XButton.vue'
import { ref } from 'vue'
import { useChangeProfileBanner } from '@/shared/api/hook/account/profile_banner/useChangeProfileBanner'
import UserBanner from '@/entities/User/ui/UserBanner.vue'
import DeleteBannerConfirmDialog from './ui/DeleteBannerConfirmDialog.vue'

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
                type="file"
                accept="image/jpeg, image/png, image/gif"
                @change="changeBanner"
                style="display: none;"
                ref="input"
            />
            <div class="buttons">
                <x-button
                    class="button"
                    icon="add-photo"
                    @click="openFilePicker"
                    no-border
                    circle
                />
                <x-button
                    class="button"
                    icon="trash-bin"
                    @click="dialog?.open()"
                    no-border
                    circle
                    v-if="viewer.profile_banner.default !== ''"
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
