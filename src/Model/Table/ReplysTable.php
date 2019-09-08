<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Replys Model
 *
 * @property \App\Model\Table\TweetsTable&\Cake\ORM\Association\BelongsTo $Tweets
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Reply get($primaryKey, $options = [])
 * @method \App\Model\Entity\Reply newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Reply[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reply|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reply saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Reply patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Reply[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reply findOrCreate($search, callable $callback = null, $options = [])
 */
class ReplysTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('replys');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tweets', [
            'foreignKey' => 'tweet_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('reply_content')
            ->allowEmptyString('reply_content');

        $validator
            ->scalar('reply_img')
            ->maxLength('reply_img', 255)
            ->allowEmptyString('reply_img');

        $validator
            ->dateTime('create_at')
            ->allowEmptyDateTime('create_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['tweet_id'], 'Tweets'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
