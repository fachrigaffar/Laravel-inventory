<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Suppliers Show',
        href: '/suppliers',
    },
];

const props = defineProps({
    supplier: {
        type: Object,
        required: true,
    },
})

</script>

<template>
    <Head title="Suppliers Show" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="overflow-x-auto shadow-md sm:rounded-lg my-5 mx-5">
            <div class="px-6 py-4">
                <Link
                    :href="route('suppliers.index')"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Back
                </Link>
            </div>
            <div class="space-y-4 mx-5 my-5">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Supplier Name</label>
                    <p class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                        {{ supplier.name }}
                    </p>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
