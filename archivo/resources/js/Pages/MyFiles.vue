<script setup>

const ModuleSearch = ref('')
const props = defineProps(
    {
        files: {
            type: Array,
            required: true
        },
        user: {
            type: Object,
            required: true
        },
        schoolyears: {
            type: Array,
            required: true
        },
        modules: {
            type: Array,
            required: true
        }
    });
import SuperAdmin from "@/Layouts/SuperAdmin.vue";
import { ref, computed } from "vue";
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle, DialogTrigger, DialogClose } from '@/Components/ui/dialog'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'
import { Check, ChevronsUpDown, Download } from 'lucide-vue-next'
import { Search } from 'lucide-vue-next'
import { Button } from '@/Components/ui/button'
import { Trash } from "lucide-vue-next";
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select'

import { cn } from '@/lib/utils'
import {
    Command,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
} from '@/Components/ui/command'
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from '@/Components/ui/popover'
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card'
import { useToast } from '@/Components/ui/toast/use-toast'
import Toaster from '@/Components/ui/toast/Toaster.vue'
const { toast } = useToast()
import axios from 'axios'
const instance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api/',
    withCredentials: true,
    xsrfCookieName: "XSRF-TOKEN",
    xsrfHeaderName: "X-XSRF-TOKEN",

});
const SchoolyearOpen = ref(false)
const SchoolyearValue = ref('')
const ModuleValue = ref('')
const ModuleId = ref(0)
const SchoolyearId = ref(0)
const MySchoolYears = ref(props.schoolyears)
const MyModules = ref(props.modules)
const ModuleOpen = ref('')
const FileName = ref('')
const Filecategory = ref('')
const file = ref(null);
const MyFiles = ref(props.files)
const FilterCategory = ref('')
const FilterSchoolyear = ref(0)

function onChange(e) {
    file.value = e.target.files[0];
}

async function SubmitFile() {
    let fd = new FormData();
    fd.append('file', file.value);
    fd.append('schoolyear_id', SchoolyearId.value);
    fd.append('module_id', ModuleId.value);
    fd.append('user_id', props.user.id);
    fd.append('file_name', FileName.value);
    fd.append('file_category', Filecategory.value);
    console.log(fd);
    try {
        let response = await instance.post('/files/store', fd);
        console.log(response.data);
        MyFiles.value.push(response.data);
    } catch (error) {
        console.log(error);
    }
}

const FilteredFilesByModule = computed(() => {
    let Items = MyFiles.value;

    switch (FilterCategory.value) {
        case 'all':
            break;
        case 'td':
            Items = Items.filter(file => file.category == 'td');
            break;
        case 'tp':
            Items = Items.filter(file => file.category == 'tp');
            break;
        case 'synthese':
            Items = Items.filter(file => file.category == 'synthese');
            break;
        case 'partiel':
            Items = Items.filter(file => file.category == 'partiel');
            break;
        case 'cours':
            Items = Items.filter(file => file.category == 'cours');
            break;
        case 'others':
            Items = Items.filter(file => file.category == 'others');
            break;
        default:
            break;
    }
    if (FilterSchoolyear.value != 0) {
        Items = Items.filter(file => file.schoolyear_id == FilterSchoolyear.value)
    }
    if (ModuleSearch.value != '') {
        Items = Items.filter(file => file.module.module.toUpperCase().includes(ModuleSearch.value.toUpperCase()) || file.schoolyear.schoolyear.includes(ModuleSearch.value) || file.category.toLowerCase().includes(ModuleSearch.value.toLowerCase()))
    }
    return Items;
})
const HandleSearchInput = (e) => {
    ModuleSearch.value = e.target.value;
}

const DeleteFile = async (id) => {
    try {
        let response = await instance.delete(`/files/${id}`);
        console.log(response.data);
        toast({
            title: response.data,
            variant: 'destructive',
        })
        MyFiles.value = MyFiles.value.filter(file => file.id != id);
    } catch (error) {
        console.log(error);
    }
}
</script>

