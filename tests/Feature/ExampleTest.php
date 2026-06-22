<?php

it('returns a redirect to login', function () {
    $response = $this->get('/');

    $response->assertRedirect('/login');
});
