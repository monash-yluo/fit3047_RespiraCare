<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reminders Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Receivers
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Senders
 *
 * @method \App\Model\Entity\Reminder newEmptyEntity()
 * @method \App\Model\Entity\Reminder newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Reminder> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Reminder get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Reminder findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Reminder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Reminder> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Reminder|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Reminder saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Reminder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Reminder>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Reminder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Reminder> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Reminder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Reminder>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Reminder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Reminder> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RemindersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reminders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Receivers', [
            'foreignKey' => 'receiver_id',
            'className' => 'Users',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Senders', [
            'foreignKey' => 'sender_id',
            'className' => 'Users',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('receiver_id')
            ->notEmptyString('receiver_id');

        $validator
            ->integer('sender_id')
            ->allowEmptyString('sender_id');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['receiver_id'], 'Receivers'), ['errorField' => 'receiver_id']);
        $rules->add($rules->existsIn(['sender_id'], 'Senders'), ['errorField' => 'sender_id']);

        return $rules;
    }
}
