<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ReplysTable&\Cake\ORM\Association\HasMany $Replys
 * @property \App\Model\Table\TweetsTable&\Cake\ORM\Association\HasMany $Tweets
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Replys', [
            'foreignKey' => 'user_id',
            'dependent' => true
        ]);
        $this->hasMany('Tweets', [
            'foreignKey' => 'user_id',
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
        $validator->setProvider('ProviderKey', 'App\Model\Validation\CustomValidation');

        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 255)
            ->allowEmptyString('icon');

        $validator
            ->scalar('introduction')
            ->maxLength('introduction', 200,'２００文字以内でおねがいします。')
            ->allowEmptyString('introduction');

        $validator
            ->scalar('role')
            ->maxLength('role', 255)
            ->allowEmptyString('role');

        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username', 'create')
            ->notEmptyString('username')->add('username', 'ruleName', [
            'rule' => ['postal_codeCustom'],
            'provider' => 'ProviderKey',
            'message' => 'ログインIDは半角英数字で入力してください。'])
            ->lengthBetween('username', [4, 10], 'アカウント名は4文字以上、10文字以内でおねがいします。');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password')->add('password', 'ruleName', [
            'rule' => ['postal_codeCustom'],
            'provider' => 'ProviderKey',
            'message' => 'ログインパスワードは半角英数字で入力してください。'])
            ->lengthBetween('password', [4, 10], 'パスワードは4文字以上、10文字以内でおねがいします');

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
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }
}
