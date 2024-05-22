<script setup>

const props = defineProps({
    student: {
        type: Object,
        required: true,
    },
    modules: {
        type: Array,
        required: true,
    },
    schoolyears: {
        type: Array,
        required: true,
    }
})
import { ref, computed } from 'vue';
import { Button } from '@/Components/ui/button'
import { Input } from '@/Components/ui/input'
import { Label } from '@/Components/ui/label'

import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetDescription,
    SheetFooter,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from '@/Components/ui/sheet'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select'
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/Components/ui/card'
import { Bookmark, Download } from 'lucide-vue-next';
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import { Separator } from '@/Components/ui/separator'
const instance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api/',
    withCredentials: true,
    xsrfCookieName: "XSRF-TOKEN",
    xsrfHeaderName: "X-XSRF-TOKEN",

});
const MyFiles = ref(null)
const ModuleSearch = ref(0)
const Schoolyearsearch = ref(0)
const FilterCategory = ref('')
const GetFiles = async () => {
    try {
        let response = await instance.get('/files/', {
            params: {
                module_id: ModuleSearch.value,
                schoolyear_id: Schoolyearsearch.value,
            }
        });
        console.log(response.data);
        MyFiles.value = response.data;
    } catch (error) {
        console.log(error);
    }
}
const FilteredFiles = computed(() => {
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
    return Items;
})

async function DownloadFile(file) {
    let id = file.id;
    try {
        let response = await instance.get('/files/download', {
            params: {
                file_id: id,
            },
            responseType: 'blob'
        });
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', file.module.module+'_'+file.schoolyear.schoolyear+'_'+file.name+'_'+file.category+'.'+file.type);
        document.body.appendChild(link);
        link.click();
        link.parentNode.removeChild(link);
    } catch (error) {
        console.log(error);
    }
}
</script>
<template>
    <div class="w-screen h-16 flex justify-between items-center">
        <ApplicationLogo class="h-16" />
        <div class="flex justify-center items-center w-fit pl-10">
            <p class="text-nowrap text-2xl"> {{ props.student.first_name }} {{ props.student.last_name }} <span
                    class="ml-5">Battalion:{{ props.student.section.company.battalion.battalion }} / Company {{
                        student.section.company.company }} {{ props.student.section.company.sector }} / Section {{
                        student.section.section }} </span></p>
        </div>
        <div class="w-full h-full flex justify-end items-center gap-4 px-10">
            <Button variant="outline">
                <Bookmark />
            </Button>
            <Sheet>
                <SheetTrigger as-child>
                    <Button variant="outline">
                        Search
                    </Button>
                </SheetTrigger>
                <SheetContent>
                    <SheetHeader>
                        <SheetTitle>Search for documents</SheetTitle>
                        <SheetDescription>
                            This application is developed to make it easy for ENPEI students to search for documents
                        </SheetDescription>
                    </SheetHeader>
                    <div class="grid gap-4 py-4">
                        <div class="grid grid-cols-4 items-center gap-4">
                            <Label for="username" class="text-right">
                                SchoolYear
                            </Label>
                            <Select class="col-span-3" name="schoolyear_selection" v-model="Schoolyearsearch">
                                <SelectTrigger class="col-span-3">
                                    <SelectValue placeholder="Select a schoolyear" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>your Modules</SelectLabel>

                                        <SelectItem :value="schoolyear.id" v-for="schoolyear in props.schoolyears">
                                            {{ schoolyear.schoolyear }}
                                        </SelectItem>

                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>
                        <div class="grid grid-cols-4 items-center gap-4">
                            <Label for="name" class="text-right">
                                Module
                            </Label>
                            <Select class="col-span-3" name="schoolyear_selection" v-model="ModuleSearch">
                                <SelectTrigger class="col-span-3">
                                    <SelectValue placeholder="Select a module" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>your Modules</SelectLabel>

                                        <SelectItem :value="mod.id" v-for="mod in props.modules">
                                            {{ mod.module }}
                                        </SelectItem>

                                    </SelectGroup>
                                </SelectContent>
                            </Select>
                        </div>

                    </div>
                    <SheetFooter>
                        <SheetClose as-child>
                            <Button type="submit" @click="GetFiles">
                                Get documents
                            </Button>
                        </SheetClose>
                    </SheetFooter>
                </SheetContent>
            </Sheet>
        </div>
    </div>
    <Separator />
    <div class="w-full">
        <div v-if="MyFiles == null">
            <p class="text-6xl pl-10 text-gray-500 mt-20">
                No files for now
            </p>
        </div>
        <div v-else>
            <div class="flex justify-between items-center">
                <Label class="text-5xl pl-10">Result:</Label>
                <Select class="col-span-3" v-model="FilterCategory">
                    <SelectTrigger class="col-span-3 w-52  m-5">
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
            <div class="grid grid-cols-7 p-10  gap-10">
                <div v-for="file in FilteredFiles">
                    <Card>
                        <CardHeader>
                            <CardTitle class="text-nowrap overflow-hidden">{{ file.name }} {{ file.category }}
                            </CardTitle>
                            <CardDescription>{{ file.schoolyear.schoolyear }}</CardDescription>
                        </CardHeader>
                        <CardContent class="flex justify-center items-center">
                            <img src="/svg/pdf-svgrepo-com.svg" v-if="file.type == 'pdf'" alt="" class="w-32">
                            <img src="/svg/word-svgrepo-com.svg" v-if="file.type == 'docx'" alt="" class="w-32">
                            <img :src="file.path.replace('public/', '/storage/')"
                                v-if="file.type == 'PNG' || file.type == 'JPG'" alt="" class="h-32">
                        </CardContent>
                        <CardFooter class="flex justify-between p-2 gap-1 ">
                            <div class="flex flex-col">
                                <p class="text-xl">{{ file.module.module }}
                                    <span class="text-lg text-blue-500">Semester {{
                                        file.module.semester }}</span>
                                </p>
                            </div>
                            <Button size="xs" @click="DownloadFile(file)" variant="outline">
                                <Download class="p-1" />
                            </Button>

                        </CardFooter>
                    </Card>
                </div>
            </div>
        </div>

    </div>
</template>