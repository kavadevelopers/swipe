<?php

Breadcrumbs::register('admin.partnerredemptions.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.partnerredemptions.management'), route('admin.partnerredemptions.index'));
});

Breadcrumbs::register('admin.partnerredemptions.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.partnerredemptions.index');
    $breadcrumbs->push(trans('menus.backend.partnerredemptions.create'), route('admin.partnerredemptions.create'));
});

Breadcrumbs::register('admin.partnerredemptions.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.partnerredemptions.index');
    $breadcrumbs->push(trans('menus.backend.partnerredemptions.edit'), route('admin.partnerredemptions.edit', $id));
});
