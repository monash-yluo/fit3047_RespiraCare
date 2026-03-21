<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AiInsightsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AiInsightsTable Test Case
 */
class AiInsightsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AiInsightsTable
     */
    protected $AiInsights;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.AiInsights',
        'app.Patients',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('AiInsights') ? [] : ['className' => AiInsightsTable::class];
        $this->AiInsights = $this->getTableLocator()->get('AiInsights', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AiInsights);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\AiInsightsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\AiInsightsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
