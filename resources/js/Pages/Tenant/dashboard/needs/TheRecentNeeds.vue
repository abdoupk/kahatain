<script lang="ts" setup>
import type { RecentNeedsType } from '@/types/dashboard'

import 'swiper/css'
import { Autoplay, Navigation } from 'swiper/modules'
import { Swiper, SwiperSlide } from 'swiper/vue'

import NeedStatus from '@/Pages/Tenant/needs/index/NeedStatus.vue'

import BaseButton from '@/Components/Base/button/BaseButton.vue'
import SvgLoader from '@/Components/SvgLoader.vue'

defineProps<{
    recentNeeds: RecentNeedsType
}>()
</script>

<template>
    <div
        class="col-span-12 mt-3 md:col-span-6 xl:col-span-12 xl:col-start-1 xl:row-start-1 2xl:col-start-auto 2xl:row-start-auto"
    >
        <div class="intro-x flex h-10 items-center">
            <h2 class="me-auto truncate text-lg font-medium rtl:font-semibold">
                {{ $t('important notes') }}
            </h2>

            <base-button class="swiper-button-prev me-2 border-slate-300 px-2 text-slate-600 dark:text-slate-300">
                <svg-loader class="fill-current" name="icon-chevron-right"></svg-loader>
            </base-button>

            <base-button class="swiper-button-next me-2 border-slate-300 px-2 text-slate-600 dark:text-slate-300">
                <svg-loader class="fill-current" name="icon-chevron-left"></svg-loader>
            </base-button>
        </div>

        <div class="intro-x mt-5">
            <div class="box">
                <Swiper
                    v-if="recentNeeds.length > 0"
                    :autoplay="{
                        delay: 3000
                    }"
                    :loop="true"
                    :modules="[Navigation, Autoplay]"
                    :navigation="{
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    }"
                    :slides-per-view="1"
                    :speed="1000"
                >
                    <SwiperSlide v-for="need in recentNeeds" :key="need.id" class="p-5">
                        <div class="flex justify-between">
                            <div>
                                <div class="truncate text-base font-medium">{{ need.subject }}</div>

                                <div class="mt-1 text-slate-400">{{ need.date }}</div>
                            </div>

                            <need-status :status="need.status" class="h-fit w-fit"></need-status>
                        </div>

                        <div class="prose mt-1 !max-w-none text-justify text-slate-500">
                            {{ need.demand }}
                        </div>
                    </SwiperSlide>
                </Swiper>

                <div v-else class="box flex min-h-72 items-center justify-center p-5 text-lg text-slate-500">
                    {{ $t('no_recent_notes') }}
                </div>
            </div>
        </div>
    </div>
</template>
