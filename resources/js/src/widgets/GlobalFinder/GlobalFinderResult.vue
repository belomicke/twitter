<script setup lang="ts">
import _ from 'lodash'
import { computed, ref, watch } from 'vue'
import { useSearchStore } from '@/entities/Search/store'
import { storeToRefs } from 'pinia'
import UserListItem from '@/entities/User/ui/UserListItem.vue'
import { useRouter } from 'vue-router'
import XSpinner from '@/shared/ui/XSpinner/XSpinner.vue'

const props = defineProps({
    query: {
        type: String,
        required: true,
    },
})

const emit = defineEmits(['close'])

const router = useRouter()

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

function searchByQuery() {
    router.push(`/search?q=${props.query}`)
    emit('close')
}
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
            <x-spinner
                :size="30"
            />
        </div>
        <template v-if="result && !isLoading">
            <div
                class="list-item"
                @click="searchByQuery"
            >
                Поиск «{{ query }}»
            </div>
            <div class="separator" />
            <template v-if="result.result.length">
                <user-list-item
                    v-for="item in result.result"
                    :id="item"
                    :key="item"
                    @click="$emit('close')"
                />
                <div class="separator" />
            </template>
            <div
                class="list-item"
                @click="$router.push(`/profile/${query}`)"
            >
                Перейти к @{{ query }}
            </div>
        </template>
    </div>
</template>

<style scoped>
.sidebar-input-result {
    margin-top: 10px;
    border-radius: 15px;
    box-shadow: rgba(255, 255, 255, 0.2) 0 0 15px, rgba(255, 255, 255, 0.15) 0 0 3px 1px;
    min-height: 100px;
    background-color: var(--x-bg-color-page);
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

.list-item {
    padding: 15px;
    font-weight: 400;
    font-size: 15px;
    line-height: 20px;
    color: rgb(231, 233, 234);
    word-wrap: break-word;
    cursor: pointer;
    transition: background-color .15s;
}

.list-item:hover {
    background-color: rgb(22, 24, 28);
}

.list-item:active {
    background-color: rgba(18, 21, 23, 0.7);
}

.separator {
    height: 1px;
    width: 100%;
    background-color: var(--x-border-color);
    margin: 5px 0;
}

.loader {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100px;
}
</style>
