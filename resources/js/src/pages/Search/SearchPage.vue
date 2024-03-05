<script setup lang="ts">

import GlobalFinder from '@/widgets/GlobalFinder/GlobalFinder.vue'
import XPageHeader from '@/shared/ui/XPageHeader/XPageHeader.vue'
import SearchedByQueryPostsFeed from '@/widgets/Feed/SearchedByQueryPostsFeed/SearchedByQueryPostsFeed.vue'
</script>

<template>
    <x-page-header>
        <div class="header-container">
            <global-finder />
        </div>
    </x-page-header>
    <searched-by-query-posts-feed
        v-if="$route.query.q"
        :query="String($route.query.q)"
    />
</template>

<style scoped>
.header-container {
    display: flex;
    align-items: center;
    height: 100%;
}
</style>
