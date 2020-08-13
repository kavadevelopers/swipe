<?php

Breadcrumbs::register('admin.worldwidezonecharts.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.worldwidezonecharts.management'), route('admin.worldwidezonecharts.index'));
});

Breadcrumbs::register('admin.worldwidezonecharts.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.worldwidezonecharts.index');
    $breadcrumbs->push(trans('menus.backend.worldwidezonecharts.create'), route('admin.worldwidezonecharts.create'));
});

Breadcrumbs::register('admin.worldwidezonecharts.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.worldwidezonecharts.index');
    $breadcrumbs->push(trans('menus.backend.worldwidezonecharts.edit'), route('admin.worldwidezonecharts.edit', $id));
});
