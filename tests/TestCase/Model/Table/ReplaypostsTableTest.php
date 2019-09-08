<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReplaypostsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReplaypostsTable Test Case
 */
class ReplaypostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReplaypostsTable
     */
    public $Replayposts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Replayposts',
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
        $config = TableRegistry::getTableLocator()->exists('Replayposts') ? [] : ['className' => ReplaypostsTable::class];
        $this->Replayposts = TableRegistry::getTableLocator()->get('Replayposts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Replayposts);

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
