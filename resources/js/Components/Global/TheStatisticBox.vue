<script lang="ts" setup></script>

<template>
    <div class="intro-y box">
        <div class="flex flex-col items-center border-b border-slate-200/60 p-5 dark:border-darkmode-400 sm:flex-row">
            <div class="me-auto text-base font-medium rtl:font-semibold">
                <slot name="title"></slot>
            </div>
        </div>

        <div class="p-5">
            <slot name="chart"></slot>
        </div>
    </div>
</template>
