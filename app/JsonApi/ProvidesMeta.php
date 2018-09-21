<?php

namespace App\JsonApi;

use App\Contracts\HasHandbooksContract;
use App\Contracts\HasMembersContract;
use App\Contracts\HasNotificationsContract;
use App\Contracts\HasRolesContract;
use App\Contracts\HasSRPContract;
use App\Contracts\HasSubscriptionsContract;
use App\Contracts\IsMemberContract;
use App\Contracts\IssuesInvoicesContract;
use App\Contracts\ReceivesInvoicesContract;

trait ProvidesMeta
{
    protected function notificationsCounts(HasNotificationsContract $model): array
    {
        return [
            'count'        => $model->notifications->count(),
            'count_read'   => $model->readNotifications->count(),
            'count_unread' => $model->unreadNotifications->count(),
        ];
    }

    protected function receivedInvoicesCounts(ReceivesInvoicesContract $model): array
    {
        return [
            'count'           => $model->receivedInvoices->count(),
            'count_fulfilled' => $model->fulfilledReceivedInvoices->count(),
            'count_overdue'   => $model->overdueReceivedInvoices->count(),
            'count_pending'   => $model->pendingReceivedInvoices->count(),
            'count_default'   => $model->defaultReceivedInvoices->count(),
        ];
    }

    protected function issuedInvoicesCounts(IssuesInvoicesContract $model): array
    {
        return [
            'count'           => $model->invoices->count(),
            'count_fulfilled' => $model->fulfilledInvoices->count(),
            'count_overdue'   => $model->overdueInvoices->count(),
            'count_pending'   => $model->pendingInvoices->count(),
            'count_default'   => $model->defaultInvoices->count(),
        ];
    }

    protected function replacementClaimsCounts(HasSRPContract $model): array
    {
        return [
            'count'           => $model->replacementClaims->count(),
            'count_pending'   => $model->pendingReplacementClaims->count(),
            'count_closed'    => $model->closedReplacementClaims->count(),
            'count_accepted'  => $model->acceptedReplacementClaims->count(),
            'count_contested' => $model->contestedReplacementClaims->count(),
            'count_payed'     => $model->payedReplacementClaims->count(),
        ];
    }

    protected function membershipsCount(IsMemberContract $model): array
    {
        return [
            'count' => $model->memberships->count(),
        ];
    }

    protected function membershipLevelsCount(HasMembersContract $model): array
    {
        return [
            'count' => $model->membershipLevels->count(),
        ];
    }

    protected function membersCount(HasMembersContract $model): array
    {
        return [
            'count' => $model->members->count(),
        ];
    }

    protected function rolesCount(HasRolesContract $model): array
    {
        return [
            'count' => $model->roles->count(),
        ];
    }

    protected function subscriptionsCount(HasSubscriptionsContract $model): array
    {
        return [
            'count' => $model->subscriptions->count(),
        ];
    }

    protected function handbooksCount(HasHandbooksContract $model): array
    {
        return [
            'count' => $model->handbooks->count(),
        ];
    }
}
