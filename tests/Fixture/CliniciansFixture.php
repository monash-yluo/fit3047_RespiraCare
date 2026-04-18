<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CliniciansFixture
 */
class CliniciansFixture extends TestFixture
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
                'user_id' => 1,
                'created' => '2026-04-18 04:06:55',
                'modified' => '2026-04-18 04:06:55',
            ],
        ];
        parent::init();
    }
}
