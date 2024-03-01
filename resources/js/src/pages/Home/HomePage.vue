<script setup lang="ts">
import XPageHeader from '@/shared/ui/XPageHeader/XPageHeader.vue'
import PostCreator from '@/widgets/PostCreator/PostCreator.vue'
import TimelineFeed from '@/widgets/Feed/TimelineFeed/TimelineFeed.vue'
</script>

<template>
    <div>
        <div class="header">
            <x-page-header>
                <div class="header-title">
                    Главная
                </div>
            </x-page-header>
        </div>
        <div class="post-creator-container">
            <post-creator />
        </div>
        <timeline-feed />
    </div>
</template>

<style scoped>
.header {
    display: flex;
    align-items: center;
    height: 100%;
    border-bottom: 1px solid var(--x-border-color);
}

.header-title {
    display: flex;
    align-items: center;
    font-size: 20px;
    height: 100%;
    font-weight: 700;
}

.post-creator-container {
    border-bottom: 1px solid var(--x-border-color);
}
</style>
