<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reply Entity
 *
 * @property int $id
 * @property int $tweet_id
 * @property int $user_id
 * @property string|null $reply_content
 * @property string|null $reply_img
 * @property \Cake\I18n\FrozenTime|null $create_at
 *
 * @property \App\Model\Entity\Tweet $tweet
 * @property \App\Model\Entity\User $user
 */
class Reply extends Entity
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
        'tweet_id' => true,
        'user_id' => true,
        'reply_content' => true,
        'reply_img' => true,
        'create_at' => true,
        'tweet' => true,
        'user' => true
    ];
}
