<?php

namespace App\JsonApi\Authorizers;

use CloudCreativity\LaravelJsonApi\Auth\AbstractAuthorizer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class DefaultAuthorizer extends AbstractAuthorizer
{
    /**
     * Authorize a resource index request.
     *
     * @param string  $type
     *                         the domain record type.
     * @param Request $request
     *                         the inbound request.
     *
     * @throws AuthenticationException|AuthorizationException
     *                                                        if the request is not authorized.
     *
     * @return void
     */
    public function index($type, $request)
    {
        $this->can('index', $type, $request);
    }

    /**
     * Authorize a resource create request.
     *
     * @param string  $type
     *                         the domain record type.
     * @param Request $request
     *                         the inbound request.
     *
     * @throws AuthenticationException|AuthorizationException
     *                                                        if the request is not authorized.
     *
     * @return void
     */
    public function create($type, $request)
    {
        $this->can('create', $type, $request);
    }

    /**
     * Authorize a resource read request.
     *
     * @param object  $record
     *                         the domain record.
     * @param Request $request
     *                         the inbound request.
     *
     * @throws AuthenticationException|AuthorizationException
     *                                                        if the request is not authorized.
     *
     * @return void
     */
    public function read($record, $request)
    {
        $this->can('read', $record, $request);
    }

    /**
     * Authorize a resource update request.
     *
     * @param object  $record
     *                         the domain record.
     * @param Request $request
     *                         the inbound request.
     *
     * @throws AuthenticationException|AuthorizationException
     *                                                        if the request is not authorized.
     *
     * @return void
     */
    public function update($record, $request)
    {
        $this->can('update', $record, $request);
    }

    /**
     * Authorize a resource read request.
     *
     * @param object  $record
     *                         the domain record.
     * @param Request $request
     *                         the inbound request.
     *
     * @throws AuthenticationException|AuthorizationException
     *                                                        if the request is not authorized.
     *
     * @return void
     */
    public function delete($record, $request)
    {
        $this->can('delete', $record, $request);
    }

    /**
     * Authorize a read relationship request.
     *
     * This is used to authorize GET requests to relationship endpoints, i.e.:
     *
     * ```
     * GET /api/posts/1/comments
     * GET /api/posts/1/relationships/comments
     * ```
     *
     * `$record` will be the post domain record (object) and `$field` will be the string `comments`.
     *
     * @param object  $record
     *                         the domain record.
     * @param string  $field
     *                         the JSON API field name for the relationship.
     * @param Request $request
     *                         the inbound request.
     *
     * @throws AuthenticationException|AuthorizationException
     *                                                        if the request is not authorized.
     *
     * @return void
     */
    public function readRelationship($record, $field, $request)
    {
        $this->can('readRelationship', $record, $field, $request);
    }

    /**
     * Authorize a modify relationship request.
     *
     * This is used to authorize `POST`, `PATCH` and `DELETE` requests to relationship endpoints, i.e.:
     *
     * ```
     * POST /api/posts/1/relationships/comments
     * PATH /api/posts/1/relationships/comments
     * DELETE /api/posts/1/relationships/comments
     * ```
     *
     * `$record` will be the post domain record (object) and `$field` will be the string `comments`.
     *
     * @param object  $record
     *                         the domain record.
     * @param string  $field
     *                         the JSON API field name for the relationship.
     * @param Request $request
     *                         the inbound request.
     *
     * @throws AuthenticationException|AuthorizationException
     *                                                        if the request is not authorized.
     *
     * @return void
     */
    public function modifyRelationship($record, $field, $request)
    {
        $this->can('modifyRelationship', $record, $field, $request);
    }
}
