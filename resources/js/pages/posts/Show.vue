<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { index, show as showRoute } from '@/routes/posts';

type Post = {
  id: number; title: string; content: string; author: string;
  published: boolean; created_at_formated: string; updated_at_formated: string;
};

const props = defineProps<{ post: Post }>();
const breadcrumbs = [
  { title: 'Posts', href: index().url },
  { title: `Post #${props.post.id}`, href: showRoute(props.post.id).url },
];
</script>

<template>
  <Head :title="`Post #${props.post.id}`" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="mx-auto w-full max-w-3xl space-y-4">
        <div class="flex items-center justify-between">
          <h1 class="text-2xl font-semibold">{{ props.post.title }}</h1>
          <Link :href="index().url" class="text-sm underline">Back to list</Link>
        </div>
        <div class="text-sm text-neutral-500">
          Author: {{ props.post.author }} ·
          Created: {{ props.post.created_at_formated }} ·
          Updated: {{ props.post.updated_at_formated }} ·
          Published: {{ props.post.published ? 'Yes' : 'No' }}
        </div>
        <div class="prose max-w-none whitespace-pre-wrap">
          {{ props.post.content }}
        </div>
      </div>
    </div>
  </AppLayout>
</template>