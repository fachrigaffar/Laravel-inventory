<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm} from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Outgoing Transactions Edit',
        href: '/outgoing-transactions',
    },
];

const props = defineProps({
    customers: {
        type: Array as () => Array<{ id: number; name: string }>,
        required: true,
    },
    products: {
        type: Array as () => Array<{ id: number; name: string }>,
        required: true,
    },
    transaction: {
        type: Object as () => { [key: string]: any },
        required: true,
    },
});

const form = useForm({
    customer_id: props.transaction.customer_id,
    product_id: props.transaction.product_id,
    quantity: props.transaction.quantity,
    transaction_date: props.transaction.transaction_date,
});
</script>

<template>
    <Head title="Outgoing Transactions Edit" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="overflow-x-auto shadow-md sm:rounded-lg my-5 mx-5">
            <div class="px-6 py-4">
                <Link
                    :href="route('outgoing-transactions.index')"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Back
                </Link>
            </div>
            <form @submit.prevent="form.put(route('outgoing-transactions.update', transaction.id))" class="space-y-4 mx-5 my-5">
                <div>
                    <label for="customer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Customer</label>
                    <select v-model="form.customer_id" id="customer" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        <option value="" disabled selected>Select a customer</option>
                        <option v-for="customer in customers" :key="customer.id" :value="customer.id">{{ customer.name }}</option>
                    </select>
                    <p v-if="form.errors.customer_id" class="text-red-500 text-sm mt-1">{{ form.errors.customer_id }}</p>
                </div>
                <div>
                    <label for="product" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product</label>
                    <select v-model="form.product_id" id="product" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                        <option value="" disabled selected>Select a product</option>
                        <option v-for="product in products" :key="product.id" :value="product.id">{{ product.name }}</option>
                    </select>
                    <p v-if="form.errors.product_id" class="text-red-500 text-sm mt-1">{{ form.errors.product_id }}</p>
                </div>
                <div>
                    <label for="quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                    <input v-model="form.quantity" type="number" id="quantity" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Enter quantity" required>
                    <p v-if="form.errors.quantity" class="text-red-500 text-sm mt-1">{{ form.errors.quantity }}</p>
                </div>
                <div>
                    <label for="transactionDate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Transaction Date</label>
                    <input v-model="form.transaction_date" type="date" id="transactionDate" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                    <p v-if="form.errors.transaction_date" class="text-red-500 text-sm mt-1">{{ form.errors.transaction_date }}</p>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Update Transaction
                </button>
            </form>
        </div>
    </AppLayout>
</template>
