<script setup lang="ts">
import { PropType } from 'vue'
import IUser from '@/shared/api/types/models/User'
import UserName from '@/entities/User/ui/UserName.vue'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    },
    fontSize: {
        type: Number as PropType<15 | 20>,
        required: false,
        default: 15
    }
})
</script>

<template>
    <div class="user-names">
        <user-name
            :user="user"
            :font-size="fontSize"
        />
        <div class="username">@{{ user.username }}</div>
    </div>
</template>

<style scoped>


.username {
    color: rgb(113, 118, 123);
    font-feature-settings: "ss01";
    line-height: 20px;
    font-size: 15px;
    font-weight: 400;
    word-wrap: break-word;
    white-space: nowrap;
}
</style>
