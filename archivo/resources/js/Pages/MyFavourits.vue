<script setup >
const props = defineProps(
    {
        student:{
            type:Object,
            required:true,
        },
        files:{
            type:Array,
            required:true,
        },
        section:{
            type:Object,
            required:true,
        },
        company:{
            type:Object,
            required:true,
        },
        battalion:{
            type:Object,
            required:true,
        }
    }
);
import {ref} from 'vue';
</script>

<template>
    <div v-for="file in props.files" >
        {{ file.name }}
    </div>
    hhhh  {{ props.battalion }}
</template>