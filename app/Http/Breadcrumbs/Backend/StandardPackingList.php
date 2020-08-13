<?php

Breadcrumbs::register('admin.standardpackinglists.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.standardpackinglists.management'), route('admin.standardpackinglists.index'));
});

Breadcrumbs::register('admin.standardpackinglists.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.standardpackinglists.index');
    $breadcrumbs->push(trans('menus.backend.standardpackinglists.create'), route('admin.standardpackinglists.create'));
});

Breadcrumbs::register('admin.standardpackinglists.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.standardpackinglists.index');
    $breadcrumbs->push(trans('menus.backend.standardpackinglists.edit'), route('admin.standardpackinglists.edit', $id));
});
