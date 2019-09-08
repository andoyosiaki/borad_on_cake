<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Replyposts Model
 *
 * @property \App\Model\Table\TweetsTable&\Cake\ORM\Association\BelongsTo $Tweets
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Replypost get($primaryKey, $options = [])
 * @method \App\Model\Entity\Replypost newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Replypost[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Replypost|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Replypost saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Replypost patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Replypost[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Replypost findOrCreate($search, callable $callback = null, $options = [])
 */
class ReplypostsTable extends Table
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

        $this->setTable('replyposts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tweets', [
            'foreignKey' => 'tweets_id',
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
            ->dateTime('re_create_at')
            ->requirePresence('re_create_at', 'create')
            ->notEmptyDateTime('re_create_at');

        $validator
            ->dateTime('re_modefied')
            ->notEmptyDateTime('re_modefied');

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
        $rules->add($rules->existsIn(['tweets_id'], 'Tweets'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
