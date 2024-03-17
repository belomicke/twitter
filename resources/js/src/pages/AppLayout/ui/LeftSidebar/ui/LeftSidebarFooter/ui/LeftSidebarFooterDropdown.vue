<script setup lang="ts">
import { ref } from 'vue'
import { LogOutModal } from '@/features/auth/log-out'

const logOutModalRef = ref<InstanceType<typeof LogOutModal> | null>(null)

function openLogOutModal() {
    logOutModalRef.value?.open()
}

</script>

<template>
    <div class="dropdown">
        <div
            class="dropdown-item"
            @click="openLogOutModal"
        >
            Выйти из учетной записи
        </div>
    </div>
    <log-out-modal ref="logOutModalRef" />
</template>

<style scoped>
.dropdown {
    width: 100%;
    height: 100%;
    padding: 10px 0;
    overflow: hidden;
    min-width: 290px;
}

.dropdown-item {
    cursor: pointer;
    padding: 20px 15px;
    font-weight: 700;
    font-size: 15px;
    transition: background-color .15s;
}

.dropdown-item:hover {
    background-color: rgba(255, 255, 255, .1);
}
</style>
