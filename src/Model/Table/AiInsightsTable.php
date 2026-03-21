<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AiInsights Model
 *
 * @property \App\Model\Table\PatientsTable&\Cake\ORM\Association\BelongsTo $Patients
 *
 * @method \App\Model\Entity\AiInsight newEmptyEntity()
 * @method \App\Model\Entity\AiInsight newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\AiInsight> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AiInsight get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\AiInsight findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\AiInsight patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\AiInsight> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AiInsight|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\AiInsight saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\AiInsight>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AiInsight>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AiInsight>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AiInsight> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AiInsight>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AiInsight>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\AiInsight>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\AiInsight> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AiInsightsTable extends Table
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

        $this->setTable('ai_insights');
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
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->integer('risk_level')
            ->requirePresence('risk_level', 'create')
            ->notEmptyString('risk_level');

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
