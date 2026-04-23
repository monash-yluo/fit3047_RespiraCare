<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PatientMeasurements Model
 *
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 *
 * @method \App\Model\Entity\PatientMeasurement newEmptyEntity()
 * @method \App\Model\Entity\PatientMeasurement newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PatientMeasurement> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PatientMeasurement get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PatientMeasurement findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PatientMeasurement patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PatientMeasurement> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PatientMeasurement|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PatientMeasurement saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PatientMeasurement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PatientMeasurement>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PatientMeasurement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PatientMeasurement> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PatientMeasurement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PatientMeasurement>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PatientMeasurement>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PatientMeasurement> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PatientMeasurementsTable extends Table
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

        $this->setTable('patient_measurements');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Patients', [
            'foreignKey' => 'patient_id',
            'joinType' => 'INNER',
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
            ->dateTime('measured_at')
            ->requirePresence('measured_at', 'create')
            ->notEmptyDateTime('measured_at');

        $validator
            ->integer('spo2')
            ->range('spo2', [50, 100])
            ->allowEmptyString('spo2');

        $validator
            ->integer('heart_rate')
            ->range('heart_rate', [0, 200])
            ->allowEmptyString('heart_rate');

        $validator
            ->numeric('temperature')
            ->range('temperature', [20, 50])
            ->allowEmptyString('temperature');

        $validator
            ->integer('respiratory_rate')
            ->range('respiratory_rate', [0, 100])
            ->allowEmptyString('respiratory_rate');

        $validator
            ->integer('peak_flow')
            ->range('peak_flow', [0, 1000])
            ->allowEmptyString('peak_flow');

        $validator
            ->integer('blood_pressure_systolic')
            ->range('blood_pressure_systolic', [0, 300])
            ->allowEmptyString('blood_pressure_systolic');

        $validator
            ->integer('blood_pressure_diastolic')
            ->range('blood_pressure_diastolic', [0, 200])
            ->allowEmptyString('blood_pressure_diastolic');

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
