<script setup lang="ts">

import { PropType } from 'vue'
import IUser from '@/shared/api/types/models/User'
import UserBio from '@/entities/User/ui/UserBio.vue'
import UserData from '@/entities/User/ui/UserData.vue'
import UserNames from '@/entities/User/ui/UserNames.vue'
import UserStats from '@/entities/User/ui/UserStats.vue'

const { user } = defineProps({
    user: {
        type: Object as PropType<IUser>,
        required: true
    }
})
</script>

<template>
    <template v-if="user">
        <div class="info-block">
            <user-names
                :user="user"
                :font-size="20"
            />
        </div>
        <div class="info-block" v-if="user.bio">
            <user-bio
                :bio="user.bio"
            />
        </div>
        <div class="info-block">
            <user-data
                :user="user"
            />
        </div>
        <div class="info-block">
            <user-stats
                :user="user"
            />
        </div>
    </template>
</template>

<style scoped>
.info-block {
    width: 100%;
    padding-top: 10px;
}
</style>
