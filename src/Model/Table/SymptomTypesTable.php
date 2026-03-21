<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SymptomTypes Model
 *
 * @property \App\Model\Table\SymptomLogsTable&\Cake\ORM\Association\BelongsToMany $SymptomLogs
 *
 * @method \App\Model\Entity\SymptomType newEmptyEntity()
 * @method \App\Model\Entity\SymptomType newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SymptomType> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SymptomType get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SymptomType findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SymptomType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SymptomType> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SymptomType|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SymptomType saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SymptomType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SymptomType>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SymptomType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SymptomType> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SymptomType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SymptomType>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SymptomType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SymptomType> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SymptomTypesTable extends Table
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

        $this->setTable('symptom_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('SymptomLogs', [
            'foreignKey' => 'symptom_type_id',
            'targetForeignKey' => 'symptom_log_id',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }
}
