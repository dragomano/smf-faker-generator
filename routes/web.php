<?php

Route::get('/admin/pages/generate-slug', function () {
    return response()->json([
        'slug' => Str::slug(request('title', ''))
    ]);
});
