<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SymptomTypesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SymptomTypesTable Test Case
 */
class SymptomTypesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SymptomTypesTable
     */
    protected $SymptomTypes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.SymptomTypes',
        'app.SymptomLogs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SymptomTypes') ? [] : ['className' => SymptomTypesTable::class];
        $this->SymptomTypes = $this->getTableLocator()->get('SymptomTypes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SymptomTypes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\SymptomTypesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
