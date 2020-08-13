<?php

Breadcrumbs::register('admin.userlists.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.userlists.management'), route('admin.userlists.index'));
});

Breadcrumbs::register('admin.userlists.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.userlists.index');
    $breadcrumbs->push(trans('menus.backend.userlists.create'), route('admin.userlists.create'));
});

Breadcrumbs::register('admin.userlists.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.userlists.index');
    $breadcrumbs->push(trans('menus.backend.userlists.edit'), route('admin.userlists.edit', $id));
});
