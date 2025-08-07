<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, router} from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Customer',
        href: '/customers',
    },
];
defineProps({
    customers: Array,
});

function deleteCustomer(id) {
    if (confirm('Are you sure you want to delete this customer?')) {
        router.delete(route('customers.destroy', id));
    }
}
</script>

<template>
    <Head title="Customers" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg my-5 mx-5">
            <div class="px-6 py-4">
                <Link
                    :href="route('customers.create')"
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
                    <tr v-for="customer in customers" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ customer.id }}
                        </th><th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ customer.name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ customer.phone }}
                        </td>
                        <td class="px-6 py-4">
                            {{ customer.address }}
                        </td>
                        <td class="px-6 py-4">
                            <Link
                                :href="route('customers.edit', customer.id)"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Edit
                            </Link>
                            <button
                                @click="deleteCustomer(customer.id)"
                                type="button"
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
