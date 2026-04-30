<?php

declare(strict_types=1);

use Migrations\BaseSeed;

class ContentBlocksSeed extends BaseSeed
{
    public function run(): void
    {
        $data = [
            [
                'parent' => 'global',
                'label' => 'Website Title',
                'description' => 'Shown on the home page, as well as any tabs in the users browser.',
                'slug' => 'website-title',
                'type' => 'text',
                'value' => 'RespiraCare',
            ],
            [
                'parent' => 'global',
                'label' => 'Logo',
                'description' => 'Shown in the centre of the home page, and also in the top corner of all administration pages.',
                'slug' => 'logo',
                'type' => 'image',
            ],
            [
                'parent' => 'home',
                'label' => 'Home Page Hero Title',
                'description' => 'The main content shown in the centre of the home page.',
                'slug' => 'home-hero-title',
                'type' => 'html',
                'value' => '<h1 class="fs-2 mb-3">Your Dedicated Partner in <br><span>COPD Management</span></h1>',
            ],
        ];

        $table = $this->table('content_blocks');
        $table->insert($data)->save();
    }
}
