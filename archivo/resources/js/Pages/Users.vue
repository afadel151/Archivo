<script setup lang="ts">
import Input from '@/Components/ui/input/Input.vue'
import { useToast } from '@/Components/ui/toast/use-toast'
import UsersTableDD from '@/Components/UsersTableDD.vue';
import SuperAdminNav from '@/Components/SuperAdminNav.vue';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select'
const { toast } = useToast()
import {
    DropdownMenu,
    DropdownMenuCheckboxItem,
    DropdownMenuContent,
    DropdownMenuTrigger,
} from '@/Components/ui/dropdown-menu'
import { valueUpdater } from '@/lib/utils'
/**
 * @typedef {Object} User
 * @property {string} id
 * @property {string} name
 * @property {string} email
 * @property {Array<Object>} roles
 */
import Toaster from '@/Components/ui/toast/Toaster.vue'
import { h, ref, computed } from 'vue'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import Checkbox from '@/Components/Checkbox.vue';
import { ArrowUpDown, ChevronDown } from 'lucide-vue-next';
import * as z from 'zod'
import {
    FormControl,
    FormDescription,
    FormField,
    FormItem,
    FormLabel,
    FormMessage,
} from '@/Components/ui/form'
const props = defineProps(
    {
        schoolyears: {
            type: Array,
            required: true
        },
        battalions: {
            type: Array,
            required: true
        },
        companies: {
            type: Array,
            required: true
        },
        sections: {
            type: Array,
            required: true
        },
        users: {
            type: Array,
            required: true,

        },
        roles: {
            type: Array,
            required: true
        }
    }
)


const sorting = ref<SortingState>([])
const columnFilters = ref<ColumnFiltersState>([])
const columnVisibility = ref<VisibilityState>({})
const rowSelection = ref({})
const AllUsers = ref(props.users)
import Button from '@/Components/ui/button/Button.vue'
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table'
import {
    useVueTable,
    FlexRender,
    getCoreRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
} from '@tanstack/vue-table';
const UsersColumns = [
    {
        id: 'select',
        header: ({ table }) => h(Checkbox, {
            'checked': table.getIsAllPageRowsSelected() || (table.getIsSomePageRowsSelected() && 'indeterminate'),
            'onUpdate:checked': value => table.toggleAllPageRowsSelected(!!value),
            'ariaLabel': 'Select all',
        }),
        cell: ({ row }) => h(Checkbox, {
            'checked': row.getIsSelected(),
            'onUpdate:checked': value => row.toggleSelected(!!value),
            'ariaLabel': 'Select row',
        }),
        enableSorting: false,
        enableHiding: false,
    },
    {
        accessorKey: 'id',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['ID', h(ArrowUpDown, { class: 'ml-2 text-center h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase text-center' }, row.getValue('id')),
    },
    {
        accessorKey: 'name',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Name', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase text-center' }, row.getValue('name')),
    },
    {
        accessorKey: 'email',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Email', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase text-center' }, row.getValue('email')),
    },
    {
        accessorKey: 'roles',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Role', h(ArrowUpDown, { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => h('div', { class: 'lowercase text-center' }, row.original.roles[0] ? row.original.roles[0].name : 'student'),
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const payment = row.original

            return h('div', { class: 'relative' }, h(UsersTableDD, {
                payment,
            }))
        },
    }
]
const table = useVueTable({
    data: AllUsers.value,
    columns: UsersColumns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
    onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
    onRowSelectionChange: updaterOrValue => valueUpdater(updaterOrValue, rowSelection),
    state: {
        get sorting() { return sorting.value },
        get columnFilters() { return columnFilters.value },
        get columnVisibility() { return columnVisibility.value },
        get rowSelection() { return rowSelection.value },
    },
})
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
import {
    Tabs,
    TabsContent,
    TabsList,
    TabsTrigger,
} from '@/Components/ui/tabs'
import SuperAdmin from '@/Layouts/SuperAdmin.vue'
const SelecedScholyearID = ref(0);
const SelecedBattalionID = ref(0);
const SelecedCompanyID = ref(0);
const SelecedSectionID = ref(0);
const MyBattalions = ref(props.battalions);
const MySchoolYears = ref(props.schoolyears);
const MyCompanis = ref(props.companies);
const MySections = ref(props.sections);
const StudentNameInput = ref('');
const StudentPasswordInput = ref('');
const StudentMatriculInput = ref(0);
const formSchema = toTypedSchema(z.object({
    username: z.string().min(2).max(50),
    userrole: z.number().min(1).max(50),
    password: z.string().min(2).max(50),
    email: z.string().email(),
}))
const { handleSubmit } = useForm({
    validationSchema: formSchema,
})
import axios from 'axios'
const instance = axios.create({
    baseURL: 'http://127.0.0.1:8000/api/',
    withCredentials: true,
    xsrfCookieName: "XSRF-TOKEN",
    xsrfHeaderName: "X-XSRF-TOKEN",

});

