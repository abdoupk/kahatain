<?php

Schedule::command('calculate:families-income-rate')
    ->name('Calculate families income rate')
    ->yearlyOn(9, 1, '00:00');

Schedule::command('calculate:families-income-rate')
    ->name('Calculate families income rate')
    ->yearlyOn(6, 1, '00:00');

Schedule::command('unSearch:orphans-older-than-two-years')
    ->name('UnSearch orphans older than two years')
    ->dailyAt('00:00');

Schedule::command('clean:completed-benefactor-sponsorships')
    ->name('Clean completed benefactor sponsorships and update families incomes')
    ->dailyAt('00:00');

Schedule::command('app:delete-temp-uploaded-files')
    ->name('Delete temp uploaded files')
    ->dailyAt('00:00');

Schedule::command('fetch:schools')
    ->name('Fetch schools')
    ->yearlyOn(1, 1, '00:00');

Schedule::command('fetch:vocational-training-centers')
    ->name('Fetch vocational training centers')
    ->yearlyOn(1, 1, '00:00');
