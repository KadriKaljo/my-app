<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import Pagination from '@/components/ui/pagination/Pagination.vue';
import PaginationEllipsis from '@/components/ui/pagination/PaginationEllipsis.vue';
import PaginationFirst from '@/components/ui/pagination/PaginationFirst.vue';
import PaginationLast from '@/components/ui/pagination/PaginationLast.vue';
import PaginationNext from '@/components/ui/pagination/PaginationNext.vue';
import PaginationPrevious from '@/components/ui/pagination/PaginationPrevious.vue';
import Table from '@/components/ui/table/Table.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import TableCaption from '@/components/ui/table/TableCaption.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { MoreVertical } from 'lucide-vue-next';
import { PaginationList, PaginationListItem } from 'reka-ui';
import {index, edit, destroy, show} from '@/routes/authors';

const formatDate = (iso: string) => {
    try {
        return new Date(iso).toLocaleDateString();
    } catch {
        return iso;
    }
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Authors',
        href: index().url,
    },
];

const onEdit = (author: Author) => {
  router.get(edit(author.id).url, { page: authors.current_page });
};

/* const deletePost = (postID: number) => {
   router.delete(destroy(postID)
}); */

    const onDelete = (author: Author) => {
    if (confirm('Delete this author?')) {
        router.delete(destroy(author.id).url, {
            preserveScroll: true, /* ei tööta, peaks viskama esilehele */
        });
    } 
};

    const onShow = (author: Author) => {
        router.get(show(author.id).url);  
};

interface PaginationLink {
    url: string | null;
    label: string;
    page?: number | null;
    active: boolean;
}

interface PaginatedResponse {
    current_page: number;
    data: Author[];
    first_page_url: string;
    from: number;
    last_page: number;
    last_page_url: string;
    links: PaginationLink[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
    total: number;
}

    type Author = {
    id: number;
    first_name: string;
    last_name: string;
    date_of_birth: string;
    created_at: string;
    updated_at: string;
};

const props = defineProps<{
    authors: PaginatedResponse;
}>();
const authors = props.authors;
</script>

<template>
    <Head title="Authors" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">

            <Table>
                <TableCaption>A list of your recent blog authors.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">ID</TableHead>
                        <TableHead>First Name</TableHead>
                        <TableHead>Last Name</TableHead>
                        <TableHead>Date of Birth</TableHead>
                        <TableHead class="text-right">Created at</TableHead>
                        <TableHead class="text-right">Updated at</TableHead>
                        <TableHead>
                            <span class="sr-only">Actions</span>
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="(author, index) in authors.data" :key="index">
                        <TableCell class="font-medium">{{ author.id }}</TableCell>
                        <TableCell>{{ author.first_name }}</TableCell>
                        <TableCell>{{ author.last_name }}</TableCell>
                        <TableCell>{{ author.date_of_birth }}</TableCell>
                        <TableCell class="text-right">{{ formatDate(author.created_at) }}</TableCell>
                        <TableCell class="text-right">{{ formatDate(author.updated_at) }}</TableCell>
                        <TableCell>
                            <div class="flex justify-end">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <Button size="icon" variant="ghost">
                                            <MoreVertical />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent>
                                        <DropdownMenuItem @click="onShow(author)">View</DropdownMenuItem> 
                                        <DropdownMenuItem @click="onEdit(author)">Edit</DropdownMenuItem> 
                                        <DropdownMenuSeparator />
                                        <DropdownMenuItem class="text-destrucvtive" @click="onDelete(author)">Delete</DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
            <Pagination
                v-slot="{ page }" 
            :page="authors.current_page"
            :items-per-page="authors.per_page" 
            :total="authors.total" 
            class="mt-2 w-full" 
            @update:page="(page) => router.get(index().url, {page: page})">
           <PaginationList v-slot="{ items }" class="flex items-center gap-1">
                    <PaginationFirst />
                    <PaginationPrevious />


                    <template v-for="(item, index) in items">
                        <PaginationListItem v-if="item.type === 'page'" :key="index" :value="item.value" as-child>
                            <Button class="h-10 w-10 p-0" :variant="item.value === page ? 'default' : 'outline'">
                                {{ item.value }}
                            </Button>
                        </PaginationListItem>
                        <PaginationEllipsis v-else :key="item.type" :index="index" />
                    </template>

                    <PaginationNext />
                    <PaginationLast />
                </PaginationList>
            </Pagination>
        </div>
    </AppLayout>
</template>
