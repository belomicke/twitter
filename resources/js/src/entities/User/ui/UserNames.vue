<script setup lang="ts">
import { PropType } from 'vue'
import IUser from '@/shared/api/types/models/User'
import UserName from '@/entities/User/ui/UserName.vue'

defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true,
    },
    fontSize: {
        type: Number as PropType<15 | 20>,
        required: false,
        default: 15,
    },
    inline: {
        type: Boolean,
        required: false,
        default: false,
    },
    links: {
        type: Boolean,
        required: false,
        default: false,
    },
})
</script>

<template>
    <component
        :is="links ? 'router-link' : 'div'"
        :to="`/profile/${user.username}`"
        class="user-names"
        :class="{ inline: inline }"
    >
        <div
            class="name"
            :class="{ link: links }"
        >
            <user-name
                :user="user"
                :font-size="fontSize"
            />
        </div>
        <div class="username">
            @{{ user.username }}
        </div>
    </component>
</template>

<style scoped>
.user-names.inline {
    display: flex;
    grid-gap: 5px;
}

.user-names {
    text-decoration: none;
}

.name.link:hover {
    text-decoration: underline;
    text-decoration-color: white;
}

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
