<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PatientMeasurementsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PatientMeasurementsTable Test Case
 */
class PatientMeasurementsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PatientMeasurementsTable
     */
    protected $PatientMeasurements;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.PatientMeasurements',
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
        $config = $this->getTableLocator()->exists('PatientMeasurements') ? [] : ['className' => PatientMeasurementsTable::class];
        $this->PatientMeasurements = $this->getTableLocator()->get('PatientMeasurements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PatientMeasurements);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PatientMeasurementsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\PatientMeasurementsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
