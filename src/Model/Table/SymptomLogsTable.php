<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SymptomLogs Model
 *
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 * @property \App\Model\Table\SymptomTypesTable&\Cake\ORM\Association\BelongsToMany $SymptomTypes
 *
 * @method \App\Model\Entity\SymptomLog newEmptyEntity()
 * @method \App\Model\Entity\SymptomLog newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SymptomLog> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SymptomLog get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SymptomLog findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SymptomLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SymptomLog> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SymptomLog|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SymptomLog saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SymptomLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SymptomLog>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SymptomLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SymptomLog> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SymptomLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SymptomLog>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SymptomLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SymptomLog> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SymptomLogsTable extends Table
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

        $this->setTable('symptom_logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('SymptomTypes', [
            'foreignKey' => 'symptom_log_id',
            'targetForeignKey' => 'symptom_type_id',
            'joinTable' => 'symptom_logs_symptom_types',
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
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->dateTime('logged_at')
            ->requirePresence('logged_at', 'create')
            ->notEmptyDateTime('logged_at');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

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

        return $rules;
    }
}
