<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TimebuckTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TimebuckTable Test Case
 */
class TimebuckTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TimebuckTable
     */
    protected $Timebuck;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Timebuck',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Timebuck') ? [] : ['className' => TimebuckTable::class];
        $this->Timebuck = $this->getTableLocator()->get('Timebuck', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Timebuck);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TimebuckTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
