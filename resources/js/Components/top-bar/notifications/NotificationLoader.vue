<script lang="ts" setup></script>

<template>
    <div v-for="index in 5" :key="index" class="mx-auto mt-5 w-full max-w-sm rounded-md first:mt-0">
        <div class="flex animate-pulse space-x-4">
            <div class="me-3 h-10 w-10 rounded-full bg-slate-300 dark:bg-darkmode-100"></div>

            <div class="flex-1 space-y-6 py-1">
                <div class="h-2 rounded bg-slate-300 dark:bg-darkmode-100"></div>

                <div class="space-y-3">
                    <div class="grid grid-cols-3 gap-4">
                        <div class="col-span-2 h-2 rounded bg-slate-300 dark:bg-darkmode-100"></div>

                        <div class="col-span-1 h-2 rounded bg-slate-300 dark:bg-darkmode-100"></div>
                    </div>

                    <div class="h-2 rounded bg-slate-300 dark:bg-darkmode-100"></div>
                </div>
            </div>
        </div>
    </div>
</template>
