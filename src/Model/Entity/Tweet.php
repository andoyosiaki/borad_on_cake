<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tweet Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $content
 * @property string|null $tweet_img
 * @property int|null $maxpost
 * @property \Cake\I18n\FrozenTime|null $create_at
 * @property string|null $image_pass
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Reply[] $replys
 */
class Tweet extends Entity
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
        'user_id' => true,
        'content' => true,
        'tweet_img' => true,
        'maxpost' => true,
        'create_at' => true,
        'image_pass' => true,
        'user' => true,
        'replys' => true
    ];
}
