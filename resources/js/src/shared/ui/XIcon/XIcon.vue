<script setup lang="ts">
import { PropType } from 'vue'
import IconNames from './types'
import {
    AddPhotoIcon,
    AnalyticIcon,
    ArrowLeftIcon,
    BookmarkIcon,
    CalendarIcon,
    CheckIcon,
    ChevronDownIcon,
    CommentIcon,
    CrossedOutEyeIcon,
    CrossIcon,
    EditIcon,
    EyeIcon,
    FavoriteIcon,
    FeatherIcon,
    FollowIcon,
    GalleryIcon,
    HeartIcon,
    HomeIcon,
    LinkIcon,
    LoaderIcon,
    LocationIcon,
    LogoIcon,
    MediaIcon,
    OtherIcon,
    PinIcon,
    ProfileIcon,
    RetweetIcon,
    SearchIcon,
    SpinnerIcon,
    TrashBinIcon,
    UnfollowIcon
} from './icons'

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
    'check': CheckIcon,
    'chevron-down': ChevronDownIcon,
    'crossed-out-eye': CrossedOutEyeIcon,
    'cross': CrossIcon,
    'eye': EyeIcon,
    'arrow-left': ArrowLeftIcon,
    'location': LocationIcon,
    'link': LinkIcon,
    'calendar': CalendarIcon,
    'logo': LogoIcon,
    'home': HomeIcon,
    'profile': ProfileIcon,
    'other': OtherIcon,
    'spinner': SpinnerIcon,
    'add-photo': AddPhotoIcon,
    'trash-bin': TrashBinIcon,
    'heart': HeartIcon,
    'search': SearchIcon,
    'loader': LoaderIcon,
    'feather': FeatherIcon,
    'retweet': RetweetIcon,
    'edit': EditIcon,
    'comment': CommentIcon,
    'media': MediaIcon,
    'pin': PinIcon,
    'favorite': FavoriteIcon,
    'analytic': AnalyticIcon,
    'follow': FollowIcon,
    'unfollow': UnfollowIcon,
    'bookmark': BookmarkIcon,
    'gallery': GalleryIcon
}
</script>

<template>
    <component
        :is="icons[icon]"
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
