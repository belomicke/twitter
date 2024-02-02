<script setup lang="ts">
import { useDeleteViewerAccessToken } from '@/shared/api/hook/auth/useDeleteViewerAccessToken'

defineProps({
    active: {
        type: Boolean,
        required: true
    }
})

const { mutate: deleteToken } = useDeleteViewerAccessToken()

function deleteTokenHandler() {
    deleteToken()
}

</script>

<template>
    <div
        class="dropdown"
        :class="{
            'visible': active
        }"
    >
        <div
            class="dropdown-item"
            @click="deleteTokenHandler"
        >
            Выйти из учетной записи
        </div>
    </div>
</template>

<style scoped>
.dropdown {
    width: 100%;
    height: 100%;
    padding: 10px 0;
    overflow: hidden;
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
