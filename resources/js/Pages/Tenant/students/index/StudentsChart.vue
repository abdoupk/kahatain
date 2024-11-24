<script lang="ts" setup></script>

<template>
    <!-- BEGIN: Students Chart -->
    <div class="col-span-3 mt-8">
        <div class="intro-y flex h-10 items-center">
            <h2 class="me-5 truncate text-lg font-medium">Sales Report</h2>
        </div>

        <div
            class="intro-y relative mt-5 before:absolute before:inset-x-0 before:mx-auto before:mt-2.5 before:hidden before:h-full before:w-[90%] before:rounded-md before:bg-white/60 before:shadow-[0px_3px_5px_#0000000b] before:content-[''] before:dark:bg-darkmode-400/70 xl:before:block"
        >
            <div class="box p-5">
                <div class="mt-3">chart here</div>

                <div class="mx-auto mt-8 w-52 sm:w-auto">
                    <div class="flex items-center">
                        <div class="me-3 h-2 w-2 rounded-full bg-primary"></div>
                        <span class="truncate">17 - 30 Years old</span>
                        <span class="ms-auto font-medium">62%</span>
                    </div>

                    <div class="mt-4 flex items-center">
                        <div class="me-3 h-2 w-2 rounded-full bg-pending"></div>
                        <span class="truncate">31 - 50 Years old</span>
                        <span class="ms-auto font-medium">33%</span>
                    </div>

                    <div class="mt-4 flex items-center">
                        <div class="me-3 h-2 w-2 rounded-full bg-warning"></div>

                        <span class="truncate">&gt;= 50 Years old</span>

                        <span class="ms-auto font-medium">10%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Students Chart -->
</template>
