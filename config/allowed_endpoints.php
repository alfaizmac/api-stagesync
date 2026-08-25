<?php

/**
 * The allowlist for what this API's docs-search endpoint will ever
 * disclose to a caller. Same idea as my-chatbot-site's old
 * config/api_docs.php: default-deny, nothing here is visible unless
 * its "METHOD /path" line is explicitly added.
 *
 * This now lives HERE, in api-stagesync, because this is the project
 * that actually owns the API and the spec. dashboard-chatbot-site (or
 * any other consumer) never sees this file directly -- it only ever
 * gets back whatever /internal/docs/search decides to return.
 */
return [
    'POST /v3/accounts/unlink',
    'GET /v3/accounts/me',
    'GET /v3/categories/{applicationId}',
    'GET /v3/categories/{applicationId}/{categoryId}/products',
    'GET /v3/contacts/{applicationId}',
    'GET /v3/equipment/{identifier}',
    'GET /v3/events/{categoryId}',
    'GET /v3/export/{format}/{id}',
    'GET /v3/filters/dealers/{manufacturerId}',
    'GET /v3/firmware/{product_id}/latest',
    'GET /v3/fixture/list',
    'GET /v3/fixture/manufacturers',
    'GET /v3/fixture/types',
    'GET /v3/fixture/{fxId}/lamps',
    'GET /v3/fixture/{id}/details',
    'GET /v3/fixture/{id}/export-svg',
    'GET /v3/fixture/{id}/export-svg-enc',
    'GET /v3/fixture/{id}/symbol',
    'GET /v3/fixtures/export-svg-batch',
    'GET /v3/fixtures/export-svg-batch-enc',
    'GET /v3/fixtures/updated-since',
    'GET /v3/lamp/basetypes',
    'GET /v3/lamp/compatible',
    'GET /v3/lamp/manufacturers',
    'GET /v3/lamp/search',
    'GET /v3/lamp/{bulbId}',
    'GET /v3/library/product-request/fields',
    'GET /v3/manufacturers/{manufacturerId}/dealers',
    'GET /v3/manufacturers/{manufacturerId}/products',
    'GET /v3/news/{applicationId}/categories',
    'GET /v3/news/{applicationId}/categories/{categoryId}/items',
    'GET /v3/news/{applicationId}/latest',
    'GET /v3/notifications',
    'GET /v3/organizations/{organizationId}',
    'GET /v3/organizations/{organizationId}/fixtures',
    'GET /v3/organizations/{organizationId}/manufacturers',
    'GET /v3/organizations/{organizationId}/producttypes',
    'GET /v3/organizations/{organizationId}/producttypes/{typeId}/products',
    'GET /v3/products',
    'GET /v3/products/changed-since',
    'GET /v3/products/file-sync-live',
    'GET /v3/products/live-tail',
    'GET /v3/products/secure-sync',
    'GET /v3/products/{id}/symbol',
    'GET /v3/products/{productId}',
    'GET /v3/profiles/{file_id}/download',
    'GET /v3/projector/lamps/categories',
    'GET /v3/projector/lamps/manufacturers',
    'GET /v3/projector/lamps/search',
    'GET /v3/reports/product-usage/{clientId}',
    'GET /v3/search/categories/types',
    'GET /v3/search/equipment',
    'GET /v3/stream-logs',
    'GET /v3/stream-product-analytics',
    'GET /v3/utils/key',
];
