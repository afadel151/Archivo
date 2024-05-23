<script setup>
import SuperAdminNav from '@/Components/SuperAdminNav.vue';
import {
    Accordion,
    AccordionContent,
    AccordionItem,
    AccordionTrigger,
} from "@/Components/ui/accordion"
</script>
<template>
    <div class="w-screen h-screen">
        <SuperAdminNav />
        <div class="flex justify-center items-center w-screen">
            
            <slot />
        </div>
    </div>
</template>