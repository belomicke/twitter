<script setup lang="ts">
import XModal from '@/shared/ui/XModal/XModal.vue'
import { ref } from 'vue'
import PostCreator from '@/widgets/PostCreator/PostCreator.vue'

const modal = ref<InstanceType<typeof XModal> | null>(null)

defineExpose({
    open,
})

function open() {
    modal.value?.open()
}

function close() {
    modal.value?.close()
}

</script>

<template>
    <x-modal
        centered
        @close="close"
        ref="modal"
    >
        <div class="wrapper">
            <div class="background" @click="close"/>
            <div class="container">
                <post-creator/>
            </div>
        </div>
    </x-modal>
</template>

<style scoped>
.wrapper {
    position: relative;
    height: 100vh;
    padding-top: 100px;
}

.background {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 30;
}

.container {
    display: flex;
    justify-content: center;
    max-width: 600px;
    background-color: rgb(0, 0, 0);
    border-radius: 16px;
    padding-top: 20px;
    position: relative;
    z-index: 100;
}
</style>
