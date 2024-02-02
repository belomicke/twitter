<script setup lang="ts">
import XPageHeader from '@/shared/ui/XPageHeader/XPageHeader.vue'
import { PropType } from 'vue'
import IUser from '@/shared/api/types/models/User'
import UserName from '@/entities/User/ui/UserName.vue'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    }
})
</script>

<template>
    <x-page-header with-go-to-back-button>
        <div class="header-content">
            <user-name
                :user="user"
                :font-size="20"
            />
            <div class="header-subtitle">{{ user.posts_count }} постов</div>
        </div>
    </x-page-header>
</template>

<style scoped>
.header-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    height: 100%;
}

.header-subtitle {
    font-size: 13px;
    line-height: 16px;
    color: rgb(113, 118, 123);
}
</style>
