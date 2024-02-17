<script setup lang="ts">
import { computed } from 'vue'
import moment from 'moment/moment'
import XSelect from '@/shared/ui/XSelect/XSelect.vue'

const {
    month
} = defineProps({
    day: {
        type: Number,
        required: true
    },
    month: {
        type: Number,
        required: true
    },
    year: {
        type: Number,
        required: true
    }
})

defineEmits(['update:day', 'update:month', 'update:year'])

const monthOptions = computed(() => {
    const result: { value: number, label: string }[] = []
    const months = [
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря',
    ]

    for (let i = 1; i <= 12; i++) {
        result.push({
            label: months[i - 1],
            value: i
        })
    }

    return result
})

const yearOptions = computed(() => {
    let result: { value: number, label: string }[] = []

    const currentYear = new Date().getFullYear()

    for (let i = 0; i <= 100; i++) {
        const value = currentYear - i

        result.push({
            label: String(value),
            value: value
        })
    }

    return result
})

const dayOptions = computed(() => {
    let result: { value: number, label: string }[] = []
    const daysCount = moment({ month: month !== 0 ? month - 1 : 0 }).daysInMonth()

    for (let i = 1; i <= daysCount; i++) {
        result.push({
            label: String(i),
            value: i
        })
    }

    return result
})
</script>

<template>
    <div class="birth">
        <div class="birth-title">Дата рождения</div>
        <div class="birth-info">
            Эта информация не будет общедоступной. Подтвердите свой возраст, даже если эта
            учетная запись предназначена для компании, домашнего животного и т. д.
        </div>
        <div class="birth-form">
            <x-select
                label="Месяц"
                @change="$emit('update:month', Number($event.target.value))"
                :options="monthOptions"
            />
            <x-select
                label="День"
                @change="$emit('update:day', Number($event.target.value))"
                :options="dayOptions"
            />
            <x-select
                label="Год"
                @change="$emit('update:year', Number($event.target.value))"
                :options="yearOptions"
            />
        </div>
    </div>
</template>

<style scoped>
.birth {
    margin-top: 20px;
}

.birth-title {
    color: rgb(231, 233, 234);
    line-height: 20px;
    margin-bottom: 8px;
    word-wrap: break-word;
    font-weight: var(--x-font-weight-bold);
    font-size: 15px;
}

.birth-info {
    font-weight: var(--x-font-weight-normal);
    font-size: 14px;
    line-height: 16px;
    word-wrap: break-word;
    margin-bottom: 4px;
    color: rgb(113, 118, 123);
}

.birth-form {
    display: flex;
    grid-gap: 15px;
    margin: 16px 0;
}
</style>
