<script setup>
import SuperAdminNav from '@/Components/SuperAdminNav.vue'
const props = defineProps({
    battalions: {
        type: Array,
        required: true
    },
    schoolyears: {
        type: Array,
        required: true
    }
})

import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/Components/ui/tabs'
import { Button } from '@/Components/ui/button'
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { computed } from 'vue'

const filteredBattalions = computed(()=>{
    let Itms = props.battalions;
    return Itms.sort((a,b) => a.battalion - b.battalion)
})
</script>

<template>
    <div class="h-screen w-screen">
        <SuperAdminNav :super_admin="true" :schoolyears="props.schoolyears" />
        {{ props.battalions }}
        <Tabs default-value="account" class="w-full p-20">
            <TabsList class="grid w-full grid-cols-3">
                <TabsTrigger v-for="battalion in filteredBattalions" :value="battalion.battalion">
                    {{ battalion.battalion }}
                </TabsTrigger>
                
            </TabsList>
            <TabsContent v-for="battalion in filteredBattalions" :value="battalion.battalion">
                    
            </TabsContent>
           
        </Tabs>
    </div>
</template>