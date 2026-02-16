<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            // User & Member
            'user.view',
            'user.create',
            'user.update',
            'user.delete',

            'member.view',
            'member.create',
            'member.update',
            'member.delete',

            // Organization
            'division.view',
            'division.create',
            'division.update',
            'division.delete',

            'position.view',
            'position.create',
            'position.update',
            'position.delete',

            'board_member.view',
            'board_member.create',
            'board_member.update',
            'board_member.delete',

            // Event
            'event.view',
            'event.create',
            'event.update',
            'event.delete',

            'event_participant.view',
            'event_participant.create',
            'event_participant.update',
            'event_participant.delete',

            // Administrative
            'sip_recommendation.view',
            'sip_recommendation.create',
            'sip_recommendation.approve',
            'sip_recommendation.reject',

            'invoice.view',
            'invoice.create',
            'invoice.pay',

            'mutation.view',
            'mutation.create',

            // Atlas & Quiz
            'atlas.view',
            'atlas.create',
            'atlas.update',
            'atlas.delete',

            'quiz_answer.submit',
            'quiz_answer.view',

            // Store
            'product.view',
            'product.create',
            'product.update',
            'product.delete',

            'transaction.view',
            'transaction.create',
            'transaction.pay',

            // Content
            'article.view',
            'article.create',
            'article.update',
            'article.delete',
            'article.publish',

            'gallery.view',
            'gallery.create',
            'gallery.delete',

            'announcement.view',
            'announcement.create',
            'announcement.update',
            'announcement.delete',        
            ];
            foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
            ]);

            /**
         * =========================
         * DEFINE ROLES
         * =========================
         */
        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $memberRole = Role::firstOrCreate([
            'name' => 'member',
            'guard_name' => 'web',
        ]);

        $publicRole = Role::firstOrCreate([
            'name' => 'public',
            'guard_name' => 'web',
        ]);

        
        // ADMIN → ALL PERMISSIONS
        $adminRole->syncPermissions(Permission::all());

        // MEMBER PERMISSIONS
        $memberRole->syncPermissions([
            'member.view',
            'member.update',

            'event.view',
            'event_participant.create',

            'sip_recommendation.create',
            'sip_recommendation.view',

            'invoice.view',
            'invoice.pay',

            'mutation.view',

            'atlas.view',
            'quiz_answer.submit',

            'product.view',
            'transaction.create',
            'transaction.view',

            'article.view',
            'gallery.view',
            'announcement.view',
        ]);

        // PUBLIC (GUEST) PERMISSIONS
        $publicRole->syncPermissions([
            'event.view',
            'event_participant.create',

            'article.view',
            'gallery.view',
            'announcement.view',

        ]);

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole($adminRole);
        }
    }
}
