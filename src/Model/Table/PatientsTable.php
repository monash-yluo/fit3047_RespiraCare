<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Model\Validation\TimeWindowValidation;

/**
 * Patients Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CliniciansTable&\Cake\ORM\Association\BelongsTo $Clinicians
 * @property \App\Model\Table\AiInsightsTable&\Cake\ORM\Association\HasMany $AiInsights
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\HasMany $Bookings
 * @property \App\Model\Table\ContactMessagesTable&\Cake\ORM\Association\HasMany $ContactMessages
 * @property \App\Model\Table\PatientMeasurementsTable&\Cake\ORM\Association\HasMany $PatientMeasurements
 * @property \App\Model\Table\SymptomLogsTable&\Cake\ORM\Association\HasMany $SymptomLogs
 *
 * @method \App\Model\Entity\Patient newEmptyEntity()
 * @method \App\Model\Entity\Patient newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Patient> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Patient get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Patient findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Patient patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Patient> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Patient|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Patient saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Patient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Patient>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Patient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Patient> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Patient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Patient>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Patient>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Patient> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PatientsTable extends Table
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

        $this->setTable('patients');
        $this->setDisplayField('user_name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Clinicians', [
            'foreignKey' => 'clinician_id',
        ]);
        $this->hasMany('AiInsights', [
            'foreignKey' => 'patient_id',
        ]);
        $this->hasMany('Bookings', [
            'foreignKey' => 'patient_id',
        ]);
        $this->hasMany('ContactMessages', [
            'foreignKey' => 'patient_id',
        ]);
        $this->hasMany('PatientMeasurements', [
            'foreignKey' => 'patient_id',
        ]);
        $this->hasMany('SymptomLogs', [
            'foreignKey' => 'patient_id',
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
        $validator->setProvider('timeWindow', TimeWindowValidation::class);

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id')
            ->add('user_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('clinician_id')
            ->allowEmptyString('clinician_id');

        $validator
            ->date('dob')
            ->allowEmptyDate('dob')
            ->add('dob', 'notInFuture', [
                'rule' => ['notInFuture'],
                'provider' => 'timeWindow',
                'message' => 'Date of birth cannot be in the future.'
            ])
            ->add('dob', 'notTooOld', [
                'rule' => ['withinLastYears', 120],
                'provider' => 'timeWindow',
                'message' => 'Date of birth must be within the last 120 years.'
            ]);

        $validator
            ->scalar('sex')
            ->maxLength('sex', 50)
            ->allowEmptyString('sex');

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
        $rules->add($rules->isUnique(['user_id']), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['clinician_id'], 'Clinicians'), ['errorField' => 'clinician_id']);

        return $rules;
    }
}
