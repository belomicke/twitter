<script setup lang="ts">
import { onMounted, onUnmounted, PropType, ref } from 'vue'
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

const isVisible = ref<boolean>(false)

const xSide = ref<'right' | 'left' | 'center'>('center')

onMounted(() => {
    window.addEventListener('resize', getXSide)
})

onUnmounted(() => {
    window.removeEventListener('resize', getXSide)
})

function getXSide() {
    xSide.value = window.innerWidth < 1280 ? 'right' : 'center'
}
</script>

<template>
    <x-dropdown
        v-model="isVisible"
        y-side="top"
        :x-side="xSide"
    >
        <div
            class="footer"
            :class="{ 'active': isVisible }"
        >
            <div class="footer-avatar">
                <user-avatar
                    :username="user.username"
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
            <left-sidebar-footer-dropdown />
        </template>
    </x-dropdown>
</template>

<style scoped>
.footer {
    display: flex;
    border-radius: 9999px;
    padding: 12px;
    cursor: pointer;
    position: relative;
    transition: background-color .15s;
}

.footer:hover, .footer.active {
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

@media (max-width: 1280px) {
    .footer {
        padding: 0;
        justify-content: center;
        align-items: center;
        height: 50px;
        width: 50px;
    }

    .footer-body {
        display: none;
    }

    .footer-icon {
        display: none;
    }
}
</style>
