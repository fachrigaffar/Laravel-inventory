<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Transaction History',
        href: '/transaction-history',
    },
];

defineProps<{
    transactions: Array<{
        id: number;
        type: 'Incoming' | 'Outgoing';
        entity_name: string;
        product_name: string;
        product_stock: number | null;
        quantity: number;
        transaction_date: string;
        created_by;
    }>;
}>();

</script>

<template>
    <Head title="Transaction History" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg my-5 mx-5">
            <div class="px-6 py-4">
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-3">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">ID</th>
                        <th scope="col" class="px-6 py-3">Type</th>
                        <th scope="col" class="px-6 py-3">Supplier/Customer</th>
                        <th scope="col" class="px-6 py-3">Product</th>
                        <th scope="col" class="px-6 py-3">Quantity</th>
                        <th scope="col" class="px-6 py-3">Stock</th>
                        <th scope="col" class="px-6 py-3">Transaction Date</th>
                        <th scope="col" class="px-6 py-3">Created By</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="transaction in transactions" :key="transaction.id" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ transaction.id }}
                        </th>
                        <td class="px-6 py-4">
                            {{ transaction.type }}
                        </td>
                        <td class="px-6 py-4">
                            {{ transaction.entity_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ transaction.product_name }}
                        </td>
                        <td class="px-6 py-4">
                            {{ transaction.quantity }}
                        </td>
                        <td class="px-6 py-4">
                            {{ transaction.product_stock ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4">
                            {{ transaction.transaction_date}}
                        </td>
                        <td class="px-6 py-4">
                            {{ transaction.created_by}}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
