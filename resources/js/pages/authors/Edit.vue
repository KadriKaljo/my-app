<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Input from '@/components/ui/input/Input.vue';
import Label from '@/components/ui/label/Label.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { edit, update } from '@/routes/authors';
import { Head as InertiaHead, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

type Author = { id: number; first_name: string; last_name: string; date_of_birth: string };

const props = defineProps<{ author: Author }>();

const form = useForm({
  first_name: props.author.first_name,
  last_name: props.author.last_name,
  date_of_birth: props.author.date_of_birth,
});

// Read current ?page from URL so we can keep pagination position after save
const page = usePage();
const currentPage = computed(() => {
  const q = page.url.split('?')[1] ?? '';
  return new URLSearchParams(q).get('page') ?? undefined;
});

const submit = () =>
  form.put(
    update(props.author.id, { query: { page: currentPage.value ?? undefined } }).url,
  );
</script>

<template>
  <InertiaHead title="Edit Author" />
  <AppLayout :breadcrumbs="[{ title: 'Authors edit', href: edit(props.author.id).url }]">
    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
      <div class="mx-auto h-full w-full max-w-2xl p-4">
        <h3 class="text-lg font-medium">Author Edit</h3>
        <form @submit.prevent="submit">
          <div class="grid gap-4 mt-6">
            <div>
              <Label for="first_name">First Name</Label>
              <Input class="mt-1" id="first_name" v-model="form.first_name" />
              <InputError :message="form.errors.first_name"/>
            </div>
            <div>
              <Label for="last_name">Last Name</Label>
              <Textarea class="mt-1" id="last_name" v-model="form.last_name" />
              <InputError :message="form.errors.last_name" />
            </div>
            <div>
              <Label for="date_of_birth">Date of Birth</Label>
              <Input class="mt-1" id="date_of_birth" type="date" v-model="form.date_of_birth" />
              <InputError :message="form.errors.date_of_birth" />
            </div>
          </div>
          <div class="mt-6 flex justify-end">
            <Button type="submit">Save</Button>
          </div>
        </form>
      </div>
      
    </div>
  </AppLayout>
</template>