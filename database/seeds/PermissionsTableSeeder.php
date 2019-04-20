<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            // Organization Management
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Organization',
                'description' => 'Can modify organization settings',
                'slug'        => 'organization_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Delete Organization',
                'description' => 'Can delete organization from '.config('app.name'),
                'slug'        => 'organization_delete',
            ],

            // Memberships
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Memberships',
                'description' => 'Can modify memberships for the organization',
                'slug'        => 'memberships_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Memberships',
                'description' => 'Can view memberships that belong to the organization',
                'slug'        => 'memberships_read',
            ],

            // Membership Levels
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Membership Levels',
                'description' => 'Can modify membership levels for the organization',
                'slug'        => 'membership_levels_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Membership Levels',
                'description' => 'Can view membership levels that belong to the organization',
                'slug'        => 'membership_levels_read',
            ],

            // Membership Fees
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Membership Fees',
                'description' => 'Can modify membership fees for the organization',
                'slug'        => 'membership_fees_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Membership Fees',
                'description' => 'Can view membership fees that belong to the organization',
                'slug'        => 'membership_fees_read',
            ],

            // Handbooks
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Handbooks',
                'description' => 'Can modify handbooks for the organization',
                'slug'        => 'handbooks_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Handbooks',
                'description' => 'Can view handbooks that belong to the organization',
                'slug'        => 'handbooks_read',
            ],

            // Discounts
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Discounts',
                'description' => 'Can modify discounts for the organization',
                'slug'        => 'discounts_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Discounts',
                'description' => 'Can view discounts that belong to the organization',
                'slug'        => 'discounts_read',
            ],

            // Billing Conditions
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Billing Conditions',
                'description' => 'Can modify billing conditions for the organization',
                'slug'        => 'billing_conditions_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Billing Conditions',
                'description' => 'Can view billing conditions that belong to the organization',
                'slug'        => 'billing_conditions_read',
            ],

            // Doctrines
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Doctrines',
                'description' => 'Can modify doctrines for the organization',
                'slug'        => 'doctrines_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Doctrines',
                'description' => 'Can view doctrines that belong to the organization',
                'slug'        => 'doctrines_read',
            ],

            // Fittings
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Fittings',
                'description' => 'Can modify fittings for the organization',
                'slug'        => 'fittings_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Fittings',
                'description' => 'Can view fittings that belong to the organization',
                'slug'        => 'fittings_read',
            ],

            // Replacement Claims
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Replacement Claims',
                'description' => 'Can modify replacement claims for the organization',
                'slug'        => 'replacement_claims_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Replacement Claims',
                'description' => 'Can view replacement claims that belong to the organization',
                'slug'        => 'replacement_claims_read',
            ],

            // Issued Invoices
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Issued Invoices',
                'description' => 'Can modify invoices on behalf of the organization',
                'slug'        => 'issued_invoices_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Issued Invoices',
                'description' => 'Can view invoices that belong to the organization',
                'slug'        => 'issued_invoices_read',
            ],

            // Received Invoices
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Received Invoices',
                'description' => 'Can view invoices that were issued to the organization',
                'slug'        => 'received_invoices_read',
            ],

            // Roles
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Roles',
                'description' => 'Can modify roles for the organization',
                'slug'        => 'roles_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Roles',
                'description' => 'Can view roles that belong to the organization',
                'slug'        => 'roles_read',
            ],

            // Fleets
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Fleets',
                'description' => 'Can modify fleets for the organization',
                'slug'        => 'fleets_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Fleets',
                'description' => 'Can view fleets that belong to the organization',
                'slug'        => 'fleets_read',
            ],

            // Fleet Types
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Fleet Types',
                'description' => 'Can modify fleet types for the organization',
                'slug'        => 'fleet_types_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'View Fleet Types',
                'description' => 'Can view fleet types that belong to the organization',
                'slug'        => 'fleet_types_read',
            ],

            // Notifications
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Notifications',
                'description' => 'Can modify notifications for the organization',
                'slug'        => 'notifications_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Read Notifications',
                'description' => 'Can view notifications that belong to the organization',
                'slug'        => 'notifications_read',
            ],

            // Members
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Read Members',
                'description' => 'Can view members that belong to the organization',
                'slug'        => 'members_read',
            ],

            // Member Of
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Read Member Of',
                'description' => 'Can view the organization that this organization is a member of',
                'slug'        => 'member_of_read',
            ],

            // Subscriptions
            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Modify Subscriptions',
                'description' => 'Can modify subscriptions for the organization',
                'slug'        => 'subscriptions_modify',
            ],

            [
                'id'          => Str::orderedUuid(),
                'name'        => 'Read Subscriptions',
                'description' => 'Can view subscriptions that belong to the organization',
                'slug'        => 'subscriptions_read',
            ],
        ]);
    }
}
