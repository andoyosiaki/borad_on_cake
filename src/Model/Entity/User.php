<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property string|null $icon
 * @property string|null $introduction
 * @property string|null $role
 * @property string $username
 * @property string $password
 *
 * @property \App\Model\Entity\Reply[] $replys
 * @property \App\Model\Entity\Tweet[] $tweets
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'icon' => true,
        'introduction' => true,
        'role' => true,
        'username' => true,
        'password' => true,
        'replys' => true,
        'tweets' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _setPassword($password)
    {
      return (new DefaultPasswordHasher)->hash($password);
    }
}
