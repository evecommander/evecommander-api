<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            // Memberships
            [
                'name' => 'Add Memberships',
                'description' => 'Can add new memberships to the organization',
                'slug' => 'membership_add'
            ],

            [
                'name' => 'Delete Memberships',
                'description' => 'Can add delete memberships from the organization',
                'slug' => 'membership_delete'
            ],

            [
                'name' => 'Edit Memberships',
                'description' => 'Can edit memberships for the organization',
                'slug' => 'membership_edit'
            ],

            [
                'name' => 'View Memberships',
                'description' => 'Can view memberships for the organization',
                'slug' => 'membership_view'
            ],

            // Handbooks
            [
                'name' => 'Add Handbooks',
                'description' => 'Can add new handbooks to the organization',
                'slug' => 'handbook_add'
            ],

            [
                'name' => 'Delete Handbooks',
                'description' => 'Can delete handbooks from the organization',
                'slug' => 'handbook_edit'
            ],

            [
                'name' => 'Edit Handbooks',
                'description' => 'Can edit handbooks for the organization',
                'slug' => 'handbook_edit'
            ],

            [
                'name' => 'View Handbooks',
                'description' => 'Can edit handbooks for the organization',
                'slug' => 'handbook_edit'
            ],

            // Discounts

            // Billing Conditions

            // Doctrines

            // Settings

            // Replacement Claims

            // Invoice
        ]);
    }
}
