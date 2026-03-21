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
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\CliniciansTable&\Cake\ORM\Association\BelongsTo $Clinicians
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

        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Clinicians', [
            'foreignKey' => 'clinician_id',
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
            ->integer('patient_id')
            ->notEmptyString('patient_id');

        $validator
            ->integer('clinician_id')
            ->allowEmptyString('clinician_id');

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

        $validator
            ->dateTime('sent_at')
            ->allowEmptyDateTime('sent_at');

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
        $rules->add($rules->existsIn(['patient_id'], 'Patients'), ['errorField' => 'patient_id']);
        $rules->add($rules->existsIn(['clinician_id'], 'Clinicians'), ['errorField' => 'clinician_id']);

        return $rules;
    }
}
