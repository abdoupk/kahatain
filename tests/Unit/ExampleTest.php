<?php

use function Pest\Laravel\get;

test('that true is true', function () {
    get('/register')->assertStatus(200);
});
