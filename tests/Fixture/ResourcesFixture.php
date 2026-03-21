<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ResourcesFixture
 */
class ResourcesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'published_date' => '2026-03-21',
                'type' => 'Lorem ipsum dolor sit amet',
                'url_link' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'created' => '2026-03-21 04:37:46',
                'modified' => '2026-03-21 04:37:46',
            ],
        ];
        parent::init();
    }
}
