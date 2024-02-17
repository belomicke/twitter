<script setup lang="ts">
import { PropType } from 'vue'
import LeftSidebarFooterDropdown from './ui/LeftSidebarFooterDropdown.vue'
import UserAvatar from '@/entities/User/ui/UserAvatar.vue'
import UserNames from '@/entities/User/ui/UserNames.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import IUser from '@/shared/api/types/models/User'
import XDropdown from '@/shared/ui/XDropdown/XDropdown.vue'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    }
})
</script>

<template>
    <x-dropdown>
        <div class="footer">
            <div class="footer-avatar">
                <user-avatar
                    :path="user.profile_picture ?? ''"
                    :size="40"
                    rounded
                />
            </div>
            <div class="footer-body">
                <user-names
                    :user="user"
                />
            </div>
            <div class="footer-icon">
                <x-icon
                    icon="other"
                />
            </div>
        </div>
        <template #dropdown>
            <left-sidebar-footer-dropdown
                :active="true"
            />
        </template>
    </x-dropdown>
</template>

<style scoped>
.footer {
    display: flex;
    border-radius: 9999px;
    margin-bottom: 20px;
    padding: 12px;
    cursor: pointer;
    transition: background-color .15s;
}

.footer:hover {
    background-color: rgba(255, 255, 255, .1);
}

.footer-avatar {
    width: 40px;
}

.footer-body {
    margin: 0 12px;
}

.footer-icon {
    display: flex;
    align-items: center;
    justify-content: end;
    width: 100%;
}
</style>
