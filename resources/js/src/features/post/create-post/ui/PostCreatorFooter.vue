<script setup lang="ts">
import XFillableCircle from '@/shared/ui/XFillableCircle/XFillableCircle.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'

defineProps({
    textLength: {
        type: Number,
        required: false,
        default: 0
    },
    isValid: {
        type: Boolean,
        required: true
    },
    submitButtonText: {
        type: String,
        required: false,
        default: 'Опубликовать'
    },
    noBorders: {
        type: Boolean,
        required: false,
        default: false
    }
})

const emit = defineEmits(['publish'])

function publish() {
    emit('publish')
}
</script>

<template>
    <div
        class="footer"
        :class="{
            'no-border': noBorders
        }"
    >
        <div class="footer-right-block">
            <div
                v-if="textLength"
                class="progress"
            >
                <x-fillable-circle
                    :value="textLength"
                    :max-value="280"
                />
            </div>
            <x-button
                class="publish"
                :disabled="!isValid"
                type="primary"
                rounded
                @click="publish"
            >
                {{ submitButtonText }}
            </x-button>
        </div>
    </div>
</template>

<style scoped>
.footer {
    display: flex;
    align-items: center;
    width: 100%;
    padding-top: 10px;
    border-top: 1px solid var(--x-border-color);
}

.footer.no-border {
    border: 0;
}

.footer-right-block {
    display: flex;
    align-items: center;
    grid-gap: 10px;
    margin-left: auto;
}

.publish {
    display: flex;
}
</style>
