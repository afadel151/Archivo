<script setup>
import { Copy } from 'lucide-vue-next'
import { Button } from '@/Components/ui/button'
import { Search } from 'lucide-vue-next'
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
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
</script>



<template>
    <div class="flex justify-between items-center space-x-10 px-10 w-screen h-14">
        <ApplicationLogo class="w-10 h-10"/>
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
                <MenubarTrigger>File</MenubarTrigger>
                <MenubarContent>
                    <MenubarItem>
                        New Tab <MenubarShortcut>⌘T</MenubarShortcut>
                    </MenubarItem>
                    <MenubarItem>
                        New Window <MenubarShortcut>⌘N</MenubarShortcut>
                    </MenubarItem>
                    <MenubarItem disabled>
                        New Incognito Window
                    </MenubarItem>
                    <MenubarSeparator />
                    <MenubarSub>
                        <MenubarSubTrigger>Share</MenubarSubTrigger>
                        <MenubarSubContent>
                            <MenubarItem>Email link</MenubarItem>
                            <MenubarItem>Messages</MenubarItem>
                            <MenubarItem>Notes</MenubarItem>
                        </MenubarSubContent>
                    </MenubarSub>
                    <MenubarSeparator />
                    <MenubarItem>
                        Print... <MenubarShortcut>⌘P</MenubarShortcut>
                    </MenubarItem>
                </MenubarContent>
            </MenubarMenu>
            <MenubarMenu>
                <MenubarTrigger>Edit</MenubarTrigger>
                <MenubarContent>
                    <MenubarItem>
                        Undo <MenubarShortcut>⌘Z</MenubarShortcut>
                    </MenubarItem>
                    <MenubarItem>
                        Redo <MenubarShortcut>⇧⌘Z</MenubarShortcut>
                    </MenubarItem>
                    <MenubarSeparator />
                    <MenubarSub>
                        <MenubarSubTrigger>Find</MenubarSubTrigger>
                        <MenubarSubContent>
                            <MenubarItem>Search the web</MenubarItem>
                            <MenubarSeparator />
                            <MenubarItem>Find...</MenubarItem>
                            <MenubarItem>Find Next</MenubarItem>
                            <MenubarItem>Find Previous</MenubarItem>
                        </MenubarSubContent>
                    </MenubarSub>
                    <MenubarSeparator />
                    <MenubarItem>Cut</MenubarItem>
                    <MenubarItem>Copy</MenubarItem>
                    <MenubarItem>Paste</MenubarItem>
                </MenubarContent>
            </MenubarMenu>
            <MenubarMenu>
                <MenubarTrigger>View</MenubarTrigger>
                <MenubarContent>
                    <MenubarCheckboxItem>Always Show Bookmarks Bar</MenubarCheckboxItem>
                    <MenubarCheckboxItem checked>
                        Always Show Full URLs
                    </MenubarCheckboxItem>
                    <MenubarSeparator />
                    <MenubarItem inset>
                        Reload <MenubarShortcut>⌘R</MenubarShortcut>
                    </MenubarItem>
                    <MenubarItem disabled inset>
                        Force Reload <MenubarShortcut>⇧⌘R</MenubarShortcut>
                    </MenubarItem>
                    <MenubarSeparator />
                    <MenubarItem inset>
                        Toggle Fullscreen
                    </MenubarItem>
                    <MenubarSeparator />
                    <MenubarItem inset>
                        Hide Sidebar
                    </MenubarItem>
                </MenubarContent>
            </MenubarMenu>
            <MenubarMenu>
                <MenubarTrigger>Profiles</MenubarTrigger>
                <MenubarContent>
                    <MenubarRadioGroup value="benoit">
                        <MenubarRadioItem value="andy">
                            Andy
                        </MenubarRadioItem>
                        <MenubarRadioItem value="benoit">
                            Benoit
                        </MenubarRadioItem>
                        <MenubarRadioItem value="Luis">
                            Luis
                        </MenubarRadioItem>
                    </MenubarRadioGroup>
                    <MenubarSeparator />
                    <MenubarItem inset>
                        Edit...
                    </MenubarItem>
                    <MenubarSeparator />
                    <MenubarItem inset>
                        Add Profile...
                    </MenubarItem>
                </MenubarContent>
            </MenubarMenu>
        </Menubar>

    </div>
</template>