const FilteredBattalions = computed(() => {
    let Items = MyBattalions.value;
    if (SelecedScholyearID.value != 0) {
        Items = Items.filter(battalion => battalion.schoolyear_id == SelecedScholyearID.value)
    }
    return Items;

})
const FilteredCompanies = computed(() => {
    let Items = MyCompanis.value;
    if (SelecedBattalionID.value != 0) {
        Items = Items.filter(company => company.battalion_id == SelecedBattalionID.value)
    }
    return Items;
})
const FilteredSections = computed(() => {
    let Items = MySections.value;
    if (SelecedCompanyID.value != 0) {
        Items = Items.filter(section => section.company_id == SelecedCompanyID.value)
    }
    return Items;
})
const onSubmit = handleSubmit(async (values) => {

    toast({
        title: 'You submitted the following values:',
        description: h('pre', { class: 'mt-2 w-[340px] rounded-md bg-slate-950 p-4' }, h('code', { class: 'text-white' }, JSON.stringify(values, null, 2))),
    })
    console.log(values.username);
    try {
        let response = await instance.post('/users/store', {
            name: values.username,
            role: values.userrole,
            email: values.email,
            password: values.password,
        });
        AllUsers.value.push(response.data);
    } catch (error) {
        console.log(error);
    }
})
const onSubmitStudent = async () => {
    toast({
        title: 'Student added successfully',
        description: h('pre', { class: 'mt-2 w-[340px] rounded-md bg-green-600 p-4' }, h('code', { class: 'text-white' }, JSON.stringify({
            name: StudentNameInput.value,
            matricul: StudentMatriculInput.value,
            password: StudentPasswordInput.value
        }, null, 2))),
    });
    try {
        let response = await instance.post('/users/store_student', {
            name: StudentNameInput.value,
            matricul: StudentMatriculInput.value,
            password: StudentPasswordInput.value,
            section_id: SelecedSectionID.value,
        });
        console.log(response.data);
    } catch (error) {
        console.log(error);

    }
}



