<script setup lang="ts">
import { computed, ref } from 'vue'
import { useViewerStore } from '@/entities/Viewer/store'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import {
    useChangeProfilePicture,
} from '@/features/account/edit-public-data/features/profile-avatar-changer/hook/useChangeProfilePicture'
import DeleteAvatarConfirmDialog from './DeleteAvatarConfirmDialog.vue'

const viewerStore = useViewerStore()
const viewer = viewerStore.viewer

const input = ref<HTMLInputElement | null>(null)

const { mutate: changeProfilePicture } = useChangeProfilePicture()

const profilePictureIsDefault = computed(() => {
    return viewer?.profile_picture.small.endsWith('default-profile-picture.png')
})

function openFilePicker() {
    input.value?.click()
}

function changeAvatar(e: InputEvent) {
    const target = e.target as HTMLInputElement
    const file = target.files ? target.files[0] : null

    if (file) {
        changeProfilePicture(file)
    }
}

const dialog = ref<InstanceType<typeof DeleteAvatarConfirmDialog> | null>(null)
</script>

<template>
    <template v-if="viewer">
        <div class="container">
            <div class="avatar">
                <user-avatar
                    :username="viewer.username"
                    :size="128"
                    rounded
                />
                <input
                    ref="input"
                    type="file"
                    accept="image/jpeg, image/png, image/gif"
                    style="display: none;"
                    @change="changeAvatar"
                >
                <x-button
                    class="button"
                    icon="add-photo"
                    no-border
                    circle
                    @click="openFilePicker"
                />
                <div v-if="!profilePictureIsDefault">
                    <x-button
                        type="danger"
                        class="remove-button"
                        icon="trash-bin"
                        no-border
                        circle
                        @click="dialog?.open()"
                    />
                </div>
            </div>
        </div>
        <delete-avatar-confirm-dialog
            ref="dialog"
        />
    </template>
</template>

<style scoped>
.container {
    display: flex;
    padding: 0 15px;
}

.avatar {
    display: flex;
    border: 4px solid var(--x-bg-color-page);
    border-radius: 50%;
    cursor: pointer;
    position: relative;
}

.avatar::after {
    content: "";
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, .3);
    position: absolute;
    border-radius: 50%;
    left: 0;
    top: 0;
}

.button {
    position: absolute;
    z-index: 1000;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: rgba(0, 0, 0, .3);
}

.button:hover {
    background-color: rgba(0, 0, 0, .5);
}

.button:active,
.button:hover:active {
    background-color: rgba(0, 0, 0, .7);
}

.remove-button {
    border: 2px solid var(--x-bg-color-page) !important;
    position: absolute;
    bottom: 0;
    right: 0;
    z-index: 1000;
}
</style>
