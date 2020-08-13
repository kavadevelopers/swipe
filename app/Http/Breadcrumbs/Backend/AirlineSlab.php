<?php

Breadcrumbs::register('admin.airlineslabs.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.airlineslabs.management'), route('admin.airlineslabs.index'));
});

Breadcrumbs::register('admin.airlineslabs.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.airlineslabs.index');
    $breadcrumbs->push(trans('menus.backend.airlineslabs.create'), route('admin.airlineslabs.create'));
});

Breadcrumbs::register('admin.airlineslabs.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.airlineslabs.index');
    $breadcrumbs->push(trans('menus.backend.airlineslabs.edit'), route('admin.airlineslabs.edit', $id));
});
