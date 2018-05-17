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
        $this->can('index', $type);
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
        $this->can('create', $type);
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
        $this->can('read', $record);
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
        $this->can('update', $record);
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
        $this->can('delete', $record);
    }
}
