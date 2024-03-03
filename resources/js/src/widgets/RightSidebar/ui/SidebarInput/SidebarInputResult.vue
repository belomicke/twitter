<script setup lang="ts">
import _ from 'lodash'
import { computed, ref, watch } from 'vue'
import { useSearchStore } from '@/entities/Search/store'
import { storeToRefs } from 'pinia'
import UserListItem from '@/entities/User/ui/UserListItem.vue'
import XIcon from '@/shared/ui/XIcon/XIcon.vue'

const props = defineProps({
    query: {
        type: String,
        required: true,
    },
})

const emit = defineEmits(['close'])

const isLoading = ref<boolean>(false)

const searchStore = useSearchStore()
const { getResultByQuery } = storeToRefs(searchStore)

const result = computed(() => {
    return getResultByQuery.value(props.query)
})

const debouncedFunction = _.debounce((value: string) => {
    searchStore.getUsersByQuery(value)
    isLoading.value = false
}, 500)

watch(() => props.query, (newValue) => {
    if (!newValue?.length) return

    isLoading.value = true
    debouncedFunction(newValue)
})
</script>

<template>
    <div class="sidebar-input-result">
        <span
            v-if="!query.length && !isLoading"
            class="empty"
        >
            Попробуйте искать людей, списки или ключевые слова
        </span>
        <div
            v-if="isLoading"
            class="loader"
        >
            <x-icon
                icon="loader"
                :size="80"
                color="var(--x-color-primary)"
            />
        </div>
        <template v-if="result && !isLoading">
            <template v-if="result.result.length">
                <user-list-item
                    v-for="item in result.result"
                    :id="item"
                    :key="item"
                    @click="$emit('close')"
                />
            </template>
            <span
                v-else
                class="empty"
            >
                Ничего не найдено.
            </span>
        </template>
    </div>
</template>

<style scoped>
.sidebar-input-result {
    margin-top: 10px;
    border-radius: 15px;
    box-shadow: rgba(255, 255, 255, 0.2) 0 0 15px, rgba(255, 255, 255, 0.15) 0 0 3px 1px;
    min-height: 100px;
    overflow: hidden;
}

.empty {
    display: flex;
    justify-content: center;
    align-items: center;
    color: rgb(113, 118, 123);
    line-height: 20px;
    word-wrap: break-word;
    text-align: center;
    font-size: 15px;
    font-weight: 400;
    width: 100%;
    padding: 20px 12px 12px;
}

.loader {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100px;
}
</style>
