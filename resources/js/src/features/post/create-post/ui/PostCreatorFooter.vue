<script setup lang="ts">
import XFillableCircle from '@/shared/ui/XFillableCircle/XFillableCircle.vue'
import XButton from '@/shared/ui/XButton/XButton.vue'
import XIconButton from '@/shared/ui/XIconButton/XIconButton.vue'

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
    disableOpenMediaFilePickerButton: {
        type: Boolean,
        required: false,
        default: false
    },
    noBorders: {
        type: Boolean,
        required: false,
        default: false
    }
})

const emit = defineEmits(['publish', 'open-media-file-picker'])

function publish() {
    emit('publish')
}

function openMediaFilePicker() {
    emit('open-media-file-picker')
}
</script>

<template>
    <div
        class="footer"
        :class="{
            'no-border': noBorders
        }"
    >
        <div class="footer-left-block">
            <x-icon-button
                color="var(--x-color-primary-code)"
                color-hover="var(--x-color-primary-code)"
                background-color-hover="var(--x-color-primary-code)"
                :disable="disableOpenMediaFilePickerButton"
                icon="media"
                :size="19"
                @click="openMediaFilePicker"
            />
        </div>
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
    padding: 10px 0;
    border-top: 1px solid var(--x-border-color);
    position: sticky;
    bottom: -1px;
    background-color: var(--x-bg-color-page);
}

.footer.no-border {
    border: 0;
}

.footer-left-block {
    display: flex;
    align-items: center;
    grid-gap: 10px;
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