</script>
<template>

    <div class="w-screen h-screen">
        <SuperAdminNav :super_admin="true" :schoolyears="props.schoolyears" />

        <div class="flex justify-center  items-center w-screen">
            <Toaster />
            <div class="flex relative flex-col justify-center items-center space-y-4 mt-20">
                <div class="flex flex-col justify-start items-center border-2 rounded-2xl P-10">
                    <div class="flex justify-between items-between gap-2 px-4 py-4 w-full">
                        <Input class="max-w-sm" placeholder="Filter emails..."
                            :model-value="table.getColumn('email')?.getFilterValue()"
                            @update:model-value=" table.getColumn('email')?.setFilterValue($event)" />
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="outline" class="ml-auto">
                                    Columns
                                    <ChevronDown class="ml-2 w-4 h-4" />
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end">
                                <DropdownMenuCheckboxItem
                                    v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
                                    :key="column.id" class="capitalize" :checked="column.getIsVisible()"
                                    @update:checked="(value) => {
                                        column.toggleVisibility(!!value)
                                    }">
                                    {{ column.id }}
                                </DropdownMenuCheckboxItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>

                    <Table class="w-[80%]">
                        <TableHeader>
                            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">

                                <TableHead class="text-center" v-for="header in headerGroup.headers" :key="header.id">
                                    <FlexRender :render="header.column.columnDef.header" :props="header.getContext()" />
                                </TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="row in table.getRowModel().rows " :key="row.id"
                                :data-state="row.getIsSelected() && 'selected'">
                                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                                    <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                                </TableCell>
                            </TableRow>
                        </TableBody>

                    </Table>
                    <div class="flex justify-end items-center space-x-2 py-4">
                        <div class="flex-1 text-muted-foreground text-sm">
                            {{ table.getFilteredSelectedRowModel().rows.length }} of
                            {{ table.getFilteredRowModel().rows.length }} row(s) selected.
                        </div>
                        <div class="space-x-2">
                            <Button variant="outline" size="sm" :disabled="!table.getCanPreviousPage()"
                                @click="table.previousPage()">
                                Previous
                            </Button>
                            <Button variant="outline" size="sm" :disabled="!table.getCanNextPage()"
                                @click="table.nextPage()">
                                Next
                            </Button>
                        </div>
                    </div>
                </div>
                <Dialog>
                    <DialogTrigger as-child>
                        <Button variant="outline">
                            Add
                        </Button>
                    </DialogTrigger>
                    <DialogContent class="sm:max-w-[425px]">
                        <DialogHeader>
                            <DialogTitle>Create a user</DialogTitle>
                            <DialogDescription>
                                Make changes to your profile here. Click save when you're done.
                            </DialogDescription>
                        </DialogHeader>
                        <Tabs default-value="admin">
                            <TabsList class="grid w-full grid-cols-2">
                                <TabsTrigger value="student">
                                    Student
                                </TabsTrigger>
                                <TabsTrigger value="admin">
                                    Admin
                                </TabsTrigger>
                            </TabsList>
                            <TabsContent value="admin">
                                <form @submit="onSubmit" class="flex flex-col justify-start items-center h-full">

                                    <FormField v-slot="{ componentField }" name="username">
                                        <FormItem>
                                            <FormLabel>Username</FormLabel>
                                            <FormControl>
                                                <Input type="text" placeholder="shadcn" v-bind="componentField" />
                                            </FormControl>
                                            <FormDescription>
                                                This is your public display name.
                                            </FormDescription>
                                            <FormMessage />
                                        </FormItem>
                                    </FormField>
                                    <FormField v-slot="{ componentField }" name="email">
                                        <FormItem>
                                            <FormLabel>Email</FormLabel>
                                            <FormControl>
                                                <Input type="email" placeholder="shadcn" v-bind="componentField" />
                                            </FormControl>
                                            <FormDescription>
                                                This is your public email
                                            </FormDescription>
                                            <FormMessage />
                                        </FormItem>
                                    </FormField>
                                    <FormField v-slot="{ componentField }" name="userrole">
                                        <FormItem>
                                            <FormLabel>UserRole</FormLabel>
                                            <FormControl>
                                                <Select v-bind="componentField" name="userrole">
                                                    <SelectTrigger class="w-[180px]">
                                                        <SelectValue placeholder="Select a Role" />
                                                    </SelectTrigger>
                                                    <SelectContent>
                                                        <SelectGroup>
                                                            <SelectItem v-for="role in props.roles" :value="role.id">
                                                                {{ role.name }}
                                                            </SelectItem>
                                                        </SelectGroup>
                                                    </SelectContent>
                                                </Select>
                                            </FormControl>
                                            <FormDescription>
                                                This is your public display name.
                                            </FormDescription>
                                            <FormMessage />
                                        </FormItem>
                                    </FormField>
                                    <FormField v-slot="{ componentField }" name="password">
                                        <FormItem>
                                            <FormLabel>Password</FormLabel>
                                            <FormControl>
                                                <Input type="text" placeholder="shadcn" name="password"
                                                    v-bind="componentField" />
                                            </FormControl>
                                            <FormDescription>
                                                This is your password.
                                            </FormDescription>
                                            <FormMessage />
                                        </FormItem>
                                    </FormField>
                                    <Button type="submit">
                                        Submit
                                    </Button>
                                </form>
                            </TabsContent>
                            <TabsContent value="student">
                                <form @submit="onSubmitStudent"
                                    class="flex flex-col justify-start items-center h-full gap-2 px-10">

                                    <div class="flex items-center justify-between w-full">
                                        <Label>Name</Label>
                                        <Input type="text" placeholder="type a name" v-model="StudentNameInput"
                                            class="w-52" />

                                    </div>


                                    <div class="flex items-center justify-between w-full">
                                        <Label>Schoolyesr</Label>
                                        <Select v-model="SelecedScholyearID">
                                            <SelectTrigger class="w-52">
                                                <SelectValue placeholder="Select a Schoolyear" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectItem :value="school.id" v-for="school in MySchoolYears">
                                                        {{ school.schoolyear }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>

                                    </div>
                                    <div class="flex items-center justify-between w-full">
                                        <Label>Battalion</Label>
                                        <Select v-model="SelecedBattalionID">
                                            <SelectTrigger class="w-52">
                                                <SelectValue placeholder="Select a Batalion" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectItem :value="battalion.id"
                                                        v-for="battalion in FilteredBattalions">
                                                        {{ battalion.battalion }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <div class="flex items-center justify-between w-full">
                                        <Label>Company</Label>
                                        <Select v-model="SelecedCompanyID">
                                            <SelectTrigger class="w-52">
                                                <SelectValue placeholder="Select a Company" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectItem :value="company.id"
                                                        v-for="company in FilteredCompanies">
                                                        {{ company.company }} <span class="text-red-300">{{
                                                            company.sector }}</span>
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                    </div>
                                    <div class="flex items-center justify-between w-full">
                                        <Label>Section</Label>
                                        <Select v-model="SelecedSectionID">
                                            <SelectTrigger class="w-52">
                                                <SelectValue placeholder="Select a Section" />
                                            </SelectTrigger>
                                            <SelectContent>
                                                <SelectGroup>
                                                    <SelectItem :value="section.id" v-for="section in FilteredSections">
                                                        {{ section.section }}
                                                    </SelectItem>
                                                </SelectGroup>
                                            </SelectContent>
                                        </Select>
                                    </div>

                                    <div class="flex items-center justify-between w-full">
                                        <Label>Matricule</Label>
                                        <Input type="text" placeholder="ex. 2021052" v-model="StudentMatriculInput"
                                            class="w-52" />
                                    </div>
                                    <div class="flex items-center justify-between w-full">
                                        <Label>Password</Label>
                                        <Input type="text" placeholder="type a password" v-model="StudentPasswordInput"
                                            class="w-52" />
                                    </div>
                                    <div class="flex w-full ml-20 mt-5 justify-end">
                                        <Button>
                                            Save
                                        </Button>
                                    </div>
                                </form>
                            </TabsContent>
                        </Tabs>
                    </DialogContent>
                </Dialog>
            </div>
        </div>
    </div>
</template>