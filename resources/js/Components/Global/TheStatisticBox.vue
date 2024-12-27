<script lang="ts" setup></script>

<template>
    <div class="intro-y box">
        <div class="flex flex-row items-center justify-between p-5 dark:border-darkmode-400 sm:flex-row 2xl:flex-col">
            <div class="me-auto w-full text-base font-medium rtl:font-semibold">
                <slot name="title"></slot>
            </div>

            <slot name="actions"></slot>
        </div>

        <div class="p-5">
            <slot name="chart"></slot>
        </div>
    </div>
</template>
