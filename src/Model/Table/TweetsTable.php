<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tweets Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ReplysTable&\Cake\ORM\Association\HasMany $Replys
 *
 * @method \App\Model\Entity\Tweet get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tweet newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Tweet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tweet|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tweet saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tweet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tweet[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tweet findOrCreate($search, callable $callback = null, $options = [])
 */
class TweetsTable extends Table
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

        $this->setTable('tweets');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Replys', [
            'foreignKey' => 'tweet_id',
            'dependent' => true
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
            ->scalar('content')
            ->allowEmptyString('content');

        $validator
            ->scalar('tweet_img')
            ->maxLength('tweet_img', 255)
            ->allowEmptyString('tweet_img');

        $validator
            ->integer('maxpost')
            ->allowEmptyString('maxpost');

        $validator
            ->dateTime('create_at')
            ->allowEmptyDateTime('create_at');

        $validator
            ->scalar('image_pass')
            ->maxLength('image_pass', 255)
            ->allowEmptyFile('image_pass');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
