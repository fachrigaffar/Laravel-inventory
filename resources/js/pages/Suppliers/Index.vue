<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router} from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Suppliers',
        href: '/suppliers',
    },
];

defineProps({
    suppliers: Array,
});

function deleteSupplier(id) {
    if (confirm('Are you sure you want to delete this supplier?')) {
        router.delete(route('suppliers.destroy', id));
    }
}
</script>

<template>
    <Head title="Suppliers" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg my-5 mx-5">
            <div class="px-6 py-4">
                <Link
                    :href="route('suppliers.create')"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Create
                </Link>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-3">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Customer Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Phone Number
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Address
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="supplier in suppliers" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ supplier.id }}
                        </th><th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ supplier.name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ supplier.phone }}
                        </td>
                        <td class="px-6 py-4">
                            {{ supplier.address }}
                        </td>
                        <td class="px-6 py-4">
                            <!-- <Link
                                :href="route('suppliers.show', supplier.id)"
                                class="text-white bg-gray-700 hover:bg-gray-800 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                View
                            </Link> -->
                            <Link
                                :href="route('suppliers.edit', supplier.id)"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Edit
                            </Link>
                            <button
                                @click="deleteSupplier(supplier.id)"
                                class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
