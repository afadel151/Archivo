<script setup>
const props = defineProps(
    {
        users: {
            type: Array,
            required: true
        }
    }
)
const users = props.users;
import Button from '@/Components/ui/button/Button.vue';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/Components/ui/table';
import SuperAdmin from '@/Layouts/SuperAdmin.vue';

</script>
<template>
    <SuperAdmin>
    <div class="flex flex-col justify-center items-center p-20">
        <h1 class="scroll-m-20 font-extrabold text-4xl lg:text-5xl tracking-tight">
            Super Admin / Admin users
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
</SuperAdmin>
</template>