<template>
    <SuperAdmin>

        <Toaster />
        <div>
            <div class="pl-12 text-4xl w-screen mt-10 flex justify-between px-10 space-x-32">
                <span class="font-bold">My files</span>
                <!-- Search bar for modules -->
                <div class="relative w-full max-w-sm items-center">
                    <Input id="search" @input="HandleSearchInput" type="text" placeholder="Search..." class="pl-10" />
                    <span class="absolute start-0 inset-y-0 flex items-center justify-center px-2">
                        <Search class="size-6 text-muted-foreground" />
                    </span>
                </div>

                <!-- filter by category -->
                <div class="flex space-x-6">
                    <div>
                        <Select class="col-span-3" v-model="FilterCategory">
                            <SelectTrigger class="col-span-3">
                                <SelectValue placeholder="Filter by category" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>categories</SelectLabel>
                                    <SelectItem value="all">
                                        All Categories
                                    </SelectItem>
                                    <SelectItem value="synthese">
                                        Synthese
                                    </SelectItem>
                                    <SelectItem value="partiel">
                                        Partiel
                                    </SelectItem>
                                    <SelectItem value="td">
                                        Serie TD
                                    </SelectItem>
                                    <SelectItem value="tp">
                                        TP
                                    </SelectItem>
                                    <SelectItem value="cours">
                                        Cour
                                    </SelectItem>
                                    <SelectItem value="others">
                                        Others
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                    <!-- filter by schoolyear -->
                    <div>
                        <Select class="col-span-3" v-model="FilterSchoolyear">
                            <SelectTrigger class="col-span-3">
                                <SelectValue placeholder="Filter by Schoolyear" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectLabel>Filter by Schoolyears</SelectLabel>
                                    <SelectItem :value="0">
                                        All Schoolyears
                                    </SelectItem>
                                    <SelectItem :value="school.id" v-for="school in MySchoolYears">
                                        {{ school.schoolyear }}
                                    </SelectItem>
                                    <!-- <SelectItem value="2023/2024">
                                    2022/2023
                               </SelectItem>
                               <SelectItem>
                                    2023/2024
                               </SelectItem> -->
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
                <!-- filter by type -->
                <Dialog>
                    <DialogTrigger as-child>
                        <Button variant="outline" class=" ">
                            Add A New File
                        </Button>
                    </DialogTrigger>
                    <DialogContent class="sm:max-w-[500px]">
                        <DialogHeader>
                            <DialogTitle>Edit profile</DialogTitle>
                            <DialogDescription>
                                Make changes to your profile here. Click save when you're done.
                            </DialogDescription>
                        </DialogHeader>
                        <div class="grid gap-4 py-4">
                            <div class="grid grid-cols-4 items-center gap-4">
                                <Label for="name" class="text-right">
                                    Schoolyear
                                </Label>
                                <Popover v-model:open="SchoolyearOpen">
                                    <PopoverTrigger as-child>
                                        <Button variant="outline" role="combobox" :aria-expanded="SchoolyearOpen"
                                            class=" justify-between col-span-3">
                                            {{ SchoolyearValue
                                                ? MySchoolYears.find((schoolyear) => schoolyear.schoolyear ===
                                                    SchoolyearValue)?.schoolyear
                                                : "Select Schoolyear..." }}
                                            <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                        </Button>
                                    </PopoverTrigger>
                                    <PopoverContent class="col-span-3 p-0">
                                        <Command>
                                            <CommandInput class="h-9" placeholder="Search Schoolyear..." />
                                            <CommandEmpty>No framework found.</CommandEmpty>
                                            <CommandList>
                                                <CommandGroup>
                                                    <CommandItem v-for="schoolyear in MySchoolYears"
                                                        :key="schoolyear.id" :value="schoolyear.schoolyear" @select="(ev) => {

                                                            SchoolyearValue = ev.detail.value
                                                            SchoolyearId = schoolyear.id
                                                            SchoolyearOpen = false
                                                        }">
                                                        {{ schoolyear.schoolyear }}
                                                        <Check :class="cn(
                                                            'ml-auto h-4 w-4',
                                                            SchoolyearValue === schoolyear.schoolyear ? 'opacity-100' : 'opacity-0',
                                                        )" />
                                                    </CommandItem>
                                                </CommandGroup>
                                            </CommandList>
                                        </Command>
                                    </PopoverContent>
                                </Popover>
                            </div>
                            <div class="grid gap-4 py-4">
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <Label for="name" class="text-right">
                                        Module
                                    </Label>
                                    <Popover v-model:open="ModuleOpen">
                                        <PopoverTrigger as-child>
                                            <Button variant="outline" role="combobox" :aria-expanded="ModuleOpen"
                                                class=" justify-between col-span-3">
                                                {{ ModuleValue
                                                    ? MyModules.find((module) => module.module ===
                                                        ModuleValue)?.module
                                                    : "Select Module..." }}
                                                <ChevronsUpDown class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                            </Button>
                                        </PopoverTrigger>
                                        <PopoverContent class="col-span-3 p-0">
                                            <Command>
                                                <CommandInput class="h-9" placeholder="Search Module..." />
                                                <CommandEmpty>No module found.</CommandEmpty>
                                                <CommandList>
                                                    <CommandGroup>
                                                        <CommandItem v-for="mod in MyModules" :key="mod.id"
                                                            class="flex justify-between" :value="mod.module" @select="(ev) => {

                                                                ModuleValue = ev.detail.value
                                                                ModuleId = mod.id
                                                                ModuleOpen = false
                                                            }">
                                                            <span>{{ mod.module }}</span>
                                                            <Check :class="cn(
                                                                'ml-auto h-4 w-4',
                                                                ModuleValue === mod.module ? 'opacity-100' : 'opacity-0',
                                                            )" />
                                                            <span class="font-light text-red-400 ml-10">B{{
                                                                mod.battalion
                                                            }}</span>
                                                            <span class="font-light text-red-400 ml-10">{{ mod.sector
                                                                }}</span>
                                                            <span class="font-light text-red-400 ml-10">S{{ mod.semester
                                                                }}</span>
                                                        </CommandItem>
                                                    </CommandGroup>
                                                </CommandList>
                                            </Command>
                                        </PopoverContent>
                                    </Popover>
                                </div>
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <Label for="name" class="text-right">
                                        Name
                                    </Label>
                                    <Input id="name" v-model="FileName" name="file_name"
                                        placeholder="type a name for the file " class="col-span-3" />
                                </div>
                                <div class="grid grid-cols-4 items-center gap-4">
                                    <Label for="username" class="text-right">
                                        category
                                    </Label>
                                    <Select class="col-span-3" v-model="Filecategory">
                                        <SelectTrigger class="col-span-3">
                                            <SelectValue placeholder="Select a category" />
                                        </SelectTrigger>
                                        <SelectContent>
                                            <SelectGroup>
                                                <SelectLabel>categories</SelectLabel>
                                                <SelectItem value="synthese">
                                                    Synthese
                                                </SelectItem>
                                                <SelectItem value="partiel">
                                                    Partiel
                                                </SelectItem>
                                                <SelectItem value="td">
                                                    Serie TD
                                                </SelectItem>
                                                <SelectItem value="tp">
                                                    TP
                                                </SelectItem>
                                                <SelectItem value="cours">
                                                    Cour
                                                </SelectItem>
                                                <SelectItem value="others">
                                                    Others
                                                </SelectItem>
                                            </SelectGroup>
                                        </SelectContent>
                                    </Select>
                                </div>

                                <div class="grid grid-cols-4 items-center gap-4">
                                    <Label for="username" class="text-right">
                                        File
                                    </Label>
                                    <Input name="file" type="file" @change="onChange" class="col-span-3" />
                                </div>
                            </div>
                            <DialogFooter>
                                <DialogClose as-child>
                                    <Button @click="SubmitFile">
                                        Save changes
                                    </Button>
                                </DialogClose>
                            </DialogFooter>
                        </div>
                    </DialogContent>
                </Dialog>
            </div>
            <div class="grid grid-cols-6 gap-5 p-10">
                <div v-for="file in FilteredFilesByModule">
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-nowrap overflow-hidden">{{ file.name }} {{ file.category }}</CardTitle>
                            <CardDescription>{{ file.schoolyear.schoolyear }}</CardDescription>
                        </CardHeader>
                        <CardContent class="flex justify-center items-center">
                            <img src="/svg/pdf-svgrepo-com.svg" v-if="file.type == 'pdf'" alt="" class="w-32">
                            <img src="/svg/word-svgrepo-com.svg" v-if="file.type == 'docx'" alt="" class="w-32">
                            <img :src="file.path.replace('public/','/storage/')" v-if="file.type == 'PNG' || file.type=='JPG'" alt="" class="h-32">
                        </CardContent>
                        <CardFooter class="flex justify-between p-2 gap-1 ">
                            <div class="flex flex-col">
                                <p class="text-xl">{{ file.module.module }}
                                    <span class="text-lg text-blue-500">Semester {{
                                        file.module.semester }}</span>
                                </p>
                            </div>
                            <Button size="xs" variant="outline">
                                <Download class="p-1" />
                            </Button>
                            <Dialog>
                                <DialogTrigger as-child>

                                    <Button variant="destructive" size="xs">
                                        <Trash class="p-1" />
                                    </Button>

                                </DialogTrigger>
                                <DialogContent class="sm:max-w-md">
                                    <DialogHeader>
                                        <DialogTitle>Delete this file</DialogTitle>
                                        <DialogDescription>are you sure that you want to delete that file ?
                                        </DialogDescription>
                                    </DialogHeader>
                                    <div class="flex items-center justify-end space-x-2">


                                        <DialogClose as-child>
                                            <Button class="px-3" @click="DeleteFile(file.id)">
                                                <span>Delete</span>
                                            </Button>
                                        </DialogClose>
                                    </div>
                                </DialogContent>
                            </Dialog>
                        </CardFooter>
                    </Card>
                </div>
            </div>
        </div>

    </SuperAdmin>

</template>