<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { ArrowLeftRight, LayoutGrid, ArrowRightLeft, Contact, History} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import { computed } from 'vue';

// Get the authenticated user from Inertia's page props
const page = usePage();
const user = computed(() => page.props.auth?.user);

// Check if user has admin role
const isAdmin = computed(() => {
    if (!user.value) return false;

    // Check using Spatie's role names collection
    if (user.value.roles && Array.isArray(user.value.roles)) {
        return user.value.roles.includes('admin');
    }

    return false;
});

// Alternative: Check by permissions instead of roles
const canManageSuppliers = computed(() => {
    if (!user.value) return false;

    if (user.value.permissions && Array.isArray(user.value.permissions)) {
        return user.value.permissions.includes('manage suppliers') ||
               user.value.permissions.includes('manage customers');
    }

    return false;
});

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: 'Suppliers',
        href: '/suppliers',
        icon: Contact,
        isAdmin: true,
    },
    {
        title: 'Customers',
        href: '/customers',
        icon: Contact,
        isAdmin: true,
    },
    {
        title: 'Transactions In',
        href: '/incoming-transactions',
        icon: ArrowLeftRight,
    },
    {
        title: 'Transactions Out',
        href: '/outgoing-transactions',
        icon: ArrowRightLeft,
    },
    {
        title: 'Transaction History',
        href: '/transaction-history',
        icon: History,
    },
];

const filteredMainNavItems = computed(() => {
    return mainNavItems.filter(item => {
        // If item requires admin role and user is not admin, hide it
        if (item.isAdmin && !isAdmin.value) {
            return false;
        }
        
        return true;
    });
});

const footerNavItems: NavItem[] = [
    // Add footer items here if needed
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="filteredMainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
