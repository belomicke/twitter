<script setup lang="ts">
import XPageHeader from '@/shared/ui/XPageHeader/XPageHeader.vue'
import { computed, PropType } from 'vue'
import IUser from '@/shared/api/types/models/User'
import UserName from '@/entities/User/ui/UserName.vue'
import { useRoute } from 'vue-router'

const props = defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true,
    },
})

const route = useRoute()

const title = computed(() => {
    const page = route.path.split('/').at(-1)

    if (page === props.user.username) {
        return `${props.user.posts_count} постов`
    } else if (page === 'liked') {
        return `${props.user.favourites_count} отметок «Нравится»`
    }

    return ''
})
</script>

<template>
    <x-page-header with-go-to-back-button>
        <div class="header-content">
            <user-name
                :user="user"
                :font-size="20"
            />
            <div class="header-subtitle">
                {{ title }}
            </div>
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
