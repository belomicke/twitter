<script setup lang="ts">

import XButton from '@/shared/ui/XButton/XButton.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'
</script>

<template>
    <div class="logo">
        <x-button
            circle
            text
            block
            size="extra-large"
            @click="$router.push('/')"
        >
            <x-icon icon="logo" :size="26"/>
        </x-button>
    </div>
</template>

<style scoped>
.logo {
    width: 50px;
    height: 50px;
    padding: 2px 0;
}
</style>
