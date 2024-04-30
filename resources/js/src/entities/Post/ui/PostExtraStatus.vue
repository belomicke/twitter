<script setup lang="ts">

import { PropType } from 'vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
import { IconNames } from '@/shared/ui/XIcon'

defineProps({
    icon: {
        type: String as PropType<IconNames>,
        required: true
    },
    text: {
        type: String,
        required: true
    },
    iconIsFilled: {
        type: Boolean,
        required: false,
        default: false
    },
    withUnderline: {
        type: Boolean,
        required: false,
        default: false
    }
})
</script>
const router = useRouter()
<template>
    <div
        class="extra-status"
        v-bind="$attrs"
    >
        <div class="icon">
            <x-icon
                :icon="icon"
                :filled="iconIsFilled"
                :size="16"
                color="rgb(113, 118, 123)"
            />
        </div>
        <div
            class="text"
            :class="{
                'with-underline': withUnderline
            }"
        >
            {{ text }}
        </div>
    </div>
</template>

<style scoped>
.extra-status {
    display: grid;
    grid-template-columns: 40px 1fr;
    grid-gap: 10px;
    padding: 5px 15px 0;
}

.icon {
    display: flex;
    justify-content: end;
    align-items: center;
    color: rgb(113, 118, 123) !important;
}

.text {
    color: rgb(113, 118, 123);
    line-height: 16px;
    font-size: 13px;
    font-weight: 700;
}

.text.with-underline:hover {
    text-decoration: underline;
}
</style>
