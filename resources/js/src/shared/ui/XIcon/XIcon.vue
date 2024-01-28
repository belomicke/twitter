<script setup lang="ts">
import { PropType } from 'vue'
import IconNames from './IconNames'
import CheckIcon from '@/shared/ui/XIcon/icons/CheckIcon.vue'
import ChevronDownIcon from '@/shared/ui/XIcon/icons/ChevronDownIcon.vue'
import CrossedOutEyeIcon from '@/shared/ui/XIcon/icons/CrossedOutEyeIcon.vue'
import CrossIcon from '@/shared/ui/XIcon/icons/CrossIcon.vue'
import EyeIcon from '@/shared/ui/XIcon/icons/EyeIcon.vue'

const { icon } = defineProps({
    icon: {
        type: String as PropType<IconNames>,
        required: true
    }
})

const icons = {
    'check-icon': CheckIcon,
    'chevron-down-icon': ChevronDownIcon,
    'crossed-out-eye-icon': CrossedOutEyeIcon,
    'cross-icon': CrossIcon,
    'eye-icon': EyeIcon,
}
</script>

<template>
    <component :is="icons[`${icon}-icon`]"/>
</template>
