<?php

Breadcrumbs::register('admin.faqs.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('User Faqs Management'), route('admin.faqs.index'));
});

Breadcrumbs::register('admin.faqs.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.faqs.index');
    $breadcrumbs->push(trans('User Faqs Create'), route('admin.faqs.create'));
});

Breadcrumbs::register('admin.faqs.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.faqs.index');
    $breadcrumbs->push(trans('User Faqs Edit'), route('admin.faqs.edit', $id));
});
