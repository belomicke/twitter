<script setup lang="ts">
import AuthForm from '@/widgets/AuthForm/AuthForm.vue'
import SvgLogo from '@/shared/ui/svg/Logo.vue'
</script>

<template>
    <div class="wrapper">
        <div class="container">
            <auth-form/>
            <div class="logo-container">
                <svg-logo></svg-logo>
            </div>
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    display: flex;
    flex: 1;
}

.container {
    display: flex;
    align-items: stretch;
    flex: 1 1 auto;
    min-height: auto;
    flex-direction: row-reverse;
}

.logo-container {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    flex: 1;
    overflow-x: hidden;
    overflow-y: hidden;
    padding: 0;
    justify-content: center;
    min-height: 100vh;
}

.logo-container > svg {
    display: inline-block;
    justify-content: center;
    color: rgba(231, 233, 234, 1.00);
    vertical-align: text-bottom;
    max-height: 380px;
    height: 100%;
    fill: currentColor;
    user-select: none;
    max-width: 100%;
    position: relative;
    padding: 32px;
    margin: auto 0;
    width: 100%;
}
</style>
