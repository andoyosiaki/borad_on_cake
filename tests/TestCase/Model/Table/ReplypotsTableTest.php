<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReplypotsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReplypotsTable Test Case
 */
class ReplypotsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReplypotsTable
     */
    public $Replypots;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Replypots',
        'app.Tweets',
        'app.Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Replypots') ? [] : ['className' => ReplypotsTable::class];
        $this->Replypots = TableRegistry::getTableLocator()->get('Replypots', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Replypots);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
