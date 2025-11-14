<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { index, show as showRoute } from '@/routes/authors';

type Author = {
  id: number; first_name: string; last_name: string; date_of_birth: string; active: boolean;    
};

const props = defineProps<{ author: Author }>();
const breadcrumbs = [
  { title: 'Authors', href: index().url },
  { title: `Author #${props.author.id}`, href: showRoute(props.author.id).url },
];
</script>

<template>
  <Head :title="`Author #${props.author.id}`" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="mx-auto w-full max-w-3xl space-y-4">
        <div class="flex items-center justify-between">
          <h1 class="text-2xl font-semibold">{{ props.author.first_name }} {{ props.author.last_name }}</h1>
          <Link :href="index().url" class="text-sm underline">Back to list</Link>
        </div>
        <div class="text-sm text-neutral-500">
          Date of Birth: {{ props.author.date_of_birth }} ·
          Active: {{ props.author.active ? 'Yes' : 'No' }}
        </div>
      </div>
    </div>
  </AppLayout>
</template>