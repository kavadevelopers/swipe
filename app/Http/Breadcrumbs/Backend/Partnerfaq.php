<?php

Breadcrumbs::register('admin.partnerfaqs.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.partnerfaqs.management'), route('admin.partnerfaqs.index'));
});

Breadcrumbs::register('admin.partnerfaqs.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.partnerfaqs.index');
    $breadcrumbs->push(trans('menus.backend.partnerfaqs.create'), route('admin.partnerfaqs.create'));
});

Breadcrumbs::register('admin.partnerfaqs.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.partnerfaqs.index');
    $breadcrumbs->push(trans('menus.backend.partnerfaqs.edit'), route('admin.partnerfaqs.edit', $id));
});
