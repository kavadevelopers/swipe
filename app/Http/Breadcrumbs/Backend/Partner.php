<?php

Breadcrumbs::register('admin.partners.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.partners.management'), route('admin.partners.index'));
});

Breadcrumbs::register('admin.partners.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.partners.index');
    $breadcrumbs->push(trans('menus.backend.partners.create'), route('admin.partners.create'));
});

Breadcrumbs::register('admin.partners.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.partners.index');
    $breadcrumbs->push(trans('menus.backend.partners.edit'), route('admin.partners.edit', $id));
});
