<script setup lang="ts">
import { PropType } from 'vue'
import IconNames from './IconNames'
import CheckIcon from '@/shared/ui/XIcon/icons/CheckIcon.vue'
import ChevronDownIcon from '@/shared/ui/XIcon/icons/ChevronDownIcon.vue'
import CrossedOutEyeIcon from '@/shared/ui/XIcon/icons/CrossedOutEyeIcon.vue'
import CrossIcon from '@/shared/ui/XIcon/icons/CrossIcon.vue'
import EyeIcon from '@/shared/ui/XIcon/icons/EyeIcon.vue'
import ArrowLeftIcon from '@/shared/ui/XIcon/icons/ArrowLeftIcon.vue'
import LocationIcon from '@/shared/ui/XIcon/icons/LocationIcon.vue'
import LinkIcon from '@/shared/ui/XIcon/icons/LinkIcon.vue'
import CalendarIcon from '@/shared/ui/XIcon/icons/CalendarIcon.vue'
import LogoIcon from '@/shared/ui/XIcon/icons/LogoIcon.vue'
import HomeIcon from '@/shared/ui/XIcon/icons/HomeIcon.vue'
import ProfileIcon from '@/shared/ui/XIcon/icons/ProfileIcon.vue'
import OtherIcon from '@/shared/ui/XIcon/icons/OtherIcon.vue'
import SpinnerIcon from '@/shared/ui/XIcon/icons/SpinnerIcon.vue'
import AddPhotoIcon from '@/shared/ui/XIcon/icons/AddPhotoIcon.vue'
import TrashBinIcon from '@/shared/ui/XIcon/icons/TrashBinIcon.vue'
import HeartIcon from '@/shared/ui/XIcon/icons/HeartIcon.vue'
import SearchIcon from '@/shared/ui/XIcon/icons/SearchIcon.vue'
import LoaderIcon from '@/shared/ui/XIcon/icons/LoaderIcon.vue'
import FeatherIcon from '@/shared/ui/XIcon/icons/FeatherIcon.vue'
import RetweetIcon from '@/shared/ui/XIcon/icons/RetweetIcon.vue'
import EditIcon from '@/shared/ui/XIcon/icons/EditIcon.vue'

const { icon } = defineProps({
    icon: {
        type: String as PropType<IconNames>,
        required: true
    },
    size: {
        type: Number,
        required: false,
        default: 20
    },
    color: {
        type: String,
        required: false,
        default: 'rgb(255, 255, 255)'
    }
})

const icons = {
    'check-icon': CheckIcon,
    'chevron-down-icon': ChevronDownIcon,
    'crossed-out-eye-icon': CrossedOutEyeIcon,
    'cross-icon': CrossIcon,
    'eye-icon': EyeIcon,
    'arrow-left-icon': ArrowLeftIcon,
    'location-icon': LocationIcon,
    'link-icon': LinkIcon,
    'calendar-icon': CalendarIcon,
    'logo-icon': LogoIcon,
    'home-icon': HomeIcon,
    'profile-icon': ProfileIcon,
    'other-icon': OtherIcon,
    'spinner-icon': SpinnerIcon,
    'add-photo-icon': AddPhotoIcon,
    'trash-bin-icon': TrashBinIcon,
    'heart-icon': HeartIcon,
    'search-icon': SearchIcon,
    'loader-icon': LoaderIcon,
    'feather-icon': FeatherIcon,
    'retweet-icon': RetweetIcon,
    'edit-icon': EditIcon
}
</script>

<template>
    <component
        :is="icons[`${icon}-icon`]"
        class="x-icon"
        :style="{
            'width': `${size}px`,
            'height': `${size}px`,
            'color': color
        }"
        v-bind="$attrs"
    />
</template>

<style>
.x-icon {
    fill: currentColor;
}
</style>
