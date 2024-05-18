<script setup>
import Input from '@/Components/ui/input/Input.vue'
import { useToast } from '@/Components/ui/toast/use-toast'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select'
const { toast } = useToast()
import Toaster from '@/Components/ui/toast/Toaster.vue'
import { h , ref , onMounted, computed } from 'vue'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import { usePage } from '@inertiajs/vue3'

const page = usePage()
const csrf = computed(() => page.props.csrf_token)
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
        users: {
            type: Array,
            required: true
        },
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
const users = ref(props.users)
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
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/Components/ui/dialog'
import SuperAdmin from '@/Layouts/SuperAdmin.vue'
const formSchema = toTypedSchema(z.object({
    username: z.string().min(2).max(50),
    userrole: z.number().min(1).max(50),
    password: z.string().min(2).max(50),
}))
const { handleSubmit } = useForm({
    validationSchema: formSchema,
})
import axios from 'axios'
const instance = axios.create({
  baseURL: 'http://127.0.0.1:8000/api/',
});
const onSubmit =  handleSubmit(async (values) => {
  
    toast({
        title: 'You submitted the following values:',
        description: h('pre', { class: 'mt-2 w-[340px] rounded-md bg-slate-950 p-4' }, h('code', { class: 'text-white' }, JSON.stringify(values, null, 2))),
    })
    // console.log(csrf.value);
    try {
        let response = await instance.post('/users/store',{
            params:{
                username: values.username,
                userrole: values.userrole,
                password:  values.password,
                _token: csrf.value
            }
        });
        console.log(response.data);
    } catch (error) {
        console.log(error);
    }
})

</script>
<template>
    <SuperAdmin>
        <Toaster />
        <div class="flex flex-col justify-start items-center space-y-4 mt-20">
            {{ csrf }}
            <div class="flex flex-col justify-center items-center border-2 rounded-2xl P-10">
                <h1
                    class="bg-slate-200 scroll-m-20 border-b-2 w-full font-extrabold text-4xl text-center lg:text-5xl tracking-tight">
                    Admin users 
                </h1>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="text-center">
                                id
                            </TableHead>
                            <TableHead class="text-center">
                                Name
                            </TableHead>
                            <TableHead class="text-center">
                                Email
                            </TableHead>
                            <TableHead class="text-center">
                                Role
                            </TableHead>
                            <TableHead class="text-center">
                                Action
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="user in users">
                            <TableCell class="text-center">
                                {{ user.id }}
                            </TableCell>

                            <TableCell class="text-center">
                                {{ user.name }}
                            </TableCell>
                            <TableCell class="text-center">
                                {{ user.email }}
                            </TableCell>
                            <TableCell class="text-center">
                                {{ user.roles[0].name }}
                            </TableCell>
                            <TableCell class="flex justify-center items-center space-x-2">
                                <Button variant="outline">Edit</Button>
                                <Button variant="destructive">Delete</Button>
                                <Button>View</Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>


            </div>
            <Dialog>
                <DialogTrigger as-child>
                    <Button variant="outline">
                        Edit Profile
                    </Button>
                </DialogTrigger>
                <DialogContent class="sm:max-w-[425px]">
                    <DialogHeader>
                        <DialogTitle>Edit profile</DialogTitle>
                        <DialogDescription>
                            Make changes to your profile here. Click save when you're done.
                        </DialogDescription>
                    </DialogHeader>
                    <form @submit="onSubmit" class="flex flex-col justify-start items-center h-full">
                        <FormField v-slot="{ componentField }" name="_token">
                            <FormItem>
                             
                                <FormControl>
                                    <Input type="hidden" value="{{ csrf }}" v-bind="componentField" />
                                </FormControl>
                               
                            </FormItem>
                        </FormField>
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
                                                <SelectItem v-for="role in roles" :value="role.id">
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
                                    <Input type="text" placeholder="shadcn" name="password" v-bind="componentField" />
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

                </DialogContent>
            </Dialog>
        </div>
    </SuperAdmin>
</template>