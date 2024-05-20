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
        <div class="flex ">
            <!-- <div class=" flex flex-col justify-start items-center w-[10%] h-full">
                <Accordion type="single" class="w-full" collapsible>
                    <AccordionItem :key="1" :value="1">
                        <AccordionTrigger class="px-2"> item.title </AccordionTrigger>
                        <AccordionContent>
                            item.content
                        </AccordionContent>
                    </AccordionItem>
                    <AccordionItem :key="2" :value="2">
                        <AccordionTrigger class="px-2"> item.title </AccordionTrigger>
                        <AccordionContent>
                            item.content
                        </AccordionContent>
                    </AccordionItem>
                </Accordion>
            </div> -->
            <slot />
        </div>
    </div>
</template>