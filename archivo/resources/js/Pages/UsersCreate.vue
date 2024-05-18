<script setup>
import SuperAdmin from '@/Layouts/SuperAdmin.vue';
import Button from '@/Components/ui/button/Button.vue';
import Input from '@/Components/ui/input/Input.vue';
import { useToast } from '@/Components/ui/toast/use-toast'
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
} from '@/Components/ui/select';
const { toast } = useToast();

import Toaster from '@/Components/ui/toast/Toaster.vue';
import { h } from 'vue'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
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


const formSchema = toTypedSchema(z.object({
    username: z.string().min(2).max(50),
    usertype: z.string().min(2).max(50),
    userrole: z.number().min(1).max(50),
    password: z.string().min(2).max(50),
}))
const { handleSubmit } = useForm({
    validationSchema: formSchema,
})

const onSubmit = handleSubmit((values) => {
    console.log(values);
    toast({
        title: 'You submitted the following values:',
        description: h('pre', { class: 'mt-2 w-[340px] rounded-md bg-slate-950 p-4' }, h('code', { class: 'text-white' }, JSON.stringify(values, null, 2))),
    })
})
</script>

<template>
    <SuperAdmin>
        <Toaster />
        <div class="px-20">
            <form @submit="onSubmit" class="flex flex-col justify-start items-center mt-32 h-full">

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
                <FormField v-slot="{ componentField }" name="usertype">
                    <FormItem>
                        <FormLabel>UserType</FormLabel>
                        <FormControl>
                            <Select v-bind="componentField" name="usertype">
                                <SelectTrigger class="w-[180px]">
                                    <SelectValue placeholder="Select a fruit" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectGroup>
                                        <SelectLabel>Fruits</SelectLabel>
                                        <SelectItem value="enpei">
                                            Military (ENPEI)
                                        </SelectItem>
                                        <SelectItem value="teacher">
                                            Teacher
                                        </SelectItem>
                                        <SelectItem value="emp">
                                            Military (EMP)
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
        </div>


    </SuperAdmin>
</template>
