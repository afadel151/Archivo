<script setupt>
import SuperAdmin from '@/Layouts/SuperAdmin.vue';
const props = defineProps(
    {
        roles: {
            type: Array,
            required: true
        },
        permissions: {
            type: Array,
            required: true
        }
    }
)
</script>

<template>
    <SuperAdmin>

    </SuperAdmin>
</template>