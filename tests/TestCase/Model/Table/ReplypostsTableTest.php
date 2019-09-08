<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReplypostsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReplypostsTable Test Case
 */
class ReplypostsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReplypostsTable
     */
    public $Replyposts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Replyposts',
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
        $config = TableRegistry::getTableLocator()->exists('Replyposts') ? [] : ['className' => ReplypostsTable::class];
        $this->Replyposts = TableRegistry::getTableLocator()->get('Replyposts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Replyposts);

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
