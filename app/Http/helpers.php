<?php

function getHW() {
    return 'Hello World!';
}

function getStore() {
    return \App\Models\StoreSettings::where('uuid', config('constants.store_uuid'))->firstOrFail();
}

function getTheme() {
    $file = file_get_contents(resource_path('/settings/default.json'));
    return json_decode($file, true);
}
