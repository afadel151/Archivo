<script setup>
import { Link } from '@inertiajs/vue3';
import { Button } from '@/Components/ui/button'
import { Search } from 'lucide-vue-next'
const props = defineProps({
    super_admin: {
        type: boolean,
        required: false,
    },
    schoolyears:{
        type: Array,
        required: false,
    }
})
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import {
    Menubar,
    MenubarCheckboxItem,
    MenubarContent,
    MenubarItem,
    MenubarMenu,
    MenubarRadioGroup,
    MenubarRadioItem,
    MenubarSeparator,
    MenubarShortcut,
    MenubarSub,
    MenubarSubContent,
    MenubarSubTrigger,
    MenubarTrigger,
} from '@/Components/ui/menubar';
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { boolean } from 'zod';
</script>



<template>
    <div class="flex justify-between items-center space-x-10 px-10 w-screen h-14">
        <ApplicationLogo class="w-10 h-10" />
        <Dialog>
            <DialogTrigger as-child>
                <div class="flex justify-center items-center space-x-2">
                    <div class="w-22">
                        <Label for="link" class="sr-only">
                            Link
                        </Label>
                        <Input id="link" default-value="Search" read-only />
                    </div>
                    <Button type="submit" size="sm" class="px-3">
                        <span class="sr-only">Search</span>
                        <Search class="w-4 h-4" />
                    </Button>
                </div>
            </DialogTrigger>
            <DialogContent class="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>Search for a User</DialogTitle>

                </DialogHeader>
                <div class="flex items-center space-x-2">
                    <div class="flex-1 gap-2 grid">
                        <Label for="link" class="sr-only">
                            Link
                        </Label>
                        <Input id="link" default-value="Search for a user" read-only />
                    </div>
                    <Button type="submit" size="sm" class="px-3">
                        <span class="sr-only">Search</span>
                        <Search class="w-4 h-4" />
                    </Button>
                </div>
                <DialogFooter class="sm:justify-start">
                    <DialogClose as-child>
                        <Button type="button" variant="secondary">
                            Close
                        </Button>
                    </DialogClose>
                </DialogFooter>
            </DialogContent>
        </Dialog>
        <Menubar>
            <MenubarMenu>
                <MenubarTrigger>
                    <Link href="/dashboard">Dashboard</Link>
                </MenubarTrigger>


            </MenubarMenu>
            <MenubarMenu v-if="props.super_admin == true">
                <MenubarTrigger >
                    Schoolyears
                </MenubarTrigger>
                <MenubarContent>
                    <MenubarItem v-for="schoolyear in props.schoolyears">
                        <Link :href="'/schoolyears/'+schoolyear.id">{{ schoolyear.schoolyear }}</Link>
                    </MenubarItem>
                </MenubarContent>
            </MenubarMenu>
            <MenubarMenu>
                <MenubarTrigger v-if="props.super_admin == true">
                    <Link >Modules</Link>
                </MenubarTrigger>
            </MenubarMenu>
        </Menubar>

    </div>
</template>