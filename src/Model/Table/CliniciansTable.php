<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clinicians Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\HasMany $Bookings
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\HasMany $Patients
 * @property \App\Model\Table\RemindersTable&\Cake\ORM\Association\HasMany $Reminders
 *
 * @method \App\Model\Entity\Clinician newEmptyEntity()
 * @method \App\Model\Entity\Clinician newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Clinician> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Clinician get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Clinician findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Clinician patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Clinician> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Clinician|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Clinician saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Clinician>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Clinician>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Clinician>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Clinician> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Clinician>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Clinician>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Clinician>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Clinician> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CliniciansTable extends Table
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

        $this->setTable('clinicians');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Bookings', [
            'foreignKey' => 'clinician_id',
        ]);
        $this->hasMany('Patients', [
            'foreignKey' => 'clinician_id',
        ]);
        $this->hasMany('Reminders', [
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
            ->integer('user_id')
            ->notEmptyString('user_id')
            ->add('user_id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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

        return $rules;
    }
}
